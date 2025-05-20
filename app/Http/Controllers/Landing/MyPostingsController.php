<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Landing\CreatePostingRequest;
use App\Http\Requests\Landing\PostingFileUploadRequest;
use App\Models\CategoryModel;
use App\Models\PostingModel;
use App\Models\SubCategoryModel;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MyPostingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user     = auth('landing')->user();
        $postings = $user->postings()->with(['category','subCategory'])->paginate(10);
        $status   = session('status');

        return Inertia::render('Landing/MyPostings',compact('postings','status'));
    }

    /**
     * Show the form for creating a new resource.   
     */
    public function create()
    {    
        Gate::authorize('create-posting');

        $categories     = CategoryModel::with(['subCategories'])->get();
        $locations      = config('location');
        $status         = session('status');

        return Inertia::render('Landing/CreatePosting',compact('categories','locations','status'));
    }

    /**
     * Display the specified resource.
     */
    public function upload(PostingFileUploadRequest $request)
    {
        //
        $image = $request->file('image');
        $name  = Str::uuid().'.'.$image->getClientOriginalExtension();
        $image->move(storage_path('app/public/images'), $name);

        return response()->json(array('name' => $name ));
    }    

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostingRequest $request)
    {
        Gate::authorize('create-posting');
        
        try {
            $form = $request->validated();

            $form['category_id']     = explode('/', $form['category'])[0];
            $form['sub_category_id'] = explode('/', $form['category'])[1];

            $form['county']          = explode('-', $form['location'])[0];
            $form['town']            = explode('-', $form['location'])[1];

            $form['user_id']         = auth('landing')->user()->id;

            PostingModel::create($form);
            
            return back()->with('message', 'Posting created successfully');

        } catch(Error $error) {

            return back()->with('message', 'Something went wrong. Please try again.');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PostingModel $posting)
    {
        $posting->load(['category','subCategory']);
                               
        return Inertia::render('Landing/ViewMyPosting',compact('posting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

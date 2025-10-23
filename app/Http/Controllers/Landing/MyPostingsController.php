<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Landing\CreatePostingRequest;
use App\Http\Requests\Landing\CreatePromotionPostingRequest;
use App\Http\Requests\Landing\PostingFileUploadRequest;
use App\Http\Requests\Landing\QuotationUploadRequest;
use App\Models\CategoryModel;
use App\Models\PlacementModel;
use App\Models\PostingCategoryModel;
use App\Models\PostingModel;
use App\Models\PromotionModel;
use App\Models\SubCategoryModel;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Intervention\Image\Laravel\Facades\Image;  // facade

class MyPostingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user     = auth('client')->user();
        $postings = $user->postings()->paginate(10);
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
        $placements     = PlacementModel::get();
        $locations      = config('location');
        $status         = session('status');

        return Inertia::render('Landing/CreatePosting',compact('categories','locations','placements','status'));
    }

    /**
     * Display the specified resource.
     */
    public function imageUpload(PostingFileUploadRequest $request)
    {
        //
        $uploaded = $request->file('image');
        $name     = Str::uuid().'.'.$uploaded->getClientOriginalExtension();

        $image = Image::read($uploaded)->resize(1024, 480, function ($constraint) {
            $constraint->aspectRatio();
        });

        $image->save(storage_path('app/public/images'), $name);

        return response()->json(array('name' => $name ));
    }    

    /**
     * Display the specified resource.
     */
    public function quotationUpload(QuotationUploadRequest $request)
    {
        //
        $image = $request->file('quotation');
        $name  = Str::uuid().'.'.$image->getClientOriginalExtension();
        $image->move(storage_path('app/public/quotation'), $name);

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
            
            if( !empty($form['promotion_image']) ){
                $base64String = explode(',',$form['promotion_image']);
                $ext          = explode('/', explode(';',$base64String[0])[0])[1];
                $name         = Str::uuid().'.'.$ext;
                $file         = Storage::disk('public')->put('images/'.$name, base64_decode($base64String[1]));
                $form['promotion_image'] = $name;
            }

            $form['county']          = explode('-', $form['location'])[0];
            $form['town']            = explode('-', $form['location'])[1];

            $form['user_id']         = auth('client')->user()->id;

            $posting                 = PostingModel::create($form);        
    

            PostingCategoryModel::insert(
                collect($form['categories'])->map( 
                    fn($value): array => [
                        'id'              => Str::uuid(),
                        'posting_id'      => $posting->id,
                        'category_id'     => $value['category_id'], 
                        'sub_category_id' => $value['id'],
                        'created_at'      => now(),
                        'updated_at'      => now()
                    ] 
                )->toArray()
            );

            if( $form['promotion_status'] ){
                
                $promotion = PromotionModel::create([
                    'amount'       => $form['promotion_amount'],
                    'image'        => $form['promotion_image'],
                    'date_from'    => $form['promotion_date_from'],
                    'date_to'      => $form['promotion_date_to'],
                    'posting_id'   => $posting->id,
                    'placement_id' => $form['placement_id'],
                ]);

                return back()->with('data',$promotion);
            }
            
            if( !$form['promotion_status'] ){
                return back()->with('message', 'Posting created successfully');        
            }

        } catch(Error $error) {

            return back()->with('message', 'Something went wrong. Please try again.');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PostingModel $posting)
    {
        $posting->load(['categories','promotions']);
                               
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
    public function destroy(PostingModel $posting)
    {
        $posting->delete();

        return back()->with('message', 'Posting has been deleted');
    }
}

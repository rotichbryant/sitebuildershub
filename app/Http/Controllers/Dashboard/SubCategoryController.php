<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SubCategoryRequest;
use App\Models\CategoryModel;
use App\Models\SubCategoryModel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sub_categories = SubCategoryModel::with(['category'])->withCount(['childSubCategories'])->paginate(10);
        $categories     = CategoryModel::all();

        return Inertia::render('Dashboard/SubCategory',[
            'categories'     => $categories,
            'status'         => session('status'),
            'sub_categories' => $sub_categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryRequest $request)
    {
        // Validate the request
        $validated = $request->validated();

        // Create the category with UUID
        SubCategoryModel::create($validated);

        return back()->with('status', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

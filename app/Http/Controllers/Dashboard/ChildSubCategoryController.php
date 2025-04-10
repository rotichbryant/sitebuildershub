<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ChildSubCategoryRequest;
use App\Models\CategoryModel;
use App\Models\ChildSubCategoryModel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChildSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $child_sub_categories = ChildSubCategoryModel::with(['category','subCategory'])->paginate(10);
        $categories           = CategoryModel::with(['subCategories'])->get();

        return Inertia::render('Dashboard/ChildSubCategory',[
            'status'               => session('status'),
            'categories'           => $categories,
            'child_sub_categories' => $child_sub_categories
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
    public function store(ChildSubCategoryRequest $request)
    {
        // Validate the request
        $validated = $request->validated();

        // Create the category with UUID
        ChildSubCategoryModel::create($validated);

        return back()->with('status', 'Child Sub Category created successfully');
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

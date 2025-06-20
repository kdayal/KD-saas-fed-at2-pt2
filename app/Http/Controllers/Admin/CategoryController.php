<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;



class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::orderBy('name')->paginate(10); 
        return view('admin.categories.index', compact('categories'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.categories.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:16|unique:categories,name', // Appendix D ke anusaar size 16
            'description' => 'nullable|string|max:255',
        ]);

        Category::create($request->all());

        return redirect(route('admin.categories.index'))->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
          return redirect(route('admin.categories.edit', $category));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:16|unique:categories,name,' . $category->id, // Update karte waqt current category ke naam ko ignore karein
            'description' => 'nullable|string|max:255',
        ]);

        $category->update($request->all());

        return redirect(route('admin.categories.index'))->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect(route('admin.categories.index'))->with('success', 'Category deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Api\V3;
use App\Models\Subcategory;

class SubcategoryController
{
    public function index()
    {
        $subcategories = Subcategory::with('category')
            ->select('name', 'description', 'category_id')
            ->paginate(10);

        $subcategories->getCollection()->transform(function ($subcategory) {
            return [
                'name' => $subcategory->name,
                'description' => $subcategory->description,
                'category_name' => $subcategory->category->name,
            ];
        });

        return response()->json($subcategories);
    }

    public function privateIndex()
    {
        $subcategories = Subcategory::with(['category', 'products'])
            ->select('name', 'description', 'category_id')
            ->paginate(12);

        $subcategories->getCollection()->transform(function ($subcategory) {
            return [
                'name' => $subcategory->name,
                'description' => $subcategory->description,
                'category_name' => $subcategory->category->name,
                'product_names' => $subcategory->products->pluck('name')->toArray(),
            ];
        });

        return response()->json($subcategories);
    }
}

<?php

namespace App\Http\Controllers\Api\V3;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
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
    public function store(StoreSubcategoryRequest $request)
    {
        $data = $request->all();
        $subcategory = Subcategory::create($data);
        return new SubcategoryResource($subcategory);
    }
    public function update(Subcategory $subcategory, StoreSubcategoryRequest $request)
    {
        $subcategory->update($request->all());
        return new SubcategoryResource($subcategory);
    }
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        //return response(null, Response::HTTP_NO_CONTENT);
        return response()->noContent();
    }
}

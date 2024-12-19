<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Resources\SubcategoryResource;
use App\Models\Subcategory;

class SubcategoryController
{
    /**
     * @OA\Get (
     *     path="/subcategories",
     *     tags={"Subcategories"},
     *     summary="Get List all subcategories",
     *
     *     @OA\Response(
     *          response="200",
     *          description="Succesful operation",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Forbidden",
     *     )
     * )
     */
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

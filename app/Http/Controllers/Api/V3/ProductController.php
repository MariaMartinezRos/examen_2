<?php
namespace App\Http\Controllers\Api\V3;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(9);
        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->all();
        $product = Product::create($data);
        return new ProductResource($product);
    }
    public function update(Product $product, StoreProductRequest $request)
    {
        $product->update($request->all());
        return new ProductResource($product);
    }
    public function destroy(Product $product)
    {
        $product->delete();
        //return response(null, Response::HTTP_NO_CONTENT);
        return response()->noContent();
    }
}

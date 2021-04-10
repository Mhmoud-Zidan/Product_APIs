<?php
//add API
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Product as ProductResource;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Auth\Events\Validated;

class ProductController extends BaseController
{

    public function index()
    {
        $products = Product::all();
        return $this->sendResponse(ProductResource::collection($products), 'All Products Retrieved');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required',
            'price' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Please Validate Error', $validator->errors());
        }
        $product = Product::create($input);
        return $this->sendResponse(new ProductResource($product), 'Product Created Successfully');
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product is not found', ['error' => 'Not Exist']);
        }
        return $this->sendResponse(new ProductResource($product), 'Product found successfully');
    }

    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendResponse('Please Validate Error', $validator->errors());
        }
        $product->update($request->all());

        return $this->sendResponse(new ProductResource($product), 'Product Updated Successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return $this->sendResponse(new ProductResource($product), 'Product Deleted Successfully');
    }
}

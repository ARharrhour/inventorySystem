<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class ProductController extends Controller
{
    public function index()
    {

        $products = Product::all();
        return response()->json($products);
    }



    public function show($id)
    {

        $product = DB::table('products')->where('id', $id)->first();

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $productValidation = $request->validate([
            "category_id" => "required",
            "product_name" => "required",
            "product_quantity" => "required",
            "selling_price" => "required|numeric"
        ]);


        $photo = $request->image;
        $product = new Product;
        if ($photo) {
            $position = strpos($photo, ";");
            $sub = substr($photo, 0, $position);
            $ext = explode("/", $sub)[1];

            $name = time() . "." . $ext;
            $path_upload = "img/products/";
            $image_url = $path_upload . $name;
            $image = Image::make($photo)->resize(240, 200);
            $image->save($image_url);
            $product->image = $image_url;
        } else {

            $product->image = "img/products/noimage.png";
        }
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->selling_price = $request->selling_price;
        $product->buying_price = $request->buying_price;
        $product->product_name = $request->product_name;
        $product->product_code = $request->product_code;
        $product->root = $request->root;
        $product->product_quantity = $request->product_quantity;
        $product->buying_date = $request->buying_date;
        $product->save();
    }
    public function update(Request $request, $id)
    {
        $productValidation = $request->validate([
            "category_id" => "required",
            "product_name" => "required",
            "product_quantity" => "required",
            "selling_price" => "required|numeric"
        ]);

        $data = array();
        $data["category_id"] = $request->category_id;
        $data["supplier_id"] = $request->supplier_id;
        $data["selling_price"] = $request->selling_price;
        $data["buying_price"] = $request->buying_price;
        $data["product_name"] = $request->product_name;
        $data["product_code"] = $request->product_code;
        $data["root"] = $request->root;
        $data["product_quantity"] = $request->product_quantity;
        $data["buying_date"] = $request->buying_date;

        $newPhoto = $request->newPhoto;

        if ($newPhoto) {
            $position = strpos($newPhoto, ";");
            $sub = substr($newPhoto, 0, $position);
            $ext = explode("/", $sub)[1];

            $name = time() . "." . $ext;
            $path_upload = "img/products/";
            $image_url = $path_upload . $name;
            $image = Image::make($newPhoto)->resize(240, 200);
            $success = $image->save($image_url);
            if ($success) {
                $data["image"] = $image_url;
                $oldphoto = Product::find($id)->photo;
                if ($oldphoto) {
                    unlink($oldphoto);
                }
                DB::table("products")->where("id", $id)->update($data);
            }
        } else {
            $data["image"] = $request->image;
            DB::table("products")->where("id", $id)->update($data);
        }
    }
    public function destroy($id)
    {


        $photo = Product::find($id)->photo;
        if ($photo) {
            unlink($photo);
            Product::find($id)->delete();
        } else {
            Product::find($id)->delete();
        }
    }
}

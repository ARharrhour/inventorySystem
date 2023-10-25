<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class SupplierController extends Controller
{
    public function index()
    {

        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }



    public function show($id)
    {

        $supplier = DB::table('suppliers')->where('id', $id)->first();

        return response()->json($supplier);
    }

    public function store(Request $request)
    {
        $supplierValidation = $request->validate([
            "name" => "required|unique:suppliers|max:255",
            "shop_name" => "required|unique:suppliers",
            "address" => "required|unique:suppliers",
            "email" => "required|unique:suppliers",
            "phone" => "required|unique:suppliers",

        ]);


        $photo = $request->photo;
        if ($photo) {
            $position = strpos($photo, ";");
            $sub = substr($photo, 0, $position);
            $ext = explode("/", $sub)[1];
            $name = time() . "." . $ext;
            $image = Image::make($photo)->resize(240, 200);
            $upload_path = "img/suppliers/";
            $image_url = $upload_path . $name;
            $image->save($image_url);
            $supplier = new Supplier;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->address = $request->address;
            $supplier->phone = $request->phone;
            $supplier->shop_name = $request->shop_name;
            $supplier->photo = $image_url;
            $supplier->save();
        } else {

            $supplier = new Supplier;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->address = $request->address;
            $supplier->phone = $request->phone;
            $supplier->shop_name = $request->shop_name;
            $supplier->save();
        }
    }
    public function update(Request $request, $id)
    {

        $data=array();
        $data["name"]=$request->name;
        $data["phone"]=$request->phone;
        $data["email"]=$request->email;
        $data["address"]=$request->address;
        $data["shop_name"]=$request->shop_name;
        $newPhoto=$request->newPhoto;
        if($newPhoto){
            $position=strpos($newPhoto,";");
            $sub=substr($newPhoto,0,$position);
            $ext=explode("/",$sub)[1];


            $name=time().".".$ext;
            $image=Image::make($newPhoto)->resize(240,200);
            $upload_path="img/suppliers/";
            $image_url=$upload_path.$name;

            $success=$image->save($image_url);
            if($success){
                $data["photo"]=$image_url;
                $oldImage=Supplier::find($id)->photo;
                if($oldImage){
                    unlink($oldImage);
                }


                DB::table("suppliers")->where("id", $id)->update($data);
            }


        }else{
            $data["photo"]=$request->photo;
            DB::table("suppliers")->where("id",$id)->update($data);
        }
    }
    public function destroy($id)
    {
        $photo=Supplier::find($id)->photo;
        if($photo){
             unlink($photo);
             Supplier::find($id)->delete();
        }else{
            Supplier::find($id)->delete();

        }



    }
}

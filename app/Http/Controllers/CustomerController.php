<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Claims\Custom;
use Image;

class CustomerController extends Controller
{
    public function index()
    {

        $customers = Customer::all();
        return response()->json($customers);
    }



    public function show($id)
    {

        $customer = DB::table('customers')->where('id', $id)->first();

        return response()->json($customer);
    }

    public function store(Request $request)
    {
        $customerValidation = $request->validate([

            "name" => "required|unique:customers|max:255",
            "email" => "required|unique:customers",
            "phone" => "required|unique:customers",
            "address" => "required",

        ]);
        $photo = $request->photo;
        if ($photo) {
            $position = strpos($photo, ";");
            $sub = substr($photo, 0, $position);
            $ext = explode("/", $sub)[1];

            $name = time() . "." . $ext;
            $image_upload = "img/customers/";
            $image = Image::make($photo)->resize(240, 200);
            $image_url = $image . $name;
            $image->save($image_url);

            $customer = new Customer;
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->address = $request->address;
            $customer->phone = $request->phone;
            $customer->photo = $image_url;
            $customer->save();
        } else {
            $default_image = "img/customers/default.png";
            $customer = new Customer;
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->address = $request->address;
            $customer->phone = $request->phone;
            $customer->photo = $default_image;
            $customer->save();
        }
    }
    public function update(Request $request, $id)
    {



        $data = array();
        $data["email"] = $request->email;
        $data["address"] = $request->address;
        $data["name"] = $request->name;
        $data["phone"] = $request->phone;
        $newPhoto = $request->newPhoto;
        if ($newPhoto) {
            $position = strpos($newPhoto, ";");
            $sub = substr($newPhoto, 0, $position);
            $ext = explode("/", $sub)[1];

            $name = time() . "." . $ext;
            $image_upload = "img/customers/";
            $image = Image::make($newPhoto)->resize(240, 200);
            $image_url = $image . $name;
            $success = $image->save($image_url);
            if ($success) {
                $data["photo"] = $image_url;
                $oldPhoto = Customer::find($id)->photo;
                if ($oldPhoto) {
                    unlink($oldPhoto);
                }
                DB::table("customers")->where("id", $id)->update($data);
            }
        } else {
            $data["photo"] = $request->photo;
            DB::table("customers")->where("id", $id)->update($data);
        }
    }
    public function destroy($id)
    {

        $photo = Customer::find($id)->photo;
        if ($photo) {
            unlink($photo);
            Customer::find($id)->delete();
        } else {
            Customer::find($id)->delete();
        }
    }
}

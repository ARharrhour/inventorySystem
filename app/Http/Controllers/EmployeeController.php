<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class EmployeeController extends Controller
{

    public function index()
    {

        $employees = Employee::all();
        return response()->json($employees);
    }
    public function show($id){
        $employee=Employee::find($id);
        return response()->json($employee);
    }

    public function store(Request $request)
    {

        $validationEmployee = $request->validate([

            "name" => "required|max:255",
            "address" => "required",
            "email" => "required|unique:employees",
            "salary" => "required",
            "joining_date" => "required",
            "phone" => "required|unique:employees",
        ]);

        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($request->photo)->resize(240, 200);
            $upload_path = "img/employees/";

            $img_url = $upload_path . $name;
            $img->save($img_url);

            $employee = new Employee;
            $employee->name = $request->name;
            $employee->address = $request->address;
            $employee->nid = $request->nid;
            $employee->joining_date = $request->joining_date;
            $employee->email = $request->email;
            $employee->salary = (float)$request->salary;
            $employee->photo = $img_url;
            $employee->phone = $request->phone;
            $employee->save();
        } else {
            $employee = new Employee;
            $employee->name = $request->name;
            $employee->address = $request->address;
            $employee->nid = $request->nid;
            $employee->joining_date = $request->joining_date;
            $employee->email = $request->email;
            $employee->salary = (float) $request->salary;
            $employee->phone = $request->phone;
            $employee->save();
        }
    }




    public function update(Request $request,$id){

        $data=array();
        $data["name"]=$request->name;
        $data["phone"]=$request->phone;
        $data["address"]=$request->address;
        $data["email"]=$request->email;
        $data["nid"]=$request->nid;
        $data["salary"]=$request->salary;
        $data["joining_date"]=$request->joining_date;
        $data["name"]=$request->name;
        $image=$request->newPhoto;

        if($image){
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($image)->resize(240, 200);
            $upload_path = "img/employees/";

            $img_url = $upload_path . $name;
            $success=$img->save($img_url);
            if($success){
                $data['photo']=$img_url;
                $employeeImage = Employee::find($id)->photo;
                if ($employeeImage) {
                    if (file_exists($employeeImage)) {
                        unlink($employeeImage);
                    }
                }
                $user= DB::table("employees")->where("id",$id)->update($data);

            }



        }else{

            
            $data["photo"]=$request->photo;
            $user = DB::table("employees")->where("id", $id)->update($data);


        }





    }




    public function destroy($id)
    {

        $employeeImage = Employee::find($id)->photo;
        if ($employeeImage) {
            if(file_exists($employeeImage)){
              unlink($employeeImage);
            }

            Employee::find($id)->delete();
        } else {
            DB::table('employees')->where('id', $id)->delete();
        }
    }
}

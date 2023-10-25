<?php

namespace App\Http\Controllers;

use App\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class SalaryController extends Controller
{

    public function paid(Request $request, $id)
    {
     $paid_validation=$request->validate([
        "amount"=>"required|numeric",
         "salary_month"=>"required",

     ]);
     $month= $request->salary_month;
     $check=DB::table("salaries")->where("employee_id",$id)->where("salary_month",$month)->first();
     if($check){
        return response()->json('Salary Already Paid');
     }
     $salary= new Salary;
     $salary->salary_month=$month;
     $salary->amount=$request->amount;
     $salary->employee_id=$id;
     $salary->salary_date=date("d-m-Y");
     $salary->salary_year=date("Y");
     $salary->save();




    }
    public function salaries()
    {
        $salaries=DB::table("salaries")->select("salary_month")->groupBy('salary_month')->get();
        return response()->json($salaries);
    }
    public function viewSalary($id)
    {
        $salary=DB::table("salaries")
        ->join("employees",'salaries.employee_id','employees.id')
        ->select('employees.name','salaries.*')
        ->where("salaries.salary_month",$id)
        ->get();
        return response()->json($salary);

    }
    public function editSalary($id)
    {
        $view = DB::table('salaries')
        ->join('employees', 'salaries.employee_id', 'employees.id')
        ->select('employees.name', 'employees.email', 'salaries.*')
        ->where('salaries.id', $id)
        ->first();
        return response()->json($view);

    }
    public function salaryUpdate(Request $request, $id)
    {
        $data = array();
        $data['employee_id'] = $request->employee_id;
        $data['amount'] = $request->amount;
        $data['salary_month'] = $request->salary_month;
        DB::table('salaries')->where('id', $id)->update($data);

    }
    public function stockUpdate(Request $request, $id)
    {

    }
}

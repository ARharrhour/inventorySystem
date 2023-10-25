<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index()
    {

        $expenses =Expense::all();
        return response()->json($expenses);
    }



    public function show($id)
    {

        $expense = DB::table('expenses')->where('id', $id)->first();

        return response()->json($expense);
    }

    public function store(Request $request)
    {
        $expenseValidation = $request->validate([

            "details" => "required",
            "amount" => "required|numeric"


        ]);


            $expense = new Expense;
            $expense->details = $request->details;
            $expense->amount = $request->amount;
            $expense->expense_date = date("d-m-Y");

            $expense->save();

    }
    public function update(Request $request, $id)
    {

        $expenseValidation = $request->validate([

            "details" => "required",
            "amount" => "required|numeric",



        ]);

        $data = array();
        $data["details"] = $request->details;
        $data["amount"] = $request->amount;

        DB::table("expenses")->where("id", $id)->update($data);

    }
    public function destroy($id)
    {


           Expense::find($id)->delete();

    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee =Employee::all();
        return response()->json([
            'status'=>'success',
            'employee'=>$employee
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
       
        try{
            DB::beginTransaction();
            $employee=Employee::create([
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'department_id'=>$request->department_id,
                'position'=>$request->position

            ]);
            DB::commit();
            return response()->json([
                'status'=>'success',
                'employee'=>$employee
            ]);
        }catch(\Throwable $th){
            DB::rollBack();
            Log::error($th);
            return response()->json([
                'status'=>'error'
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return response()->json([
            'status'=>'success',
            'employee'=>$employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $newData=[];
        if(isset ($request->first_name)){
            $newData['first_name']=$request->first_name;
        }
        if(isset ($request->last_name)){
            $newData['last_name']=$request->last_name;
        }
        if(isset ($request->last_name)){
            $newData['email']=$request->email;
        }
        if(isset ($request->last_name)){
            $newData['department_id']=$request->department_id;
        }
        if(isset ($request->last_name)){
            $newData['position']=$request->position;
        }
        $employee->update($newData);
        return response()->json([
            'status'=>'success',
            'employee'=>$employee
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json([
            'status'=>'success'
                ]);
    }
}

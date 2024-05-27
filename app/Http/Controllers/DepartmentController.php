<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $department =Department::all();
        return response()->json([
            'status'=>'success',
            'department'=>$department
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
       
        try{
            DB::beginTransaction();
            $department=Department::create([
                'name'=>$request->name,
                'description'=>$request->description
            ]);
            DB::commit();
            return response()->json([
                'status'=>'success',
                'department'=>$department
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
    public function show(Department $department)
    {
        return response()->json([
            'status'=>'success',
            'department'=>$department
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        $newData=[];
        if(isset ($request->name)){
            $newData['name']=$request->name;
        }
        if(isset ($request->description)){
            $newData['description']=$request->description;
        }
        $department->update($newData);
        return response()->json([
            'status'=>'success',
            'department'=>$department
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json([
            'status'=>'success'
                ]);
    }
}

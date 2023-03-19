<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{

    public function index(){
        return view('employees.index');
    }

    public function show($id){
        return view('employees.show', ['id' => $id]);
    }
}

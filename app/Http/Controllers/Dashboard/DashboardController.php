<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        
        $totalEmployee = Employee::get()->count();

        return view('dashboards.index', ['totalEmployee' => $totalEmployee]);
    }
}

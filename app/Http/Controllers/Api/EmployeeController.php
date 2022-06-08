<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->employee = new Employee();
    }

    public function index()
    {
        $data = $this->employee->getall();
        if (empty($data[0])) {
            # jika data nol maka
            return response()->json([
                'status' => false,
                'message' => 'Employee Not Found',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Get All Data Employee',
            'data' => $data
        ]);
    }
}

<?php

namespace app\Repositories\Employee\CreateRepository;

use App\Models\Employee;

class CreateRepository
{
    public function index($request)
    {
        $this->employee = new Employee();
        return $this->employee->insertdata($request);
    }
}
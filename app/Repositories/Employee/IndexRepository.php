<?php

namespace app\Repositories\Employee\IndexRepository;

use App\Models\Employee;

class IndexRepository
{
    public function index()
    {
        return (new Employee)->getall();
    }
}
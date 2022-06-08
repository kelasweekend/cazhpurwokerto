<?php

namespace app\Services;

use app\Services\Employee\CreateService\CreateService;
use app\Services\Employee\IndexService\IndexService;

class EmployeService
{
    public function index()
    {
        return (new IndexService)->index();
    }

    public function create($request)
    {
        return (new CreateService)->index($request);
    }
}
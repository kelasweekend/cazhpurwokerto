<?php

namespace app\Services\Employee\IndexService;

use app\Repositories\Employee\IndexRepository\IndexRepository;

class IndexService
{
    public function index()
    {
        return (new IndexRepository)->index();
    }
}
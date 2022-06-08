<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->history = new History();
    }

    public function index()
    {
        $data = $this->history->getall();
        if (empty($data[0])) {
            # jika data nol maka
            return response()->json([
                'status' => false,
                'message' => 'History Not Found',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Get All Data History',
            'data' => $data
        ]);
    }
}

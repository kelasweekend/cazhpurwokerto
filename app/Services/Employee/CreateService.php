<?php

namespace app\Services\Employee\CreateService;

use App\Models\History;
use app\Repositories\Employee\CreateRepository\CreateRepository;
use Illuminate\Support\Facades\Validator;

class CreateService
{
    public function index($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:companies',
            'nama' => 'required',
            'balance' => 'required|numeric|min:1',
        ]);

        // error handling ajax form input
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $data = (new CreateRepository)->index($request);
        // add to history
        $history = new History();
        return $history->insertdata($data, $request);
    }
}
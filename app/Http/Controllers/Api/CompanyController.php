<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->company = new Company();
    }

    public function index()
    {
        $data = Company::paginate();
        if (empty($data[0])) {
            # jika data nol maka
            return response()->json([
                'status' => false,
                'message' => 'Company Not Found',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Get All Data Company',
            'data' => $data
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:companies',
            'nama' => 'required',
            'balance' => 'required|numeric|min:1',
            'website' => 'required',
            'logo' => 'required'
        ]);

        // error handling ajax form input
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Error Validation !',
                'error' => $validator->errors()->all()
            ]);
        }

        $imageName = time() . '.' . $request->file('logo')->extension();
        $request->file('logo')->storeAs('company', $imageName, 'public');

        $this->company->postcompany($request, $imageName);

        return response()->json([
            'status' => true,
            'message' => 'Company Hass Been Added',
        ]);
    }

    public function destroy($id)
    {
        $data = Company::find($id);
        if (empty($data)) {
            # code...
            return response()->json([
                'status' => false,
                'message' => 'ID Company Not Found',
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Company Hass Been Deleted',
        ]);
    }
}

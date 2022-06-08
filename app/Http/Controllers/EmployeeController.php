<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->employee = new Employee();
        $this->company = new Company();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company = $this->company->getall();
        // dd($this->employee->getall());
        if ($request->ajax()) {
            // get data from model employee
            $data = $this->employee->getall();
            // return data with datatables
            return DataTables::of($data)
                ->addIndexColumn()
                // button action in table blade
                ->addColumn('action', function ($row) {

                    $actionBtn = '<div class="btn-group">
                    <button type="button" class="btn btn-danger">Action</button>
                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu" style="">
                    <a class="dropdown-item editItem" data-id="' . $row->id . '" data-url="' . route('employee.edit', $row->id) . '"><i class="fa fa-edit"></i> Change</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item deleteItem" data-id="' . $row->id . '" data-url="' . route('employee.destroy', $row->id) . '"><i class="fa fa-trash"></i> Delete Companies</a>
                    </div>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // this blade company
        return view('v1.employee.index', compact('company'));
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
        ]);

        // error handling ajax form input
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $data = $this->employee->insertdata($request);
        // add to history
        $history = new History();
        $history->insertdata($data, $request);

        return response()->json(['success' => 'Employee Hass Been Added']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json($this->employee->getemployee($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->employee->deletedata($id);
        return response()->json(['success' => 'Data Hass Been Deleted']);
    }

    public function getcompany(Request $request)
    {
        $input = $request->all();

        if (!empty($input['query'])) {

            $data = Company::select(["id", "nama"])
                ->where("nama", "LIKE", "%{$input['query']}%")
                ->get();
        } else {

            $data = Company::select(["id", "nama"])
                ->get();
        }

        $countries = [];

        if (count($data) > 0) {

            foreach ($data as $Company) {
                $countries[] = array(
                    "id" => $Company->id,
                    "text" => $Company->nama,
                );
            }
        }
        return response()->json($countries);
    }
}

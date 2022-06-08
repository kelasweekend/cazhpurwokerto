<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->company = new Company();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($this->company->getall());
        if ($request->ajax()) {
            // get data from model company
            $data = $this->company->getall();

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
                    <a class="dropdown-item editItem" data-id="' . $row->id . '" data-url="' . route('company.edit', $row->id) . '"><i class="fa fa-edit"></i> Change</a>
                    <a class="dropdown-item" href="' . route('company.show', $row->id) . '"><i class="fa fa-eye"></i> View Employee</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item deleteItem" data-id="' . $row->id . '" data-url="' . route('company.destroy', $row->id) . '"><i class="fa fa-trash"></i> Delete Companies</a>
                    </div>
                    </div>';
                    return $actionBtn;
                })
                ->addColumn('image', function ($list) {

                    $image = '<img src="' . asset('storage/company/' . $list->logo) . '" alt="" width="100">';
                    return $image;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        // this blade company
        return view('v1.company.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate input form
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:companies',
            'nama' => 'required',
            'balance' => 'required|numeric|min:1',
            'website' => 'required',
            'logo' => 'required|image|mimes:png|max:2048'
        ]);

        // error handling ajax form input
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $imageName = time() . '.' . $request->file('logo')->extension();
        $request->file('logo')->storeAs('company', $imageName, 'public');

        $this->company->postcompany($request, $imageName);

        return response()->json(['success' => 'Companies Hass Been Added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $company = $this->company->getcompany($id);
        if ($request->ajax()) {
            // get data from model company
            // return data with datatables
            $this->employe = new Employee();
            $data = $this->employe->getbycompany($id);
            return DataTables::of($data)
                ->addIndexColumn()
                // button action in table blade
                ->addColumn('action', function ($row) {

                    $actionBtn_1 = '<button class="btn btn-secondary btn-sm addbalance" data-id"'. $row->id .'" data-url="' . route('getbalance', $row->id). '"><i class="fas fa-plus mr-2"></i>Add Balance</button> ';
                    $actionBtn = $actionBtn_1 . '<button class="btn btn-danger btn-sm"><i class="fas fa-trash mr-2"></i>Delete</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // this blade company
        return view('v1.company.view', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json($this->company->getcompany($id));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->company->deletedata($id);
        return response()->json(['success' => 'Data Hass Been Deleted']);
    }

    public function getbalance($id)
    {
        $this->employe = new Employee();
        return response()->json($this->employe->getbalance($id));
    }

    public function addbalance($id, Request $request)
    {
        $data = Employee::find($id);

        $validator = Validator::make($request->all(), [
            'company_id' => 'required|numeric',
            'balance' => 'required|numeric|min:1',
        ]);

        // error handling ajax form input
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $data->update([
            'balance' => $data->balance + $request->balance
        ]);
        $history = new History();
        $history->insertdata($data, $request);
        return response()->json(['success' => 'Balance '. $data->nama . ' Hass Been Added']);
    }
}

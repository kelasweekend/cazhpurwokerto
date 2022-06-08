<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->history = new History();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->history->getall();
            // get data from model history
            // return data with datatables
            return DataTables::of($data)
            // ->addIndexColumn()
            // // button action in table blade
            // ->addColumn('action', function ($row) {
            //     $actionBtn = $i++;
            //     return $actionBtn;
            // })
            // ->rawColumns(['action'])
            ->make(true);
        }

        // this blade company
        return view('v1.history.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}

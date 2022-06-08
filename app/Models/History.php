<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class History extends Model
{
  use HasFactory;
  protected $fillable = [
    'company_id',
    'employee_id',
    'balance',
    'company_start_balance',
    'company_last_balance',
    'employee_start_balance',
    'employee_last_balance',
  ];

  public function insertdata($data, $request)
  {
    $employee = Employee::find($data->id);
    $company = Company::find($request->company_id);
    return $this->create([
      'company_id' => $request->company_id,
      'employee_id' => $data->id,
      'balance' => $request->balance,
      'company_start_balance' => $company->balance,
      'company_last_balance' => $company->balance - $request->balance,
      'employee_start_balance' => $employee->balance + $request->balance,
      'employee_last_balance' => $employee->balance
    ]);
  }

  public function getall()
  {
    return DB::table('histories')
    ->select('histories.*', 'employees.nama as nama_employee', 'companies.nama as nama_company')
    ->join('companies', 'histories.company_id', '=', 'companies.id')
    ->join('employees', 'histories.employee_id', '=', 'employees.id')
    ->get();
  }
}

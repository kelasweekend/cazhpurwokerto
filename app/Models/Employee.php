<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'nama',
        'email',
        'balance',
     ];


     public function getbycompany($id)
     {
         return $this->where('company_id', $id)->get();
     }

     public function getall()
     {
         return $this->all();
     }

     public function deletedata($id)
     {
         $data = $this->find($id);
         return $data->delete();
     }

     public function getemployee($id)
     {
         return $this->find($id);
     }

     public function insertdata($request)
     {
         return $this->create([
            'company_id' => $request->company_id,
            'email' => $request->email,
            'nama' => $request->nama,
            'balance' => $request->balance
        ]);
     }

     public function getbalance($id)
     {
         return $this->whereId($id)->select('id', 'balance', 'company_id')->first();
     }

     
}

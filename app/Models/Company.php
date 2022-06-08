<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'email',
        'balance',
        'logo',
        'website',
    ];

    public function getall()
    {
        return $this->all();
    }

    public function getcompany($id)
    {
        return $this->find($id);
    }

    public function postcompany($request, $imageName)
    {
        return $this->create([
            'nama' => $request->nama,
            'email' => $request->email,
            'balance' => $request->balance,
            'website' => $request->website,
            'logo' => $imageName
        ]);
    }

    public function deletedata($id)
    {
        $data = $this->find($id);
        unlink(storage_path('company/' . $data->logo));
        return $data->delete();
    }
}

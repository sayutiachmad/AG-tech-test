<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'nip',
        'tempat_lahir',
        'tanggal_lahir',
        'umur',
        'alamat',
        'agama',
        'jenis_kelamin',
        'no_handphone',
        'email',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = "tasks";
    protected $primaryKey = "id";

    protected $fillable = [
        'name',
        'email',
        'website',
        'address',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    protected $fillable = [
        "name",
        "contry_name",
        "code"
    ];
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    protected $table = "airlines";
    protected $fillable = [
        "ful_name",
        "description",
        "code"
    ];
}

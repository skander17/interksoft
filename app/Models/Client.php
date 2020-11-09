<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    protected $fillable = [
        "full_name",
        "dni",
        "email",
        "passport",
        "passport_exp",
        "birth_date",
        "phone",
        "code"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $dates = [
        'birth_date' => 'date:Y-m-d',
        'passport_exp' => 'date:Y-m-d',
    ];
}

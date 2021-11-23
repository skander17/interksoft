<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airport extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];
    protected $fillable = [
        "name",
        "country_id",
        "iso_region",
        "iso_country",
        "latitude",
        "longitude",
        "iata_code"
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function country(){
        return $this->hasOne(Country::class,'id','country_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperationDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "id","state_id","user_id"
    ];

    public function operation(){
        $this->belongsTo(Operation::class);
    }

    public function status(){
        $this->hasOne(State::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "id","pay_method","state_id","total_amount","ticket_id"
    ];

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function operationDetail(){
        return $this->hasMany(OperationDetail::class);
    }
}

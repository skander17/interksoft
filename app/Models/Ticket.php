<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "code",
        "ticket",
        "date_start",
        "date_arrival",
        "aircraft_id",
        "airport_origin_id",
        "airport_arrival_id",
        "client_id",
        "airline_id",
        "user_id",
        "state_id"
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function airline(){
        return $this->belongsTo(Airline::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(){
        return $this->belongsTo(Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function OriginAirport(){
        return $this->belongsTo(Airport::class,'origin_airport');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ArrivalAirport(){
        return $this->belongsTo(Airport::class,'arrival_airport');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operation(){
        return $this->belongsTo(Operation::class,'arrival_airport');
    }
}

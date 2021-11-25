<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "id",
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
        return $this->belongsTo(Airline::class)->withoutGlobalScopes();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(){
        return $this->belongsTo(Client::class)->withoutGlobalScopes();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function airport_origin(){
        return $this->belongsTo(Airport::class,'airport_origin_id')->withoutGlobalScopes();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function airport_arrival(){
        return $this->belongsTo(Airport::class,'airport_arrival_id')->withoutGlobalScopes();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class)->withoutGlobalScopes();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function operation(){
        return $this->hasOne(Operation::class)->withoutGlobalScopes();
    }
}

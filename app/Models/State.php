<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['id', 'state_name', 'country_id'];
    //hasmany relationship
    public function cities()
    {
        return $this->hasMany(City::class);
    }
    //belongs to relationship
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}

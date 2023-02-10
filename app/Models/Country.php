<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['id', 'country_name'];
    //hasmany relationship
    public function states()
    {
        return $this->hasMany(State::class, 'country_id');
    }
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'country_id');
    }
}

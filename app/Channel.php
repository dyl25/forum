<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * Change le nom de la clé pour récupérer le model par son slug et non plus
     * par son id
     * @return string Le nom de la clé
     * 
     */
    public function getRouteKeyName() {
       return 'slug'; 
    }
    
    public function threads() {
        return $this->hasMany(Thread::class);
    }
}

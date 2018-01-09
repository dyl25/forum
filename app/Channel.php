<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * Permet de changer le nom de la clé par défaut pour faire une recherche
     * 
     * @return string Le nom de la clé
     */
    public function getRouteKeyName() {
       return 'slug'; 
    }
    
    public function threads() {
        return $this->hasMany(Thread::class);
    }
}

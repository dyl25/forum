<?php

namespace App\Filters;

use App\User;

/**
 * Se charge d'effectuer les différentes requêtes pour récupérer les sujets
 *
 * @author Dylan Vansteenacker
 */
class ThreadFilters extends Filters{
    
    protected $filters = ['by'];

    /**
     * Filtre la requête avec un username
     * 
     * @param string $username
     * @return mixed
     */
    public function by($username) {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

}

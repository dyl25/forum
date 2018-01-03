<?php

namespace App\Filters;

use App\User;

/**
 * Se charge d'effectuer les différentes requêtes pour récupérer les sujets
 *
 * @author Dylan Vansteenacker
 */
class ThreadFilters extends Filters{
    
    protected $filters = ['by', 'popular'];

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
    
    /**
     * Filtre la requête selon la popularité des sujets
     * 
     * @return $this
     */
    public function popular() {
        $this->builder->getQuery()->orders = [];
        
        return $this->builder->orderBy('replies_count', 'desc');
    }

}

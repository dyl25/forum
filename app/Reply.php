<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model {

    use Favoritable;
    
    protected $guarded = [];
    protected $with = ['owner', 'favorites'];

    /**
     * Une réponse a un propriétaire
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}

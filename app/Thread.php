<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];


    /**
     * Un sujet peut avoir plusieur réponses 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function replies() {
        return $this->hasMany(Reply::class);
    }
    
    /**
     * Un sujet possède un créateur
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Un sujet appartient à une section
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel() {
        return $this->belongsTo(Channel::class);
    }
    
    /**
     * Ajoute une réponse à un sujet
     * @param $reply
     */
    public function addReply($reply) {
        $this->replies()->create($reply);
    }
    
    public function scopeFilter($query, $filters) {
        return $filters->apply($query);
    }
    
}

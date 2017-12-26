<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class ReplyController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * 
     * @param type $channel Section du sujet
     * @param Thread $thread
     * @return type
     */
    public function store($channel, Thread $thread) {
        
        $this->validate(request(), [
            'body' => 'required'
        ]);
        
        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);
        
        return back();
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase {

    use DatabaseMigrations;
    
    protected $thread;

    public function setUp() {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    /**
     * @test
     */
    public function has_a_reply() {

        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /**
     * @test
     */
    public function has_a_creator() {

        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /**
     * @test
     */
    public function can_add_a_reply() {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);
        
        $this->assertCount(1, $this->thread->replies);
    }
    
    /**
     * @test
     */
    public function belong_to_a_channel() {
        $thread = factory('App\Thread')->create();
        
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

}

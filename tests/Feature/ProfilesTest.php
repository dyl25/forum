<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase {

    use DatabaseMigrations;

    /**
     * @test
     */
    public function user_has_a_profile() {
        $user = factory('App\User')->create();

        $this->get("/profiles/{$user->name}")
                ->assertSee($user->name);
    }

    /**
     * @test
     */
    public function profiles_display_all_threads_created_by_associated_user() {
        $user = factory('App\User')->create();
        
        $thread = factory('App\Thread')->create(['user_id' => $user->id]);

        $this->get("/profiles/{$user->name}")
                ->assertSee($thread->title)
                ->assertSee($thread->body);
    }
    
}

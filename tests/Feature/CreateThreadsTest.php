<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase {

    use DatabaseMigrations;
    
    /**
     * @test
     */
    public function guests_cant_create_threads() {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        //permet de récupérer les exeptions lancées
        $this->withoutExceptionHandling();
        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());
    }

    /**
     * @test
     */
    public function auth_user_can_create_new_threads() {
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());

        $this->get('/threads/' . $thread->id)
                ->assertSee($thread->title)
                ->assertSee($thread->body);
    }

}

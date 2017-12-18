<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase {

    use DatabaseMigrations;

    public function unauth_user_cant_reply() {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        
        $thread = factory('App\Thread')->create();
        
        $reply = factory('App\Reply')->create();

        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());
    }

    /**
     * @test
     */
    public function auth_user_can_participate_to_thread() {
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();
        //cree mais ne sauvegarde pas la reponse
        $reply = factory('App\Reply')->make();

        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());

        $this->get('/threads/' . $thread->id)
                ->assertSee($reply->body);
    }

}

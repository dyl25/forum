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

        $this->post(route('threads.store', ['slug' => 'channelTest', 'id' => 2]), [])
                ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function auth_user_can_participate_to_thread() {
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        //cree mais ne sauvegarde pas la reponse
        $reply = factory('App\Reply')->make();

        $this->post(route('threads.store', [$thread->channel->slug,$thread->id]), $reply->toArray());

        $this->get(route('threads.show', ['slug' => $thread->channel->slug, 'id' => $thread->id]))
                ->assertSee($reply->body);
    }

    /**
     * @test
     */
    public function reply_requires_a_body() {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        //cree mais ne sauvegarde pas la reponse
        $reply = factory('App\Reply')->make(['body' => null]);

        $this->post(
                route('threads.store', ['slug' => $thread->channel->slug,
            'id' => $thread->id]), $reply->toArray()
        )->assertSessionHasErrors('body');
    }

}

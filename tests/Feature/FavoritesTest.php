<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase {

    use DatabaseMigrations;

    /**
     * @test
     */
    public function guests_cant_favorite_anything() {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('replies/1/favorites')
                ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function auth_user_can_favorite_any_reply() {
        $this->be(factory('App\User')->create());

        $reply = factory('App\Reply')->create();

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }
    
    /**
     * @test
     */
    public function auth_user_can_only_favorite_a_reply_once() {
        $this->be(factory('App\User')->create());

        $reply = factory('App\Reply')->create();

        $this->post('replies/' . $reply->id . '/favorites');
        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

}

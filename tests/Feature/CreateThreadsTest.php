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
        //$this->withoutExceptionHandling();

        $this->get('/threads/create')
                ->assertRedirect('/login');

        $this->post('/threads')
                ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function auth_user_can_create_new_threads() {
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->make();

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
                ->assertSee($thread->title)
                ->assertSee($thread->body);
    }

    /**
     * @test
     */
    public function requires_a_title() {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->publishThread(['title' => null])
                ->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function requires_a_body() {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->publishThread(['body' => null])
                ->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function requires_a_valid_channel() {
        $this->expectException('Illuminate\Validation\ValidationException');

        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
                ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 9999])
                ->assertSessionHasErrors('channel_id');
    }

    /**
     * @test
     */
    public function unauthorized_users_cant_delete_threads() {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->create();

        $this->delete(route('threads.delete', [
                    $thread->channel->slug, $thread->id
                ]))
                ->assertRedirect('/login');

        $this->be(factory('App\User')->create());

        $this->delete(route('threads.delete', [
                    $thread->channel->slug, $thread->id
                ]))
                ->assertStatus(403);
    }

    /**
     * @test
     */
    public function auth_users_can_delete_thread() {
        $this->be(factory('App\User')->create());

        $thread = factory('App\Thread')->create(['user_id' => auth()->id()]);
        $reply = factory('App\Reply')->create([
            'thread_id' => $thread->id
        ]);

        $response = $this->json('DELETE', route('threads.delete', [
            $thread->channel->slug, $thread->id
        ]));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /**
     * @test
     */
    public function may_only_be_deleted_by_those_who_have_permission() {
        //todo
    }

    public function publishThread($overrides = []) {

        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->make($overrides);

        return $this->post('/threads', $thread->toArray());
    }

}

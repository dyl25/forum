<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase {

    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    /**
     * @test
     */
    public function user_can_view_all_threads() {

        $this->get('/threads')
                ->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function user_can_read_a_single_thread() {
        $this->get(route('threads.show', [$this->thread->channel->slug, $this->thread->id]))
                ->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function user_can_read_replies_associated_with_thread() {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $this->get(route('threads.show', [$this->thread->channel->slug, $this->thread->id]))
                ->assertSee($reply->body);
    }

    /**
     * @test
     */
    public function user_can_filter_threads_according_to_a_channel() {

        $channel = factory('App\Channel')->create();
        $threadInChannel = factory('App\Thread')->create(['channel_id' => $channel->id]);
        $threadNotInChannel = factory('App\Thread')->create();

        $string = '/threads/' . $channel->slug;

        $this->get($string)
                ->assertSee($threadInChannel->title)
                ->assertDontSee($threadNotInChannel->title);
    }

    /**
     * @test
     */
    public function user_can_filter_threads_by_username() {
        $this->be($user = factory('App\User')->create(['name' => 'UserTest']));

        $threadByUserTest = factory('App\Thread')->create(['user_id' => $user->id]);
        $threadNotByUserTest = factory('App\Thread')->create();

        $this->get('threads?by=UserTest')
                ->assertSee($threadByUserTest->title)
                ->assertDontSee($threadNotByUserTest->title);
    }
    
    /**
     * @test
     */
    public function user_can_filter_threads_by_popularity() {
        $threadTwoReplies = factory('App\Thread')->create();
        factory('App\Reply', 2)->create(['thread_id' => $threadTwoReplies->id]);
        
        $threadThreeReplies = factory('App\Thread')->create();
        factory('App\Reply', 3)->create(['thread_id' => $threadThreeReplies->id]);
        
        $threadNoReplies = $this->thread;
        
        $response = $this->getJson(route('threads.index', '?popular=1'))->json();
    
        /*
         * les sujets doivent aller du plus populaire au moins 
         * populaire selon leurs nombre de commentaires
         */
        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
    }

}

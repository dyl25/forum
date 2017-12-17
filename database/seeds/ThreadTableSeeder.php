<?php

use Illuminate\Database\Seeder;

class ThreadTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('threads')->truncate();
        factory(App\Thread::class, 50)
                ->create()
                ->each(function($thread) {
                    factory(\App\Reply::class, 10)
                    ->create(['thread_id' => $thread->id]);
                });
    }

}

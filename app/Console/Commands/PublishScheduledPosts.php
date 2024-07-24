<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PublishScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-scheduled-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled posts';
    /**
     * Execute the console command.
     */

    public function handle()
    {
        $this->info('Starting publish scheduled posts command...');
        $this->info('Current time: ' . now());

        DB::statement('PRAGMA busy_timeout = 60000;'); // I am increasing the sqlite timeout to 60 seconds

        try {
            DB::transaction(function () {
                $postsToPublish = Post::where('status', 'draft')
                    ->where('scheduled_at', '<=', now()->addHour())
                    ->get();

                $this->info('Found ' . $postsToPublish->count() . ' posts to publish.');

                $updatedCount = 0;
                foreach ($postsToPublish as $post) {

                    $updated = DB::table('posts')
                        ->where('id', $post->id)
                        ->where('status', 'draft')
                        ->update(['status' => 'published']);

                    if ($updated) {
                        $updatedCount++;
                        $this->info("Successfully updated Post ID: {$post->id}");
                    } else {
                        $this->warn("Failed to update Post ID: {$post->id}");
                    }
                }

                $this->info("Updated $updatedCount posts.");
            }, 5); // Retrial strategy
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

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
        Post::where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->update(['status' => 'published']);

        $this->info('Scheduled posts have been published.');
    }
}

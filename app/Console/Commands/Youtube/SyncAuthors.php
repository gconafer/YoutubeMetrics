<?php

namespace App\Console\Commands\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Author;
use App\Entities\Comment;
use App\Jobs\Youtube\UpdateChannelInformation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class SyncAuthors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:authors-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация профилей каналов';

    /**
     * @param Client $client
     */
    public function handle(Client $client)
    {
        $authors = Comment::select('channel_id')->whereDoesntHave('author')->groupBy('channel_id')->pluck('channel_id');

        foreach ($authors as $id) {
            dispatch(new UpdateChannelInformation($id));
        }
    }
}
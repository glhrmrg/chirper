<?php

namespace App\Listeners;

use App\Events\ChirpCreated;
use App\Notifications\NewChirp;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class SendChirpCreatedNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ChirpCreated  $event
     * @return void
     */
    public function handle(ChirpCreated $event)
    {
        foreach (User::whereNot('id', $event->chirp->user_id) -> cursor() as $user) {
            $user->notify(new NewChirp($event->chirp));
        }
    }
}

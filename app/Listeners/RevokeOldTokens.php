<?php

namespace App\Listeners;

use Laravel\Passport\Events\AccessTokenCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RevokeOldTokens
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
     * @param  AccessTokenCreated  $event
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        if (isset(auth()->user()->tokens)) {
            auth()->user()->tokens->each(function ($token, $key) use ($event) {
                if ($event->tokenId <> $token->id) {
                    $token->delete();
                }
            });
        }
    }
}

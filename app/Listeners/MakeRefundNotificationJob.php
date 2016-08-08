<?php

namespace App\Listeners;

use App\Events\BookWasAddedToUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeRefundNotificationJob
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
     * @param  BookWasAddedToUser  $event
     * @return void
     */
    public function handle(BookWasAddedToUser $event)
    {
        //
    }
}

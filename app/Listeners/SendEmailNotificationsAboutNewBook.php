<?php

namespace App\Listeners;

use App\Events\BookWasCreated;
use App\Jobs\InformUserAboutNewBook;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Book;
use Illuminate\Support\Facades\Queue;

class SendEmailNotificationsAboutNewBook
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  BookWasCreated  $event
     * @return void
     */
    public function handle(BookWasCreated $event)
    {
        $users = User::all();
        foreach ($users as $user) {
            
            Queue::push(new InformUserAboutNewBook($user,$event->book));
        }
    }
}

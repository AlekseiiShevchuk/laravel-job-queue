<?php

namespace App\Events;

use App\Book;
use App\Events\Event;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BookWasCreated extends Event
{
    use SerializesModels;

    public $book;
    public $user;

    /**
     * Create a new event instance.
     *
     * @param Book $book
     */
    public function __construct(Book $book, User $user)
    {
        $this->book = $book;
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}

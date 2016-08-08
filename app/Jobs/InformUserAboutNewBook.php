<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\User;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InformUserAboutNewBook extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $book;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Book $book)
    {
        $this->user = $user;
        $this->book = $book;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $mailer->send('mail.InformUserAboutNewBook', ['user' => $this->user,'book' => $this->book], function($m){
           $m->to($this->user->email, $this->user->name)->subject('New Book Added to the Library');
        });
    }
}

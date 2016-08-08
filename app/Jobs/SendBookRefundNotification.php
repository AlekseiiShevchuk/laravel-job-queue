<?php

namespace App\Jobs;

use App\Book;
use App\Jobs\Job;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBookRefundNotification extends Job implements ShouldQueue
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
        if($this->book->user_id == $this->user->id){
            $mailer->send('mail.NotifyUserAboutBookRefund', ['user' => $this->user,'book' => $this->book], function($m){
                $m->to($this->user->email, $this->user->name)->subject('Refund the book!');
            });
        }else{
            //do nothing
        }

    }
}

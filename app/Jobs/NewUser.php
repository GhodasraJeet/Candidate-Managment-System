<?php

namespace App\Jobs;

use App\Mail\SendPasswordResetLink;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class NewUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user=null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($hr)
    {
        $this->user=$hr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user['email'])->send(new SendPasswordResetLink($this->user['email']));
    }
}

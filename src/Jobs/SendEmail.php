<?php

namespace Juzaweb\Email\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Juzaweb\Email\Models\EmailList;
use Juzaweb\Email\SendEmailService;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mail;
    /**
     * Create a new job instance.
     *
     * @param EmailList $mail
     * @return void
     */
    public function __construct($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        (new SendEmailService($this->mail))->send();
    }
}

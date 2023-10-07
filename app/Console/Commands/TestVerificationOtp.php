<?php

namespace App\Console\Commands;

use App\Jobs\SendMail;
use App\Mail\VerificationOtp;
use App\Models\User;
use Illuminate\Console\Command;

class TestVerificationOtp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:verification-otp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::first();

        $mailable = new VerificationOtp($user->name, "123456");

        SendMail::dispatch($user->email, $mailable);
    }
}

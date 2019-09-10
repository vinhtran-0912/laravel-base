<?php

namespace App\Console\Commands;

use Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Console\Command;

class RegisteredUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registered:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email of registered users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = \DB::table('users')
                  ->whereRaw('Date(created_at) = CURDATE()');
        Mail::to('krunal@appdividend.com')->send(new WelcomeEmail());
    }
}

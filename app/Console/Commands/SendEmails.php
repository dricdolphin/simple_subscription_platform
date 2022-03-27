<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SendMailController;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:sendemails {post_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send posts to subscribers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->comment("Send posts id:{$this->argument('post_id')} to Subscribers");
        //Route::get('send-mail', [SendMailController::class, 'send_mail']);
        $controller = new SendMailController(); // make sure to import the controller
        $controller->send_mail(['post_id' => $this->argument('post_id')]);
        
        return 0;
    }
}

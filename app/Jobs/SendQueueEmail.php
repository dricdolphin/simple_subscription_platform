<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_subscription;
use App\Models\User_sent_post;
use App\Models\Website;
use App\Http\Controllers\API\User_sent_postController;
use Mail;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    public $timeout = 7200; // 2 hours

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users_subscribed_id = User_subscription::where('website_id', $this->details['website_id'])->get()->pluck('user_id')->toArray();
        $users_sent_post_id = User_sent_post::where('post_id', $this->details['post_id'])->get()->pluck('user_id')->toArray();
        $users_subscribed_but_not_sent_post_id = array_diff($users_subscribed_id, $users_sent_post_id );

        $users = User::whereIn('id', $users_subscribed_but_not_sent_post_id)->get();

        $input['subject'] = $this->details['subject'];
        $input['post_title'] = $this->details['title'];
        $input['full_post_address'] = "{$this->details['website_address']}/{$this->details['post_address']}";
        $input['post_description'] = $this->details['description'];

        $user_sent_postcontroller = new User_sent_postController();
        foreach ($users as $user) {
                $input['email'] = $user->email;
                $input['name'] = $user->name;
                
                echo("{$input['subject']} sent to {$input['name']} <{$input['email']}> \n");
                
                \Mail::send('mails.mail', $input, function($message) use($input){
                    $message->to($input['email'], $input['name'])
                        ->subject($input['subject']);
                });

                //Once it's sent, update the User_sent_post model so as to flag that the subscriber received the post
                //making sure that  'No duplicate stories should get sent to subscribers'.
                $user_sent_postcontroller->store(Request::create('store-user_sent_post', 'POST', ['user_id' => $user->id, 'post_id' => $this->details['post_id']]));
                
        }
    }
}
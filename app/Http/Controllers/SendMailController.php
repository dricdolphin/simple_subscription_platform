<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Website;

class SendMailController extends Controller
{
    public function send_mail(Array $request)
    {
    	$post = Post::findOrFail($request['post_id'])->toArray();
        $website = Website::findOrFail($post['website_id'])->toArray();

        $details = [
    		'website_id' => $post['website_id'],
            'website_address' => $website['address'],
            'post_id' => $request['post_id'],
            'subject' => "New Post on '{$website['title']}'",
            'title' => $post['title'],
            'post_address' => $post['post_address'],
            'description' => $post['description']
    	];
    	
        $job = (new \App\Jobs\SendQueueEmail($details))
            	->delay(now()->addSeconds(2)); 

        dispatch($job);
        dd('Job dispatched!');
    }
}
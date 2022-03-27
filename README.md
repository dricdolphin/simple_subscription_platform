## SIMPLE_SUBSCRIPTION_PLATFORM

This is a simple subscription platform that's supposed to the the following scope:

Create a simple subscription platform (only RESTful APIs with MySQL) in which users can subscribe to a website (there can be multiple websites in the system). 

Whenever a new post is published on a particular website, all it's subscribers shall receive an email with the post title and description in it. (no authentication of any kind is required)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Laravel dependencies

This code will require Sail and laravelcollective/html to be run 

## Current API endpoints

Route::apiResource('process_new_post', PostController::class); -- Used to create new posts (can be called externally)
Route::apiResource('process_new_user_subscription', UserSubscriptiontController::class); -- Used for user subscriptions
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User_subscription;

class User_subscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = User_subscription::all();
        return response()->json($subscriptions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $request->validate([
            'user_id' => 'required|exists:users,id',
            'website_id' => 'required|exists:websites,id'
          ]);
          
          $newSubscription = new User_subscription([
            'user_id' => $request->user_id,
            'website_id' => $request->website_id,
          ]);

          //The database will automatically validate if the user is already subscribed to a particular website_id, and it will throw
          //a SQL error if it does (needs to implement better error treatment in such case)
          try { 
            $newSubscription->save();
          } catch(QueryException $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
          }
        
        return redirect('/')->withSuccess($newSubscription);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subscription = User_subscription::findOrFail($id);
        return response()->json($subscription);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscription = User_subscription::findOrFail($id);
        $subscription->delete();
    
        return response()->json($subscription::all());
    }
}

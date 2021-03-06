<?php

namespace App\Http\Controllers;

use App\CategorySubscription;
use Illuminate\Http\Request;
use App\Category;
use Auth;
use DB;
class CategorySubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //$category->subscribe();
    }

    public function subscribe(Request $request){
        $category_id = $request['category_id'];
        $isSubscribe = $request['subscribed'] === 'true';
        $update = false;
        $category = Category::find($category_id);
        if (!$category) {
            return null;
        }
        $user = Auth::user();
        $subscribe = $user->categorySubscriptions()->where('category_id', $category_id)->first();
        if($subscribe){
            $hasSubscribed = $subscribe->subscribed;
            $update = true;
            if($hasSubscribed == $isSubscribe){
                $subscribe->delete();
                return null;
            }
        }
        else{
            $subscribe = new CategorySubscription;
        }

        //dd($subscribe);
        $subscribe->subscribed = $isSubscribe;
        $subscribe->user_id = $user->id;
        $subscribe->category_id = $category_id;
        if($update) {
            $subscribe->update();
        }
        else {
            $subscribe->save();  
        }            
        return null;

        

        
        // return null;
    }

    public function unsubscribe(Request $request){
        $category_id = $request['category_id'];
        $user_id = Auth::user()->id;

        $subscribe = CategorySubscription::select('id')->where('category_id','=' ,$category_id)->where('user_id','=', $user_id);

        if($subscribe){
            $subscribe->delete();
            return null;
        }
        // $category = CategorySubscription::find($id);
        
        // $category_id = $request['category_id'];
        // $isSubscribe = $request['subscribed'] === 'false';

        // if (!$category) {
        //     return null;
        // }
        // $user = Auth::user();

        // $subscribe = $user->categorySubscriptions()->where('category_id', $category_id)->first();
        // if($subscribe){
        //     $subscribe->delete();
        //     return null;
        // }
        
        // return view('discover')->with('success', 'Unsubscribe Successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CategorySubscription  $categorySubscription
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CategorySubscription  $categorySubscription
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
     * @param  \App\CategorySubscription  $categorySubscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CategorySubscription  $categorySubscription
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // $categorySubscription->unsubscribe();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Carbon\Carbon;

class PagesController extends Controller
{
    public function index(){
       $posts = Post::latest()->with('tags')->first() 
       ->filter( request( ['month', 'year'] ) )
       ->paginate(5);

       

        return view('pages.index')->with(['posts' => $posts]);//, 'allPosts' => $allPosts]);
    }

    // public function login(){
    //     return view('pages.login');
    // }

    public function notifications(){
        return view('pages.notifications');
    }

    public function profile(){
        return view('pages.profile');
    }

    //public function publishModal(){
    //    return view('partials.publishModal');
    //}
    
    // public function registration(){
    //     return view('pages.registration');
    // }

    public function basicPermission(){
        return view('partials.basicPermission');
    }
    public function crudPermission(){
        return view('partials.crudPermission');
    }
    
    //public function myContent(){
    //    return view('pages.myContent');
    //}

}

@extends('layouts.app')

@section('header')
   <div class="header-image"  style="background-image: url('/storage/header_images/home-bg-2.jpg');">
      <div class="overlay"></div>
      <div class="container">
         <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
               <div class="site-heading">
                  <a class="h1">UEW<strong>Messenger</strong> <i class="fa fa-comment-alt"></i></a>
                  <span class="subheading">Access Announcements Anywhere, Anytime!</span>
                  @include('inc.messages')

                  <div class="site-heading-buttons mt-4">
                     @guest
                        <a href="/login" class="col-md-2 btn btn-primary mr-3 mb-2">Sign In <i class="fa fa-sign-in"></i></a>
                        <a href="/register" class="col-md-2 btn btn-success mb-2">Sign Up <i class="fa fa-user-plus"></i></a>
                     @endguest
                  </div>
               </div>
            </div>
         </div>
         
      </div>
   </div>
@endsection

@section('content')
   <div class="row justify-content-center">
      <div class="col-md-8 col-sm-12 " >
         <ul class="list-unstyled" id="newsStrip">
            @auth
               @if(count($posts) > 0)
                  @foreach($posts as $post)
                     <li>
                        {{-- New --}}
                           <!--- \\\\\\\Post-->
                        <div class="card gedf-card mb-3">
                           <div class="card-header">
                              <div class="d-flex justify-content-between align-items-center">
                                 <div class="d-flex">
                                       <div class="ml-2">
                                          <div class="h5 m-0 text-muted"><i class="fa fa-user"></i> {{$post->user->name}}</div>
                                          <small class="h7 text-muted">
                                             <i class="fa fa-clock"></i> {{$post->created_at->diffForHumans()}} &emsp; 
                                             <i class="fa fa-folder-open"></i> {{ $post->category->display_name }}
                                          </small> 
                                          {{-- {{ dd($post->category) }} --}}
                                       </div>
                                 </div>
                              </div>
                           </div>
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-md-3 col-sm-3">
                                    <img style="width: 100%;" class="mr-3  img-thumbnail" src="/storage/cover_images/{{$post->cover_image}}" alt="featured image">
                                 </div>
                                 <div class="col-md-8 col-sm-8">
                                    <h5 class="mt-0 mb-0"><a class="card-link" href="{{ route('posts.show', $post->id) }}">{{$post->title}}</a></h5>
                                    <p class="card-text">
                                          {{ substr(strip_tags($post->body), 0, 250) }}...
                                    </p>                                 
                                 </div>
                              </div>
                           </div>
                           <div class="card-footer">
                              <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary btn-block">Read</a>
                           </div>
                        </div>
                     <!-- Post /////-->
                        {{-- New End --}}
                     </li>
                  @endforeach

                  <span class="row justify-content-center"> {{$posts->links()}} </span>
               @else
                  <div class="card">
                     <div class="card-header">
                        <p class="h5 m-0 text-center">
                           <i class="fa fa-exclamation-circle text-danger"></i> Oops! No announcements found
                        </p>
                     </div>
                     <div class="card-body">
                        <p class="text-center">
                           No Announcements have been found for this Category.<br>
                           Please try again later.
                        </p>  
                     </div>
                  </div> 
               @endif

            @else
            
               @if(count($gen_ann_posts) > 0)
                  @foreach($gen_ann_posts as $post)
                     <li>
                        {{-- New --}}
                           <!--- \\\\\\\Post-->
                        <div class="card gedf-card mb-3">
                           <div class="card-header">
                              <div class="d-flex justify-content-between align-items-center">
                                 <div class="d-flex">
                                       <div class="ml-2">
                                          <div class="h5 m-0 text-muted"><i class="fa fa-user"></i> {{$post->user->name}}</div>
                                          <small class="h7 text-muted">
                                             <i class="fa fa-clock"></i> {{$post->created_at->diffForHumans()}} &emsp; 
                                             <i class="fa fa-folder-open"></i> {{ $post->category->display_name }}
                                          </small> 
                                          {{-- {{ dd($post->category) }} --}}
                                       </div>
                                 </div>
                              </div>
                           </div>
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-md-3 col-sm-3">
                                    <img style="width: 100%;" class="mr-3  img-thumbnail" src="/storage/cover_images/{{$post->cover_image}}" alt="featured image">
                                 </div>
                                 <div class="col-md-8 col-sm-8">
                                    <h5 class="mt-0 mb-0"><a class="card-link" href="{{ route('posts.show', $post->id) }}">{{$post->title}}</a></h5>
                                    <p class="card-text">
                                          {{ substr(strip_tags($post->body), 0, 250) }}...
                                    </p>                                 
                                 </div>
                              </div>
                           </div>
                           <div class="card-footer">
                              <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary btn-block">Read</a>
                           </div>
                        </div>
                     <!-- Post /////-->
                        {{-- New End --}}
                     </li>
                  @endforeach

                  <span class="row justify-content-center"> {{$gen_ann_posts->links()}} </span>
               @else
                  <div class="card">
                     <div class="card-header">
                        <p class="h5 m-0 text-center">
                           <i class="fa fa-exclamation-circle text-danger"></i> Oops! No announcements found
                        </p>
                     </div>
                     <div class="card-body">
                        <p class="text-center">
                           No Announcements have been found for this Category.<br>
                           Please try again later.
                        </p>  
                     </div>
                  </div> 
               @endif
            @endauth
         </ul>
      </div>
    
      
      <div class="col-md-3 card shadow">
         @include('inc.sidebar-right')
      </div>
   
</div>
@endsection

@section('scripts')
<script>
   $(document).ready(function(){
     $("#srch-term").on("keyup", function() {
       var value = $(this).val().toLowerCase();
       $("#newsStrip li").filter(function() {
         $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
       });
     });
   });
</script>
@endsection
@extends('website/layout')
@section('title')
{{$users->name}} profiel | Wall of fame
@endsection
@section('footer')
<footer>
    <span> &copy;</span> Grafisch Lyceum Utrecht 2020 gemaakt met <i style="color:red;" class="fas fa-heart"></i>
</footer>
@endsection
@section('content')
<div class="header" style="background-image:url('{{$users->background}}');background:{{$users->background}};">
    <div class="iconprofile">
        @if ($users->profile_image == 'default.png')
        <img src="{{ asset('Website/default.png') }}" alt="{{$users->profile_image}} " class="photo" />
        @else
        <img src="{{ asset($pathuser.'/'.$users->id .'/'. $users->profile_image) }}" alt="{{$users->profile_image}}"
            class="photo" />
        @endif
    </div>
</div>
<div class="content1">
    <h3>{{$users->name}}</h3>
    <p><i>{{$users->opleiding}} </i></p>
    <p class="p1"> <i class="fas fa-angle-down"></i></p>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 about1">
                <h3>Over mij </h3>
                <p><i>"{{$users->about}}"</i></p>
            </div>
            <div class="col-md-6 contact">
                <h3> Contact information
                </h3>
                <div class="sites">
                    @if ($users->github != "#empty")
                    <a href="//{{$users->github}}"><i class="fab fa-github"></i></a>
                    @else
                    @endif
                    @if ($users->linkedin != "#empty")
                    <a href="//{{$users->linkedin}}"> <i class="fab fa-linkedin-in"></i></a>
                    @else
                    @endif
                    @if ($users->gitlab != "#empty")
                    <a href="//{{$users->gitlab}}"> <i class="fab fa-gitlab"></i></a>
                    @else
                    @endif
                </div>
                <div class="sites2">
                    <p>
                        <i class="fas fa-envelope">: {{$users->contactemail}}</i><br>
                        @if($users->website != "#empty")
                        <a href="//{{$users->website}}"> <i class="fas fa-globe-europe">:
                                {{$users->website}}</i>
                        </a>
                        @else
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@guest
<div class="form-group detail_like_guest">
    <label for="text">{{$users->rank}} Likes</label>
    <i style="color:red;" class="fa fa-heart"></i>
</div>
@else
@if(Auth::id() == $users->id)
<div class="form-group detail_like_guest">
    <label for="text">{{$users->rank}} Likes</label>
    <i style="color:red;" class="fa fa-heart"></i>
</div>
@else
<form class="likes_form" method="POST" action="{{ action('Updateusers@Like',[
            'id'=> $users->id,
            'rank' =>$users->rank,
            'authid'=>Auth::user()->id,
            'klas'=>$users->klas
            ])}}">
    @csrf
    <div class="form-group" style="margin-bottom: 0px">
        <label for="text">{{$users->rank}} Likes</label>
        @include('errors/flash')
    </div>
    <button type="submit" class="button button-like">
        <i class="fa fa-heart"></i>
        <span>Like</span>
    </button>
</form>
@endif
@endguest
@endsection

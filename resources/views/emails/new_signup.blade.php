@extends('beautymail::templates.widgets')

@section('content')

    {{-- @include ('beautymail::templates.widgets.heading' , [
        'heading' => "Welcome to Handiman Services!",
        'level' => 'h1',
    ]) --}}

    @include('beautymail::templates.widgets.articleStart',['color'=>'white'])
    
    <h1 class="primary">Welcome to Handiman Services!</h1>

    @include('beautymail::templates.widgets.newfeatureStart', ['color'=>'#ffbf00'])
    <h4><em>Don't let that fix bother you anymore - you've got Handiman now!</em></h4>
    @include('beautymail::templates.widgets.newfeatureEnd')

        <p>Hi {{$user->name}}, welcome to Handiman Services!
            <br>Your new service account has been created. You can log in using your provided email address [{{$user->email}}] and password[...].
        <button style="background-color: #ffbf00; border: 1px solid #ffbf00;">
            <a href="{{route('login')}}" 
            style="font-weight: bold; color: white;">Here</a> 
        </button><br>
            {{-- @include('beautymail::templates.sunny.button', 
            ['text' => 'Try It', 'link' => 'http://www.handiman.ng', 'color' =>'#ffbf00']) --}}
        </p>
    @include('beautymail::templates.widgets.newfeatureStart', ['color'=>'black'])
        <h2>What is Handiman Services?</h2>
        <p>
            Handiman services provides a range of maintenance duties for homeowners and corporate bodies. Our services include providing repair assessments, fixing of plumbing and electrical systems, major and minor repairs and civil construction/ remodeling works. <button style="background-color: black; border: 1px solid black;">
            <a href="{{route('home')}}" 
            style="font-weight: bold; color: white;">More about us</a>
        </button><br>
        Requesting for any maintenance service is a breeze with our user friendly and simply designed Web App, it only takes a few steps<br>
        <button style="background-color: #ffbf00; border: 1px solid #ffbf00;">
            <a href="{{route('request')}}" 
            style="font-weight: bold; color: white;"><h1>Request Now</h1></a> 
        </button> 
            {{-- @include('beautymail::templates.sunny.button', 
            ['text' => 'More About Us', 'link' => 'http://www.handiman.ng/about-us', 'color' =>'black']) --}}
        </p>
    @include('beautymail::templates.widgets.newfeatureEnd')

    @include('beautymail::templates.widgets.newfeatureStart', ['color'=>'#ffbf00'])
        <h2>How does Handiman Work?</h2>
        <p>
            The process of requesting for service using our Web App is very quick and easy.
            Get details 
        <button style="background-color: #ffbf00; border: 1px solid #ffbf00;">
            <a href="{{route('home')}}" 
            style="font-weight: bold; color: white;">Here</a> 
        </button>
            {{-- @include('beautymail::templates.sunny.button', 
            ['text' => 'How It Works', 'link' => 'http://www.handiman.ng/how-it-works', 'color' =>'black']) --}}
        </p>
    @include('beautymail::templates.widgets.newfeatureEnd')
    
    @include('beautymail::templates.widgets.articleStart', ['color'=>'black'])
        <p>We hope to earn your trust through our top notch services.<br>
            Sincerely,<br>
            Handiman Services
        </p>
    @include('beautymail::templates.widgets.articleEnd')

    @include('beautymail::templates.widgets.articleEnd')
    <style type="text/css">
        button{
            border-radius: 1px;
            margin: 10px;
        }
    </style>
@stop
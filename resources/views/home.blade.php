@extends('layouts.theme')

@section('content')

    <div class="home-hero-section">



        <div class="job-search-bar">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Find your Desired Service</h1>
                        <p class="mt-4 mb-4 job-search-sub-text">
                            <p class="text-muted mb-1 mt-1" >
                            <span class="single-skill request">
                                <em>Search and Request for your desired Service get Served by Qualified Artisans<br>
                                    ..all from your position of Comfort
                                </em>
                            </span> 
                            <span class="text-small text-muted"></span>
                        </p>
                        </p>
                        
                    </div>
                </div>

                <div class="row ">
                    <div class="col-md-12">

                        <form action="{{route('request-service')}}" class="form-inline" method="post" id="search_form">
                            @csrf
                            <div class="form-row">
                                <div class="col-auto">
                                    <select type="text" name="search_term" id="" class="form-control mb-2" 
                                    style="min-width: 300px;">
                                        <option value="">--Select preferred category--</option>
                                        @foreach($categories as $cat)
                                        <option value="{{$cat->category_slug}}">{{$cat->category_name}}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-success mb-2" style="background-color: #fb7400;; border: 1px solid #fb7400;;">
                                        Request Service <i class="la la-arrow-circle-o-right"></i>
                                    </button>
                                    {{-- <details><summary>Title</summary><p>Trials Trials</p></details> --}}
                                    <table class="table table-bordered table-hover">
                                        <tbody id="suggestions">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>

        </div>

    </div>


       {{-- <div class="home-categories-wrap bg-white pb-5 pt-5" id="categories">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                            <h4 class="mb-3">@lang('app.browse_category')</h4>
                    </div>
                </div>
                
                <div class="row">

                    @foreach($categories as $cat)
                        <div class="col-md-4">
                            <div class="employer-job-listing-single cat {{$cat->category_name}} box-shadow bg-white mb-3 p-3" onclick="window.location.href='{{route('cat-tile-request', $cat->category_slug)}}'">
                                <div class="listing-job-info">
                                    <h5><a href="">{{$cat->category_name}}</a> </h5>
                                    <p class="text-muted mb-1 mt-1">
                                        <span class="single-skill request">
                                            Request this service <i class="la la-arrow-circle-o-right"></i>
                                        </span> 
                                        <span class="text-small text-muted"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>--}}



        {{-- <div class="premium-jobs-wrap pb-5 pt-5">

            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mb-3">@lang('app.premium_jobs')</h4>
                    </div>
                </div>

                <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="premium-job-box p-3 bg-white box-shadow">

                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="premium-job-logo">
                                            <a href="">
                                                <img src="" class="img-fluid" />
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-md-8 col-sm-6">

                                        <p class="job-title">
                                            <a href=""></a>
                                        </p>

                                        <p class="text-muted m-0">
                                            <a href="" class="text-muted">
                                                
                                            </a>
                                        </p>

                                        <p class="text-muted m-0">
                                            <i class="la la-map-marker"></i>
                                            
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>

        </div> --}}



    {{-- <div class="new-registration-page bg-white pb-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="home-register-account-box">
                        <h4>@lang('app.job_seeker')</h4>
                        <p class="box-icon"><img src="{{asset('assets/images/employee.png')}}" /></p>
                        <p>@lang('app.job_seeker_new_desc')</p>
                        <a href="{{route('new_register')}}" class="btn btn-success"><i class="la la-user-plus"></i> @lang('app.register_account') </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="home-register-account-box">
                        <h4>@lang('app.employer')</h4>
                        <p class="box-icon"><img src="{{asset('assets/images/enterprise.png')}}" /></p>
                        <p>@lang('app.employer_new_desc')</p>
                        <a href="{{route('register_employer')}}" class="btn btn-success"><i class="la la-user-plus"></i> @lang('app.register_account') </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="home-register-account-box">
                        <h4>@lang('app.agency')</h4>
                        <p class="box-icon"><img src="{{asset('assets/images/agent.png')}}" /></p>
                        <p>@lang('app.agency_new_desc')</p>
                        <a href="{{route('register_agent')}}" class="btn btn-success"><i class="la la-user-plus"></i> @lang('app.register_account') </a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


        {{-- <div class="regular-jobs-wrap pb-5 pt-5">

            <div class="container">
                <div class="regular-job-container p-3">

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-3">@lang('app.new_jobs')</h4>
                        </div>
                    </div>

                    <div class="row">
                            <div class="col-md-4 mb-3">

                                <div class="row">
                                    <div class="col-md-12">

                                        <p class="job-title m-0">
                                            <a href=""></a>
                                        </p>

                                        <p class="text-muted  m-0">
                                            <i class="la la-map-marker"></i>
                                           
                                        </p>

                                    </div>
                                </div>

                            </div>

                    </div>


                </div>

            </div>


        </div> --}}

    {{-- <div class="pricing-section bg-white pb-5 pt-5">
        <div class="container">

            <div class="row">
                <div class="col-md-12">

                    <div class="pricing-section-heading mb-5 text-center">

                        <h1>Pricing</h1>
                        <h5 class="text-muted">Choose a package to unlock Premium/Regular jobs posting ability.</h5>
                        <h5 class="text-muted">To get a large amount of quality application, choose the premium package</h5>
                    </div>

                </div>
            </div>


            <div class="row">

                <div class="col-xs-12 col-md-4">
                    <div class="pricing-table-wrap bg-light pt-5 pb-5 text-center">
                        <h1 class="display-4">$0</h1>
                        <h3>Free</h3>

                        <div class="pricing-package-ribbon pricing-package-ribbon-light">Regular</div>

                        <p class="mb-2 text-muted"> No Premium Job Post</p>
                        <p class="mb-2 text-muted"> Unlimited Regular Job Post</p>
                        <p class="mb-2 text-muted"> Unlimited Applicants</p>
                        <p class="mb-2 text-muted"> Dashboard access to manage application</p>
                        <p class="mb-2 text-muted"> No support available</p>

                        <a href="{{route('new_register')}}" class="btn btn-success mt-4"><i class="la la-user-plus"></i> Sign Up</a>
                    </div>
                </div>

                    <div class="col-xs-12 col-md-4">
                        <div class="pricing-table-wrap bg-light pt-5 pb-5 text-center">
                            <h1 class="display-4"></h1>
                            <h3></h3>
                            <div class="pricing-package-ribbon pricing-package-ribbon-green">Premium</div>

                            <p class="mb-2 text-muted"> Premium Jobs Post</p>
                            <p class="mb-2 text-muted"> Unlimited Regular Job Post</p>
                            <p class="mb-2 text-muted"> Unlimited Applicants</p>
                            <p class="mb-2 text-muted"> Dashboard access to manage application</p>
                            <p class="mb-2 text-muted"> E-Mail support available</p>
                            <a href="" class="btn btn-success mt-4"> <i class="la la-shopping-cart"></i> Purchas Package</a>
                        </div>
                    </div>
            </div>

        </div>
    </div>



    <div class="home-blog-section pb-5 pt-5">
        <div class="container">

            <div class="row">
                <div class="col-md-12">

                    <div class="pricing-section-heading mb-5 text-center">
                        <h1>From Our Blog</h1>
                        <h5 class="text-muted">Check the latest updates/news from us.</h5>
                    </div>

                </div>
            </div>


            <div class="row">

                @foreach($blog_posts as $post)

                    <div class="col-md-4">

                        <div class="blog-card-wrap bg-white p-3 mb-4">

                            <div class="blog-card-img mb-4">
                                <img src="{{$post->feature_image_thumb_uri}}" class="card-img" />
                            </div>

                            <h4 class="mb-3">{{$post->title}}</h4>

                            <p class="blog-card-text-preview">{!! limit_words($post->post_content) !!}</p>

                            <a href="{{route('blog_post_single', $post->slug)}}" class="btn btn-success"> <i class="la la-book"></i> Read More</a>

                            <div class="blog-card-footer border-top pt-3 mt-3">
                                <span><i class="la la-user"></i> {{$post->author->name}} </span>
                                <span><i class="la la-clock-o"></i> {{$post->created_at->diffForHumans()}} </span>
                                <span><i class="la la-eye"></i> {{$post->views}} </span>
                            </div>
                        </div>


                    </div>

                @endforeach

            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="home-all-blog-posts-btn-wrap text-center my-3">

                        <a href="" class="btn btn-success btn-lg"><i class="la la-link"></i> @lang('app.all_blog_posts')</a>

                    </div>
                </div>
            </div>


        </div>
    </div> --}}



   {{-- <div class="new-registration-page bg-white pb-5 pt-5">
        <div class="container">
            <div class="row">

                <div class="col-md-12">

                    <div class="call-to-action-post-job justify-content-center">
                        <div class="job-post-icon ">
                            <img src="{{asset('assets/images/no-search.png')}}" height="170" />
                        </div>
                        <div class="job-post-details mr-3 ml-3 p-3 my-auto">
                            <h1>Didn't find your desired service?</h1>
                            <p>
                                <em>No worries...<br>Just enter it below and request</em> <br />
                                <form class="form-inline" action="{{route('request-service')}}" method="post">
                                    @csrf
                                    <input type="text" name="new-cat" class="form-control mb-2" id="add-new" placeholder="Enter here..">
                                    <button type="submit" class="btn btn-success mb-2">
                                        Request <i class="la la-arrow-circle-o-right"></i>
                                    </button>
                                    <table class="table table-bordered table-hover" style="max-width: 297px;">
                                        <tbody id="new-cat_show">
                                            
                                        </tbody>
                                    </table>
                                </form>
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>--}}

    {{-- <div class="job-stats-footer pb-5 pt-5 text-center">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-muted mb-3">Our website stats</h2>
                    <p class="text-muted mb-4">Here the stats of how many people we've helped them to find jobs, hired talents</p>

                </div>
            </div>


            <div class="row">
                <div class="col-md-3">
                    <h3>15M</h3>
                    <h5>Job Applicants</h5>
                </div>

                <div class="col-md-3">
                    <h3>12M</h3>
                    <h5>Job Posted</h5>
                </div>
                <div class="col-md-3">
                    <h3>8M</h3>
                    <h5>Employers</h5>
                </div>
                <div class="col-md-3">
                    <h3>15M</h3>
                    <h5>Recruiters</h5>
                </div>
            </div>
        </div>
    </div> --}}

@endsection

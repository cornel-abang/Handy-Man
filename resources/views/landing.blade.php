@extends('layouts.landing')

@section('content')

    <!-- ======= Home Section ======= -->
    <section class="section">
      <div class="container">

        <div class="row justify-content-center text-center mb-5" style="margin-top: 5px !important;">
          <div class="col-md-5" data-aos="fade-up">
            <h2 class="section-heading">What we do?</h2><br>
            <h4 class="sub-service-text">Here's an overview</h4>
          </div>
        </div>

        <div class="row justify-content-center text-center">
          <div class="col-md-8 overview-text">
            <p class="services-text"> We provide expertise and a detail-oriented mindset in carrying out all our works, whether in your home or office. If you have a tough problem others can’t quite fix or figure out, we’ll be able to diagnose and fix it. Our highly qualified technicians will provide you with upfront diagnosis and analysis to help you with any and every issue. <b>Our services mainly include:</b></p>
          </div>
        </div>

        <div class="row services-graphics">
          <div class="col-md-6 what-img" data-aos="fade-up" data-aos-delay="">
            {{-- <div class="feature-1 text-center"> --}}
              <img src="{{ asset('assets/landing/img/what.png')}}" alt="Image" class="what img-fluid" data-aos="fade-right" data-aos-delay="200">
            {{-- </div> --}}
          </div>
          <div class="col-md-6 services-list" data-aos="fade-up" data-aos-delay="100">
            <div class="feature-1 row">
              <div class="col-md-6"  style="margin-bottom: 25px;">
                <div class="row service-area">
                  <div class="col-md-6">
                    <img src="{{ asset('assets/landing/img/pipe.png')}}" class="wrap-icon icon-1"><br>
                  </div>
                  <span class="badge badge-success">Plumbing repairs & fixture</span>
                </div>
                <a href="{{route('request-service', 'plumbing')}}" class="request-service la la-hard-hat"> Request Service</a>
              </div>
              <div class="col-md-6" style="margin-bottom: 25px;">
                <div class="row service-area">
                  <div class="col-md-6">
                      <img src="{{ asset('assets/landing/img/electric.png')}}" class="wrap-icon icon-1">
                  </div>
                  <span class="badge badge-success">Electrical installations and repairs</span>
                </div>
                <a href="{{route('request-service', 'electricals')}}" class="request-service la la-hard-hat"> Request Service</a>
              </div>
              <div class="col-md-6" style="margin-bottom: 25px;">
                <div class="row service-area">
                  <div class="col-md-6">
                      <img src="{{ asset('assets/landing/img/pool.png')}}" class="wrap-icon icon-1">
                  </div>
                  <span class="badge badge-success">Swimming pool maintenance</span>
                </div>
                <a href="{{route('request-service','pool-maintenance')}}" class="request-service la la-hard-hat"> Request Service</a>
              </div>
              <div class="col-md-6" style="margin-bottom: 25px;">
                <div class="row service-area">
                  <div class="col-md-6">
                      <img src="{{ asset('assets/landing/img/roof.png')}}" class="wrap-icon icon-1">
                  </div>
                  <span class="badge badge-success">Roof restoration and repairs</span>
                </div>
                <a href="{{route('request-service', 'roof-maintenance')}}" class="request-service la la-hard-hat"> Request Service</a>
              </div>
              <div class="col-md-6" style="margin-bottom: 25px;">
                <div class="row service-area">
                  <div class="col-md-6">
                      <img src="{{ asset('assets/landing/img/electronic.png')}}" class="wrap-icon icon-1">
                  </div>
                  <span class="badge badge-success">Installation & maintenance of electronics</span>
                </div>
                <a href="{{route('request-service', 'electronic-maintenance')}}" class="request-service la la-hard-hat"> Request Service</a>
              </div>
              <div class="col-md-6" style="margin-bottom: 25px;">
                <div class="row service-area">
                  <div class="col-md-6">
                      <img src="{{ asset('assets/landing/img/civil.png')}}" class="wrap-icon icon-1">
                  </div>
                  <span class="badge badge-success">Civil construction and remodeling work</span>
                </div>
                <a href="{{route('request-service', 'civil-constrcution-and-remodeling')}}" class="request-service la la-hard-hat"> Request Service</a>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>

    <section class="section jumbotron">

      <div class="container">

        <div class="row">
          <div class="col-md-4">
            <div class="step-off">
              <h3><span class="emphasis-white">Who</span> We Are?</h3>
              <p>We offer a one-stop shop for all office and household general repairs and maintenance services. Our facilities and management services hinges fundamentally on preventive and corrective maintenance by highly skilled Technicians who carry out all aspects of their duties in a prompt and professional manner. 
              </p>
              <p data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500">
                <a href="#" class="btn btn-outline-white1">Know More</a>
              </p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="step">
              <h3><span class="emphasis-white">What</span> We Do?</h3>
              <p>We provide a range of maintenance duties for homeowners & corporate bodies, including repair assessments, fixing of plumbing & electrical systems, major & minor repairs & civil construction/remodeling works. We guarantee an effective maintenance service, ensuring that your home and business continues to run smoothly.</p>
              <p data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500">
                <a href="#" class="btn btn-outline-white2">Request Service</a>
              </p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="step-off" style="padding: 32px !important;">
              <h3><span class="emphasis-white">Why</span> Choose Us?</h3>
              <p>
                <ul>
                  <li>Access to a pool of highly trained Technicians</li>
                  <li>Professional & reliable services 24/7 </li>
                  <li>Prompt response to service calls</li>
                  <li>Expert and a detail-oriented mindset to issues</li>
                  <li>Peace of mind & security</li>
                  <li>Use of genuine materials</li>
                </ul>
              </p>
              <p data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500">
                <a href="#" class="btn btn-outline-white1">Get started</a>
              </p>
            </div>
          </div>
        </div>
      </div>

    </section>

    <section class="section buzz-feed">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 mr-auto">
            <h2 class="mb-4">Why you need a Handiman?</h2>
            <h4 class="sub-service-text">Well the answer is a <span class="emphasis-black">Resounding Yes</span></h4>
            <p class="mb-4">Even though you can tackle the odd job here and there, it’s unlikely that you’re a pro at everything.<br> When facing the unexpected, don’t be stuck handling it yourself while stressing out the entire household or everyone in the office (including yourself). Hiring an expert handiman can prevent this from happening! Sit back, unwind and enjoy some much-deserved time off while the pros ensure all the angles are covered, saving you from having to worry about touch-ups or constant repair jobs.</p>
            <p><a href="#" class="btn btn-primary">Get a Handiman</a></p>
          </div>
          <div class="col-md-6" data-aos="fade-left">
            <img src="{{ asset('assets/landing/img/prof.png')}}" alt="Image" class="img-fluid">
          </div>
        </div>
      </div>
    </section>

  @endsection
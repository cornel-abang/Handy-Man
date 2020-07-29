<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Handiman - {!! !empty($title) ? $title : 'Handy Man' !!}</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/landing/img/favicon.png')}}" rel="icon">
  <link href="{{ asset('assets/landing/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Avenir-next">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/landing/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/landing/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/landing/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/line-awesome/css/line-awesome.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/landing/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/landing/css/style.css')}}" rel="stylesheet">
   <script type='text/javascript'>
        /* <![CDATA[ */
        var page_data = {!! pageJsonData() !!};
        /* ]]> */
    </script>
</head>

<body>

  <!-- ======= Mobile Menu ======= -->
  <div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
      <div class="site-mobile-menu-close mt-3">
        <span class="icofont-close js-menu-toggle"></span>
      </div>
    </div>
    <div class="site-mobile-menu-body"></div>
  </div>

  <!-- ======= Header ======= -->
  <header class="site-navbar js-sticky-header site-navbar-target" role="banner">

    <div class="container">
      <div class="row align-items-center">

        <div class="col-6 col-lg-2">
          <h1 class="mb-0 site-logo">
            <a href="index.html" class="mb-0">
              {{-- Handiman --}}
              <img src="{{asset('assets/images/logo.png')}}" />
            </a>
          </h1> 
        </div>

        <div class="col-12 col-md-10 d-none d-lg-block">
          <nav class="site-navigation position-relative text-right" role="navigation">

            <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
              <li class="active"><a href="{{route('home')}}" class="nav-link">Home</a></li>
              <li><a href="{{route('about_us')}}" class="nav-link">About Us</a></li>
              <li><a href="{{route('contact_us')}}" class="nav-link">Contact Us</a></li>
              <li><a href="{{route('request')}}" class="nav-link btn btn-outline-white">Request Service</a></li>
              <li><a href="{{route('login')}}" class="nav-link">
                <i  class="la la la-sign-in"></i> Login</a></li>
              <li><a href="{{route('new_register')}}" class="nav-link">
                <i  class="la la-user-plus"></i> Register</a></li>
            </ul>
          </nav>
        </div>

        <div class="col-6 d-inline-block d-lg-none ml-md-0 py-3" style="position: relative; top: 3px;">

          <a href="#" class="burger site-menu-toggle js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
            <span></span>
          </a>
        </div>

      </div>
    </div>

  </header>
  <!-- ======= Hero Section ======= -->
  <section class="hero-section jumbotron" id="hero">

    <div class="wave">

      <svg width="100%" height="355px" viewBox="0 0 1920 355" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
            <path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z" id="Path"></path>
          </g>
        </g>
      </svg>

    </div>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 hero-text-image">
          <div class="row">
            <div class="col-lg-7 text-lg-left tagline">
              <h1 data-aos="fade-right tag-header">
                The quality you expect <br>The service you deserve
              </h1>
              <p class="mb-5" data-aos="fade-right" data-aos-delay="100">Your one-stop shop for all office and household general repairs and maintenance services</p>
              <p data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500">
                <form action="{{route('request-service')}}" method="post">
                  @csrf
                  <select name="search_term" class="form-control" required="">
                    <option value="">--Select service category--</option>
                    @foreach($categories as $cat)
                    <option value="{{$cat->category_slug}}">{{$cat->category_name}}</option>
                    @endforeach
                  </select>
                  <button type="submit" class="btn btn-outline-white">Request</button>
                </form>
                {{-- <a href="#" class="btn btn-outline-white">Request service</a> --}}</p>
            </div>
            <div class="col-lg-5">
              <img src="{{ asset('assets/landing/img/landing.png')}}" alt="Image" data-aos="fade-right" class="landing-img">
            </div>
          </div>
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">
    @yield('content')
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer class="footer" role="contentinfo">
    <div class="container">
      <div class="row footer-details">
        <div class="col-md-4 mb-4 mb-md-0 about-area">
          <img src="{{asset('assets/images/logo-alt.png')}}" class="site-logo-footer" />
          <p>Handiman Services aims to provide home and business owners with quality maintenance and repair services at convenience. We know how frustrating it can be to find a quality and professional handyman, so we are here to serve you and strive to make your life easier when trying to improve or maintain your most important asset, your property.</p>
        </div>
        <div class="col-md-7 ml-auto">
          <div class="row site-section pt-0">
            <div class="col-md-6 mb-4 mb-md-0 social-bar">
              <h3>Follow Us</h3>
                <ul class="social">
                  <li><a href="#"><span class="icofont-twitter"></span></a></li>
                  <li><a href="#"><span class="icofont-facebook"></span></a></li>
                  <li><a href="#"><span class="icofont-instagram"></span></a></li>
                </ul>
            </div>
            <div class="col-md-6 mb-4 mb-md-0 contacts-bar">
              <h3>Contact Us</h3>
                <ul class="contacts">
                  <li><span class="icofont-ui-home"></span> 96 Mcc Road, Calabar</li>
                  <li><span class="icofont-ui-email"></span> info@handiman.ng</li>
                  <li><span class="icofont-ui-touch-phone"></span> 090 3774 3123</li>
                </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="row justify-content-center text-center">
        <div class="col-md-7">
          <p class="copyright">&copy; Copyright <span class="handi-footer">Handiman Services</span></p>
          <div class="credits">
             All Rights Reserved
          </div>
        </div>
      </div>

    </div>
  </footer>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/js/vendor/jquery-1.11.2.min.js') }}"></script>
  <script src="{{ asset('assets/landing/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/landing/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
  <script src="{{ asset('assets/landing/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('assets/landing/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('assets/landing/vendor/jquery-sticky/jquery.sticky.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/landing/js/main.js')}}"></script>

</body>

</html>


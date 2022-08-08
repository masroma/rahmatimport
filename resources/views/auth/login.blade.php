<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
   
    <link rel="stylesheet" href="{{ asset('templatelogin/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('templatelogin/css/owl.carousel.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('templatelogin/css/bootstrap.min.css') }}">
    
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('templatelogin/css/style.css') }}">

    <title>Login ASIK Paramadina</title>
  </head>
  <body>
  

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('{{ asset('kampuscikarang.jpg') }}');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <div class="mb-4">
              <h3>Masuk</h3>
              <p class="mb-4">Selamat datang di website ASIK Universitas Paramadina</p>
            </div>
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
    
            <form method="POST" action="{{ route('login') }}">
                @csrf
    
            {{-- <form action="#" method="post"> --}}
              <div class="form-group first">
                <label for="username">Email</label>
                {{-- <input type="text" class="form-control" id="username"> --}}
                <input id="email" class="form-control block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                {{-- <input type="password" class="form-control" id="password"> --}}
                <input id="password" class="form-control block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="current-password" />
                
              </div>
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> 
              </div>

              <input type="submit" value="Log In" class="btn btn-block btn-primary">

              <span class="d-block text-center my-4 text-muted">&mdash; or &mdash;</span>
              
              <div class="social-login">
              
                <a href="#" class="google btn d-flex justify-content-center align-items-center">
                  <span class="icon-google mr-3"></span> Login with  Google
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    
  </div>
    
    

    <script src="{{ asset('templatelogin/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('templatelogin/js/popper.min.js') }}"></script>
    <script src="{{ asset('templatelogin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('templatelogin/js/main.js') }}"></script>
  </body>
</html>
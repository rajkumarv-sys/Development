<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Error</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Use your design CSS -->
</head>
<body>
<div class="page-content d-flex align-items-center justify-content-center">
    <div class="row auth-page">
        <div class="col-md-12 col-xl-12 mx-auto pl-md-0 pr-md-0">

            <div class="card">
                <div class="row">

                    <div class="col-md-6 col-sm-12 col-xs-12">
                        
                        <div class="auth-form-wrapper py-3">
                            
                            <a href="#" class="noble-ui-logo d-block mb-5"><img src="{{ url('/storage/bi_logo_login.svg') }}" width="250"  alt="" title=""></a>
                            <!-- <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.</h5> -->

                            
                        </div>
                        <div class="container text-center mt-5">
                            <h1>Oops!</h1>
                            <p>We are unable to connect to the database at the moment.</p>
                            <p>Please try again later or Check with server team.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        
                        <div class="auth-left-wrapper"><img src="{{ url('/storage/Location-Illustration_2.png') }}" alt="Login page info">
                           <!--  <div class="col-12">
                            <span>Operational</span>
                            <span>Transactional</span>
                            <span>Competitive Advntg</span>
                            </div> -->
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>


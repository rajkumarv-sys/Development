@extends('layouts.master2')

@section('content')
<script src="https://www.google.com/recaptcha/api.js?render=6Lfg-F0sAAAAAMkKdmJZ4gJvT5AydWz6Fd7jjKPY"></script>

<script>
grecaptcha.ready(function () {
    grecaptcha.execute('6Lfg-F0sAAAAAMkKdmJZ4gJvT5AydWz6Fd7jjKPY', {action: 'login'})
    .then(function (token) {
        document.getElementById('recaptcha_token').value = token;
    });
});
</script>
<div class="page-content d-flex align-items-center justify-content-center">
    <div class="row auth-page">
        <div class="col-md-12 col-xl-12 mx-auto pl-md-0 pr-md-0">

            <div class="card">
                <div class="row">

                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="auth-form-wrapper py-3">
                            <a href="#" class="noble-ui-logo d-block mb-5"><img src="{{ url('/storage/bi_logo_login.svg') }}" width="250"  alt="" title=""></a>
                            <!-- <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.</h5> -->

                            @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                            @endif

                            @if($errors->any())
                            <ul>
                               
                                  @foreach ($errors->all() as $error)
                                    <li style="color:red;">{{ $error }}</li>
                                @endforeach
                            </ul>
                            @endif


                            <form action="{{url('logincheck')}}" method="POST" >
                                {{ csrf_field() }}
                                <div class="form-group my-4">
                                    <!-- <label class="small mb-1" for="inputEmailAddress">Email</label> -->
                                    <input class="form-control py-4"  id="inputEmailAddress" name="email" type="text" placeholder="Enter email address" />
                                    @if ($errors->has('email'))
                                    <span class="error">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group my-4" id="password_data">
                                    <!-- <label class="small mb-1" for="inputPassword">Password</label> -->
                                    <input class="form-control py-4" id="inputPassword" type="password" name="password" placeholder="Enter password" />
                                    @if ($errors->has('password'))
                                    <span class="error">{{ $errors->first('password') }}</span>
                                    @endif
                                     <input type="hidden" name="recaptcha_token" id="recaptcha_token">
            
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="" name="remember" id="rememberPasswordCheck" type="checkbox" style="accent-color: #f26522d9;position: absolute;left: 0;width: 1rem;height: 1.5rem;z-index: 1;" />
                                        <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!--  <a class="small" href="#">Forgot Password?</a> -->
                                    <button class="btn btn-primary btn-block" type="submit" name="submit">Login</button>
                                </div>

                                

                            </form>

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
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
    $("document").ready(function(){
          $('#inputEmailAddress').on('input', function() { 
               email=$(this).val();
               email_list=email.split("@");
               if($.inArray(email_list[1],[null,'',undefined]) == -1)
               {

                  email=email.toLowerCase();


                   if(email_list[1]=='mdlz.com')
                   {
                       $("#inputPassword").val("exq1234");
                       $("#password_data").hide();
                   }
                   else
                   {

                       $("#password_data").show();
                   }
               }
          });
    });
</script>      
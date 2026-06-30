@extends('layouts.app')

@section('content')

<!--
<div class="form-group mt-3">
    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>-->

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                   <!-- <form class="form-horizontal" method="POST" action="{{ route('login') }}"> -->
                        <form class="form-horizontal" method="POST" action="/logincheck">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}" id="password_data">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>      
</div>
@endsection
<script type="text/javascript">
    $("document").ready(function(){
          $('#email').on('input', function() {
               email=$(this).val();
               email_list=email.split("@");
               if($.inArray(email_list[1],[null,'',undefined]) == -1)
               {

                 if(email!='bi-mdlz-urban@mdlz.com')
                 {
                      if(email_list[1]=='mdlz.com')
                   {
                       $("#password").val("exq1234");
                       $("#password_data").hide();
                   }
                 }
                  
               } 
               else
               {
                 $("#password_data").show();
                 $("#password").val("");
               }
          }); 
    }); 
</script>      
@extends('layout.master2')

@section('content')
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
                                <p style="color:red;">Unauthorized Access !!! </p>
                            </ul>
                            @endif


                            <form action="{{url('logincheck')}}" method="POST" >
                                {{ csrf_field() }}
                                <div class="form-group my-4">
                                    <!-- <label class="small mb-1" for="inputEmailAddress">Email</label> -->
                                    <input class="form-control py-4"  id="inputEmailAddress" name="email" type="email" placeholder="Enter email address" />
                                    @if ($errors->has('email'))
                                    <span class="error">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group my-4">
                                    <!-- <label class="small mb-1" for="inputPassword">Password</label> -->
                                    <input class="form-control py-4" id="inputPassword" type="password" name="password" placeholder="Enter password" />
                                    @if ($errors->has('password'))
                                    <span class="error">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                        <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!--  <a class="small" href="#">Forgot Password?</a> -->
                                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                                </div>

                                

                            </form>

                        </div>

                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="auth-left-wrapper"><img src="{{ url('/storage/Location-Illustration_2.png') }}" alt="Login page info">
                            <div class="col-12">
                            <span>Operational</span>
                            <span>Transactional</span>
                            <span>Competitive Advntg</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
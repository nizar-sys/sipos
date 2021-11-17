@extends('layouts.auth')
@section('title', 'SI-POS | Reset Katasandi')

@section('content')
    <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                            <h1 class="text-white">Reset Password</h1>
                            <p class="text-lead text-white">Use these awesome forms to reset password account in your
                                project for free.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <!-- Table -->
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card bg-secondary border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="text-center text-muted mb-4">
                                <small>Sign up with credentials</small>
                            </div>
                            <form role="form" method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{$token}}">
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" name="email" placeholder="Email" type="text"
                                            value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i></div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" name="password" placeholder="New Password"
                                            type="password" value="{{ old('password') }}" id="password">
                                        <div class="input-group-prepend">
                                            <button type="button" onclick="seePassword(this)" class="input-group-text"
                                                id="seePass"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i></div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" name="password_confirmation" placeholder="Password Confirmation"
                                            type="password" id="password" value="{{ old('password_confirmation') }}">
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i></div>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary mt-4">Reset Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('c_js')
    <script>
        function regSpace(str) {
            str = str.replace(/\s+/g, '-');
            return $('input[name="username"]').val(str)
        }
    </script>
@endsection

@extends('layouts.app')
@section('title', 'SIPOS | Profile (' . Auth::user()->username . ')')

@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mt-4">
        <li class="breadcrumb-item"><a
                href="{{ route('home', ['role' => Auth::user()->role == '1' ? 'admin' : 'user']) }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('profile', ['slug' => Auth::user()->slug]) }}">Profile</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-4 order-xl-2">
            <div class="card card-profile">
                <img src="{{ asset('/assets/img/theme/img-1-1000x600.jpg') }}" alt="Image placeholder"
                    class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <form action="{{ route('change-ava') }}" id="form-upload" enctype="multipart/form-data"
                                method="post">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="oldImage" id="oldImage" value="{{ Auth::user()->avatar }}">
                                <input type="file" class="d-none" name="image" id="uploadImage"><img
                                    style="cursor: pointer;"
                                    src="{{ asset('/storage/avatarUsers/' . Auth::user()->avatar) }}"
                                    class="rounded-circle" id="avaImage">
                            </form>

                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                </div>
                <div class="card-body pt-0 mt-xl-5">
                    <div class="text-center">
                        <h5 class="h3">
                            {{ Auth::user()->username }}
                        </h5>
                        <div class="h5 mt-2">
                            <i
                                class="ni business_briefcase-24 mr-2"></i>{{ Auth::user()->role == '1' ? 'Admin' : 'User' }}
                            - SIPOS
                        </div>
                    </div>
                    <!-- Divider -->
                    <hr class="my-3">
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit profile </h3>
                        </div>
                        <div class="col-4 text-right">
                            <button onclick="$('#form-update-prof').submit()" title="Save Changes"
                                class="btn btn-outline-primary btn-primary"><span class="fas fa-save"></span></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-update-prof" action="{{ route('change-profile') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Username</label>
                                        <input type="text" id="input-username"
                                            class="form-control @error('username')
                                        is-invalid
                                        @enderror"
                                            placeholder="Username" onkeyup="regSpace(this.value)" name="username"
                                            value="{{ Auth::user()->username }}">

                                        @error('username')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address @if (Auth::user()->email_verified_at == null)
                                                <span class="text-danger" style="cursor: pointer"
                                                    onclick="verifEmail()">*email not
                                                    verified</span>
                                            @else
                                                <span class="text-primary">*email verified</span>
                                            @endif</label>
                                        <input type="email" id="input-email"
                                            class="form-control @error('email')
                                            is-invalid
                                        @enderror"
                                            placeholder="Email@example" value="{{ Auth::user()->email }}" name="email">
                                        @error('email')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                    </form>
                    <a href="#!" class="btn btn-sm btn-primary float-right">View All</a>
                    <h6 class="heading-small text-muted mb-4">Recent Activities</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- List group -->
                                <div class="list-group list-group-flush" style="overflow: auto;">
                                    @foreach ($data['activities'] as $activity)
                                        <a href="#!" class="list-group-item list-group-item-action">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <!-- Avatar -->
                                                    <img alt="Image placeholder"
                                                        src="{{ asset('/storage/avatarUsers/'.$activity->user->avatar) }}"
                                                        class="avatar rounded-circle">
                                                </div>
                                                <div class="col ml--2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h4 class="mb-0 text-sm">{{$activity->user->username}}</h4>
                                                        </div>
                                                        <div class="text-right text-muted">
                                                            <small>{{$activity->created_at->diffForHumans()}}</small>
                                                        </div>
                                                    </div>
                                                    <p class="text-sm mb-0">{{$activity->description}}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4" />
                </div>
            </div>
        </div>
    </div>
@endsection


@section('c_js')
    <script>
        $('#avaImage').on('click', function() {
            event.preventDefault();

            $('input[name="image"]').click()
        })

        function bacaGambar(input) {
            try {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#avaImage').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);

                    Swal.fire({
                        title: 'Lanjutkan pasang foto profile?',
                        text: "Jadikan gambar sebagai foto profile",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya!',
                        cancelButtonText: 'Batalkan'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#form-upload').submit()
                        } else {
                            $('#avaImage').attr('src', '/storage/avatarUsers/' + $('input[name="oldImage"]').val());
                        }
                    })
                }
            } catch (error) {

                Snackbar.show({
                    text: 'Error ' + error,
                    duration: 4000,
                });
                window.location.reload()
            }
        }

        $('input[name="image"]').change(function() {
            bacaGambar(this);
        });

        function regSpace(str) {
            str = str.replace(/\s+/g, '-');
            return $('input[name="username"]').val(str)
        }

        function verifEmail() {
            try {

                Swal.fire({
                    title: 'Verifikasi Email',
                    text: "Anda akan mem-verifikasi email sebagai email terdaftar",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!',
                    cancelButtonText: 'Batalkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        toastr.info('Loading...');
                        $.ajax({
                            url: "{{ route('verification.send') }}",
                            type: 'POST',
                            headers: {
                                'accept': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            success: (response) => {
                                Snackbar.show({
                                    text: response.message
                                })
                            },
                            error: (error) => {
                                Snackbar.show({
                                    text: error.message
                                })
                            }
                        })
                    }
                })
            } catch (error) {
                Snackbar.show({
                    text: 'Error ' + error
                })
            }
        }
    </script>
@endsection

@extends('front.Layouts.app')
@section('content')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        @if (Session::has('success'))
            <div class="alert alert-success">
             <p>{{ Session::get('status') }}</p>
            </div>
            @if (session::has('errors'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('errors') }}</p>
                </div>

            @endif
        @endif
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Reset Password</h1>
                    <form action="{{ route('account.reset.password.process') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" id="token" value="{{ $tokenString }}">
                        <div class="mb-3">
                            <label for="" class="mb-2">New Password*</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password">
                            @error('new_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="mb-3">
                            <label for="" class="mb-2">Confirm Password*</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                            @error('confirm_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="justify-content-between d-flex">
                        <button class="btn btn-primary mt-2">Reset Password</button>
                        </div>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <p>Do not have an account? <a  href="{{ route('account.registration') }}">Register</a></p>
                </div>
            </div>
        </div>
        <div class="py-lg-5">&nbsp;</div>
    </div>
</section>
@endsection


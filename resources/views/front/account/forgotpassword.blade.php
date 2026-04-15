@extends('front.Layouts.app')
@section('content')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        @if (Session::has('success')))
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
                    <h1 class="h3">Forgot Password</h1>
                    <form action="{{ route('account.forgot-password-process') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="mb-2">Email*</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="example@example.com" value="{{ old('email') }}">
                             @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="justify-content-between d-flex">
                        <button class="btn btn-primary mt-2">Password Reset </button>
                        </div>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <p>Do not have an account? <a  href="{{ route('login') }}">Back to login</a></p>
                </div>
            </div>
        </div>
        <div class="py-lg-5">&nbsp;</div>
    </div>
</section>
@endsection


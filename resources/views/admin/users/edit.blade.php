 @extends('front.Layouts.app')

@section('content')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.user') }}">Users</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.message')
                       <div class="card border-0 shadow mb-4">
                    <form action="" method="post" name="userForm" id="userForm">
@csrf
                    <div class="card-body  p-4">
                        <h3 class="fs-4 mb-1">Edit User</h3>
                        <div class="mb-4">
                            <label for="" class="mb-2">Name*</label>
                            <input type="text" placeholder="Enter Name" name="name" id="name" class="form-control" value="{{ $user->name }}">
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Email*</label>
                            <input type="text" placeholder="Enter Email" class="form-control" name="email" id="email" value="{{ $user->email }}">
                        <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Designation*</label>
                            <input type="text" placeholder="Designation" name="designation" id="designation" class="form-control" value="{{ $user->designation }}">
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Mobile*</label>
                            <input type="text" placeholder="Mobile" name="mobile" id="mobile" class="form-control" value="{{ $user->mobile }}">
                          <p></p>
                        </div>
                    </div>
                    <div class="card-footer  p-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    </form>
                </div>
                </div>

@endsection
@section('scripts')
    <script>
        $('#userForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.user.update',$user->id) }}",
                type: "put",
                data: $('#userForm').serializeArray(),
                dataType: "json",
                success: function(response) {
                    if (response.status == true) {

$('#name').removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html('');
                        $('#email').removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html('');
                        $('#designation').removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html('');
                        $('#mobile').removeClass('is-invalid')
                            .siblings('p').removeClass('invalid-feedback').html('');
                            window.location.href = "{{ route('profile') }}";
                    } else{
                    }
                     var errors = response.errors;
                        if (errors.name) {
                            $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors.name);
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('');
                        }
                        if (errors.email) {
                            $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors.email);
                        } else {
                            $('#email').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('');
                        }
                        if (errors.designation) {
                            $('#designation').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors.designation);
                        } else {

                            $('#designation').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('');
                        }

                        if (errors.mobile) {
                            $('#mobile').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors.mobile);
                        } else {
                            $('#mobile').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('');

                        }


                            // window.location.href = "{{ route('login') }}";

                }
            }
            );
        });

        </script>
@endsection

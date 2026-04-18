@extends('front.Layouts.app')
@section('content')

    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('front.account.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.message')
                    <form action="" method="POST" name="createform" id="createform">

                        <div class="card border-0 shadow mb-4">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Job Details</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" placeholder="Job Title" id="title" name="title"
                                            class="form-control">
                                        {{-- @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror --}}
                                        <p></p>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select a Category</option>
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        {{-- @error('category')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror --}}
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Type<span class="req">*</span></label>
                                        <select name="Jobtype" id="Jobtype" class="form-control">
                                            <option value="">Select a Job Type</option>
                                            @if ($jobTypes->isNotEmpty())
                                                @foreach ($jobTypes as $jobType)
                                                    <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        {{-- @error('Jobtype')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror --}}
                                        <p></p>
                                    </div>

                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" min="1" placeholder="Vacancy" id="vacancy"
                                            name="vacancy" class="form-control">
                                        {{-- @error('vacancy')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror --}}
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Salary</label>
                                        <input type="text" placeholder="Salary" id="salary" name="salary"
                                            class="form-control">
                                        {{-- @error('salary')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror --}}
                                        <p></p>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location<span class="req">*</span></label>
                                        <input type="text" placeholder="location" id="location" name="location"
                                            class="form-control">
                                        {{-- @error('location')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror --}}
                                        <p></p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="textarea" name="description" id="description" cols="5" rows="5"
                                        placeholder="Description"></textarea>
                                    {{-- @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror --}}
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Benefits</label>
                                    <textarea class="textarea" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Responsibility</label>
                                    <textarea class="textarea" name="responsibility" id="responsibility" cols="5" rows="5"
                                        placeholder="Responsibility"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Qualifications</label>
                                    <textarea class="textarea" name="qualifications" id="qualifications" cols="5" rows="5"
                                        placeholder="Qualifications"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Expirence</label>
                                    <select name="experince" id="experince" class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6"></option>
                                        <option value=""></option>
                                        <option value=""></option>
                                        <option value=""></option>
                                        <option value=""></option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Keywords<span class="req">*</span></label>
                                    <input type="text" placeholder="keywords" id="keywords" name="keywords"
                                        class="form-control">
                                </div>

                                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Name<span class="req">*</span></label>
                                        <input type="text" placeholder="Company Name" id="company_name"
                                            name="company_name" class="form-control">
                                        {{-- @error('company_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror --}}
                                        <p></p>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Company Location</label>
                                        <input type="text" placeholder="Location" id="company_location"
                                            name="company_location" class="form-control">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Website</label>
                                    <input type="text" placeholder="Website" id="website" name="website"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Save Job</button>
                            </div>
                        </div>
                </div>


            </div>
        </div>
        </div>
        </form>
        </div>

    </section>
@endsection
@section('scripts')


<script type="text/javascript">
    $('#createform').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('account.Job') }}",
            type: 'POST',
            data: $('#createform').serializeArray(),
            dataType: 'json',
            success: function(response) {
                if (response.status === true) {
                    // Remove all validation errors
                    $('#title, #category, #Jobtype, #vacancy, #salary, #location, #description, #company_name').each(function() {
                        $(this).removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    });

                    // Redirect to job list page
                    window.location.href = "{{ route('account.jobList') }}";
                } else {
                    // Show validation errors
                    var errors = response.errors;

                    if (errors.title) {
                        $('#title').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.title);
                    } else {
                        $('#title').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if (errors.category) {
                        $('#category').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.category);
                    } else {
                        $('#category').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if (errors.Jobtype) {
                        $('#Jobtype').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.Jobtype);
                    } else {
                        $('#Jobtype').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if (errors.vacancy) {
                        $('#vacancy').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.vacancy);
                    } else {
                        $('#vacancy').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if (errors.salary) {
                        $('#salary').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.salary);
                    } else {
                        $('#salary').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if (errors.location) {
                        $('#location').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.location);
                    } else {
                        $('#location').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if (errors.description) {
                        $('#description').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.description);
                    } else {
                        $('#description').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if (errors.company_name) {
                        $('#company_name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.company_name);
                    } else {
                        $('#company_name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                }
            },

        });
    });
</script>
@endsection



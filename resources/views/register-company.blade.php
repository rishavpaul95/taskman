@extends('layouts.main')

@section('main-section')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Company Registration</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">



                <div class="container mb-2">
                    <form action="{{ url('/register-company') }}" method="POST">
                        @csrf
                        <div id="wizard">
                            <h3>
                                <div class="media">
                                    <div class="bd-wizard-step-icon"><i class="mdi mdi-account-outline"></i></div>
                                    <div class="media-body">
                                        <div class="bd-wizard-step-title">Company Details</div>
                                        <div class="bd-wizard-step-subtitle">Step 1</div>
                                    </div>
                                </div>
                            </h3>
                            <section>
                                <div class="form-group">
                                    <label for="companyName">Company Name</label>
                                    <input type="text" name="companyName" id="companyName" class="form-control"
                                        placeholder="Name" required>
                                    @error('companyName')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="companyEmail">Company Email</label>
                                    <input type="text" name="companyEmail" id="companyEmail" class="form-control"
                                        placeholder="Email" required>
                                    @error('companyEmail')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="companyWebsite">Company Website</label>
                                    <input type="text" name="companyWebsite" id="companyWebsite" class="form-control"
                                        placeholder="Website">
                                    @error('companyWebsite')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="companyAddress">Company Address</label>
                                    <input type="text" name="companyAddress" id="companyAddress" class="form-control"
                                        placeholder="Address" required>
                                    @error('companyAddress')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="category">Project</label>
                                    <input type="text" name="category" id="category" class="form-control"
                                        placeholder="Add a project tasks belong to. You can add/edit later" required>
                                    @error('category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </section>
                            <h3>
                                <div class="media">
                                    <div class="bd-wizard-step-icon"><i class="mdi mdi-bank"></i></div>
                                    <div class="media-body">
                                        <div class="bd-wizard-step-title">Admin Details</div>
                                        <div class="bd-wizard-step-subtitle">Step 2</div>
                                    </div>
                                </div>
                            </h3>
                            <section>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control" id="Name"
                                        placeholder="Name" required />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" class="form-control" id="Email"
                                        placeholder="Email" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                        required>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Confirm Password" required>
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </section>
                            <h3>
                                <div class="media">
                                    <div class="bd-wizard-step-icon"><i class="mdi mdi-account-check-outline"></i></div>
                                    <div class="media-body">
                                        <div class="bd-wizard-step-title">Review </div>
                                        <div class="bd-wizard-step-subtitle">Step 3</div>
                                    </div>
                                </div>
                            </h3>
                            <section>
                                <h4 class="text-center">Review your Details</h4>
                                <p id="enteredcompanyName"></p>
                                <p id="enteredcompanyEmail"></p>
                                <p id="enteredcompanyAddress"></p>
                                <p id="enteredcompanyWebsite"></p>
                                <p id="enteredcategory"></p>
                                <p id="enteredName"></p>
                                <p id="enteredEmail"></p>

                            </section>
                            <h3>
                                <div class="media">
                                    <div class="bd-wizard-step-icon"><i class="mdi mdi-emoticon-outline"></i></div>
                                    <div class="media-body">
                                        <div class="bd-wizard-step-title">Submit</div>
                                        <div class="bd-wizard-step-subtitle">Step 4</div>
                                    </div>
                                </div>
                            </h3>
                            <section>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="agreement" id="agreement"
                                        required>
                                    <label class="form-check-label" for="agreement">I hereby declare that I had read all
                                        the
                                        <a href="#">terms and conditions</a> and all the details provided my me in
                                        this
                                        form are true.</label>

                                    @error('agreement')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                            </section>
                        </div>
                    </form>
                </div>


                @push('scripts')
                    <script>
                        @if (session('success'))
                            toastr.success('{{ session('success') }}', 'Success');
                        @endif

                        @if (session('error'))
                            toastr.error('{{ session('error') }}', 'Error');
                        @endif

                        @if (session('status'))
                            toastr.info('{{ session('status') }}', 'Status');
                        @endif
                    </script>
                @endpush

            </div>
        </section>
    </div>


    @push('scripts')
        <script src="assets/js/jquery.steps.min.js"></script>
        <script src="assets/js/bd-wizard.js"></script>
        <script>
            window.addEventListener('DOMContentLoaded', (event) => {
                document.getElementById('companyName').addEventListener('change', function(e) {
                    document.getElementById('enteredcompanyName').innerText = 'Company Name: ' + e.target.value;
                });

                document.getElementById('companyEmail').addEventListener('change', function(e) {
                    document.getElementById('enteredcompanyEmail').innerText = 'Company Email: ' + e.target
                        .value;
                });

                document.getElementById('companyAddress').addEventListener('change', function(e) {
                    document.getElementById('enteredcompanyAddress').innerText = 'Company Address: ' + e.target
                        .value;
                });

                document.getElementById('companyWebsite').addEventListener('change', function(e) {
                    document.getElementById('enteredcompanyWebsite').innerText = 'Company Website: ' + e.target
                        .value;
                });

                document.getElementById('category').addEventListener('change', function(e) {
                    document.getElementById('enteredcategory').innerText = 'Project: ' + e.target.value;
                });

                document.getElementById('Name').addEventListener('change', function(e) {
                    document.getElementById('enteredName').innerText = 'Name: ' + e.target.value;
                });

                document.getElementById('Email').addEventListener('change', function(e) {
                    document.getElementById('enteredEmail').innerText = 'Email: ' + e.target.value;
                });
            });
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="assets/css/bd-wizard.css">
    @endpush
@endsection

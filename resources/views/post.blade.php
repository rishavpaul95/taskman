@extends('layouts.main')
@push('page-title')
    <title>Blog</title>
@endpush
@section('main-section')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-8 d-flex justify-content-between">
                        <h1 class="m-0">Blog</h1>
                        <a href="/blog" class="btn btn-danger">Back</a>
                    </div><!-- /.col -->

                </div><!-- /.row -->

            </div><!-- /.container-fluid -->

        </div>

        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">


                {!! $post !!}




            </div>
        </section>
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
@endsection

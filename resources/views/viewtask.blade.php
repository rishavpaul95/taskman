@extends('layouts.main')

@push('page-title')
    <title>Task: {{ $task->topic }}</title>
@endpush

@section('main-section')
    <div class="content-wrapper">
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid d-flex justify-content-end">
                <a class=" btn btn-danger btn-sm"
                    @if ($source == 'alltaskpage') href="{{ url('/alltask') }}"
                    @elseif ($source == 'assigntaskpage') href="{{ url('/assigntask') }}"
                    @else href="{{ url('/tasks') }}" @endif>
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </nav>


        <section>
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-8 card ">
                        <div class="text-center card-body">
                            <h4 class="card-title mb-3">Task Details</h4>
                            <p class="card-text"><strong>Due Date:</strong> {{ $task->date }}</p>
                            <p class="card-text"><strong>Assigned By:</strong> {{ $assignedBy->name }}</p>
                            <p class="card-text"><strong>Assigned To:</strong> {{ $assignedTo->name }}</p>
                            <p class="card-text"><strong>Project:</strong> {{ $categoryName }}</p>
                            <p class="card-text"><strong>Task:</strong> {{ $task->topic }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">



                        <div class="card-body text-center">
                            @if ($task->taskimage)
                                <img src="{{ asset('storage/' . $task->taskimage) }}" alt="Task Image"
                                    class="img-fluid mb-3">
                            @else
                                <p class="card-text mt-3">No Image</p>
                            @endif
                        </div>


                    </div>
                </div>

                @if (auth()->user()->id == $assignedBy->id)
                    {{-- person who assigned the task can comment !! no requirement for can !! --}}
                    @include('comments.postcomment')
                @elseif (auth()->user()->id == $assignedTo->id)
                    {{-- person who the task is assigned to can comment --}}
                    @can('comment_own_task')
                        @include('comments.postcomment')
                    @endcan
                @elseif(auth()->user()->id != $task->user_id && auth()->user()->id != $task->assigned_to)
                    {{-- person who is not involved in the task can comment --}}
                    @can('comment_other_task')
                        @include('comments.postcomment')
                    @endcan
                @endif
                <div class="row justify-content-center">
                    <div class="col-md-10">

                        <div class="card">
                            <h4 class="card-title m-3">Comments</h4>
                            <div class="card-body">

                                {{-- Display Existing Comments --}}
                                @foreach ($comments as $comment)
                                    <div class="card mb-3">
                                        <div class="card-body row">
                                            <div class="col">
                                                <h5 class="card-title"><strong>{{ $comment->user->name }}</strong></h5>
                                                <p class="card-text">{{ $comment->comment }}</p>
                                            </div>

                                            <div class="col-auto text-right">
                                                <small
                                                    class="text-muted d-block">{{ $comment->created_at->diffForHumans() }}</small>

                                                @if (auth()->user()->id == $comment->user_id || auth()->user()->hasRole('admin'))
                                                    {{-- own comment or admin --}}
                                                    @can('comment_own_delete')
                                                        <form action="{{ url('/comment/delete', ['id' => $comment->id]) }}"
                                                            method="GET">
                                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    @endcan
                                                @endif
                                            </div>
                                        </div>
                                @endforeach

                                @if (count($comments) === 0)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <p class="card-text">No comments yet. Be the first to comment!</p>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>


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
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header fw-bold h5">{{ __('Dashboard') }} - These are your books</div>

                    <div class="card-body">
                        @admin
                            Welcome admin!
                        @endadmin
                        @member
                            <div class="row">
                                @if ($books->isEmpty())
                                    <div class="col-md-12 mt-4 text-center">
                                        <div class="alert alert-primary" role="alert">
                                            You have not buy any book yet.
                                        </div>
                                    </div>
                                @else
                                    @foreach ($books as $book)
                                        <div class="col-md-3 mt-2">
                                            <div class="card" style="width: 18rem; height: 18rem;">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <h5 class="card-title">{{ $book->name }}</h5>
                                                        <h6>${{ $book->price }}</h3>
                                                    </div>
                                                    <h6 class="card-subtitle mb-2 text-muted">{{ $book->author }}</h6>
                                                    <p class="card-text">{{ fake()->text() }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endmember
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

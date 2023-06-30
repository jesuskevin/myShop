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
        </div>
        @admin
            <div class="row text-end pe-3">
                <div class="col-md-12">
                    <a href="{{ route('books.create') }}" class="btn btn-primary">New Book</a>
                </div>
            </div>
        @endadmin
        <div class="row">

            @if (empty($books))
                <div class="col-md-12 mt-4 text-center">
                    <div class="alert alert-primary" role="alert">
                        There are no books to show.
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
                                @admin
                                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-primary mx-2">Edit</a>
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-sm btn-danger mx-2" value="Delete">
                                    </form>
                                @endadmin
                                <a href="#" class="btn btn-sm btn-success mx-2">Buy</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="col-md-12 mt-2">
                {{ $books->onEachSide(5)->links() }}
            </div>
        </div>
    </div>
@endsection

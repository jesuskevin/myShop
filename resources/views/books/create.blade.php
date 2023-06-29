@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $error }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @endif
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
        <div class="col-md-6">
            <h4 class="fw-bold">Create New Book</h4>
            <form action="{{ route('books.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="bookName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="bookName" name="name" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="bookAuthor" class="form-label">Author</label>
                    <input type="text" class="form-control" id="bookAuthor" name="author" required>
                </div>
                <div class="mb-3">
                    <label for="bookPrice" class="form-label">Price</label>
                    <input type="number" class="form-control" id="bookPrice" min="0" step=".01" name="price"
                        required>
                </div>
                <button type="submit" class="btn btn-primary">Save book</button>
            </form>
        </div>
    </div>
@endsection

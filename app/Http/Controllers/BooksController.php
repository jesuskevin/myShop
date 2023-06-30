<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Services\BooksService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BooksController extends Controller
{

    protected $booksService;

    public function __construct(BooksService $booksService)
    {
        $this->booksService = $booksService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = $this->booksService->getAllPaginated(12);
        $data = compact('books');
        return view('books.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBookRequest $request)
    {
        $data = $request->validated();
        $this->booksService->store($data);
        return redirect()->back()->with('success', 'Book Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $book = $this->booksService->findByUuid($uuid);
        $data = compact('book');
        return view('books.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, $uuid)
    {
        $data = $request->validated();
        $this->booksService->update($data, $uuid);
        return redirect()->back()->with('success', 'Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $this->booksService->delete($uuid);
        return redirect()->back()->with('success', 'Book deleted successfully');
    }
}

@extends('adminlte::page')

@section('title', 'Pages')

@section('content_header')
    <h1>Collections</h1>
@stop

@section('content')
    <div class="mb-3">
        <a href="{{ route('pages.create') }}" class="btn btn-outline-dark">New</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Images</th>
                <th>Dates</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pages as $page)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $page->name }}</td>
                    <td>
                        <div class="d-flex">
                            @foreach($page->images()->get() as $image)
                                <img src="{{ asset(env('UPLOADS_IMAGE'). "/" . $image->name) }}" alt="" class="w-25 border">
                            @endforeach
                        </div>
                    </td>
                    <td>{{ $page->date }}</td>
                    <td>
                        <form action="{{ route('pages.destroy', $page) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        {{-- <a href="{{ route('pages.edit', $page) }}" class="btn btn-warning">Edit</a> --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No collections found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@stop

@section('css')

@stop

@section('js')

@stop

@extends('layouts.main')
@section('title', 'Category List')
@section('content')
    @php
        use App\Models\Category;
    @endphp
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h2 class="mb-3 mb-md-0">Categories</h2>
        </div>
        <div>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>
        </div>
    </div>

    <hr>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Image</th>
                <th>Parent Categories</th>
                <th>Content</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if (count($categories) > 0)
                {{-- @dd($categories) --}}
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            @if ($category->image)
                                <img src="{{ asset($category->image) }}" alt="Category Image" width="50">
                            @endif
                        </td>
                        <td>
                            @if ($category->parent_categories)
                                {{ Category::getNamesFromIds($category->parent_categories) }}
                            @else
                                NA
                            @endif
                        </td>
                        <td>{!! $category->content ? $category->content : '' !!}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">No data found!</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{ $categories->links() }}
@endsection

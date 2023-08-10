@extends('layouts.main')
@section('title', 'Category Add')
@section('content')
    <h1>Add Category</h1>


    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control"
                value="{{ old('title') ? old('title') : $category->title }}">
        </div>

        <div class="form-group mb-3">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control mb-1">
            <img src="{{ asset($category->image) }}" alt="Category Image" width="50">
        </div>

        <div class="form-group mb-3">
            <label for="parent_categories">Parent Categories</label>
            <select name="parent_categories[]" id="parent_categories" class="form-control" multiple="multiple">
                @foreach ($categories as $id => $title)
                    <option {{ in_array($id, explode(',', $category->parent_categories)) ? 'selected' : '' }}
                        value="{{ $id }}">{{ $title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="content">Content</label>
            <textarea class="ckeditor form-control" name="content" id="content"> {!! old('content') ? old('content') : $category->content !!}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <button type="reset" class="btn btn-info">Reset</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
    </form>
@stop

@section('js')
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $('#parent_categories').select2();
            $('.ckeditor').ckeditor();

        });
    </script>

@stop

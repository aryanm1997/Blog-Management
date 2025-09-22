@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Blog</h1>

    {{-- Show validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="blogForm" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Blog Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        {{-- Content --}}
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" id="content" rows="6" class="form-control" required></textarea>
        </div>

        {{-- Image --}}
        <div class="mb-3">
            <label for="image" class="form-label">Blog Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        {{-- Created Date --}}
        <div class="mb-3">
            <label for="created_at" class="form-label">Created Date</label>
            <input type="date" name="created_at" id="created_at" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save Blog</button>
        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
{{-- SweetAlert & jQuery --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#blogForm').on('submit', function(e) {
        e.preventDefault(); // prevent normal form submit

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('blogs.store') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    showConfirmButton: true,  // show the OK button
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('blogs.index') }}"; // redirect after clicking OK
                    }
                });

            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorText = '';
                $.each(errors, function(key, value) {
                    errorText += value + '\n';
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorText
                });
            }
        });
    });
});
</script>
@endsection

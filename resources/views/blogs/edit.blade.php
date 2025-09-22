@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Blog</h2>

    <form id="updateBlogForm" action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control"
                value="{{ old('title', $blog->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content', $blog->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label><br>
            @if($blog->image)
                <img src="{{ asset('storage/'.$blog->image) }}" alt="Blog Image" width="150" class="mb-2">
            @endif
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Blog</button>
        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#updateBlogForm').on('submit', function(e) {
        e.preventDefault(); // prevent default form submit

        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: response.message ?? 'Blog updated successfully!',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if(result.isConfirmed) {
                        window.location.href = "{{ route('blogs.index') }}"; // redirect after OK
                    }
                });
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                let errorMessage = '';

                if(errors) {
                    $.each(errors, function(key, value) {
                        errorMessage += value + '\n';
                    });
                } else {
                    errorMessage = xhr.responseJSON?.message ?? 'Something went wrong!';
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMessage
                });
            }
        });
    });
});
</script>
@endsection

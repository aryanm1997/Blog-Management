@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h1 {
        margin-bottom: 30px;
        text-align: center;
        color: #343a40;
    }

    .table thead {
        background: #6c63ff;
        color: #fff;
    }

    .table tbody tr {
        background: #fff;
        transition: all 0.2s ease-in-out;
    }

    .table tbody tr:hover {
        background: #f1f1f1;
    }

    .btn-custom {
        border-radius: 10px;
        padding: 6px 12px;
        font-size: 0.9rem;
    }

    .blog-view-checkbox {
        transform: scale(1.2);
        margin-left: 10px;
        cursor: pointer;
    }

    .btn-success {
        background: #28a745;
        border: none;
        transition: all 0.2s ease-in-out;
    }

    .btn-success:hover {
        background: #218838;
    }

    .btn-warning {
        background: #ffc107;
        border: none;
    }

    .btn-warning:hover {
        background: #e0a800;
        color: #fff;
    }

    .btn-danger {
        background: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    img {
        border-radius: 5px;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
        }
        .btn {
            margin-bottom: 5px;
        }
    }
</style>

<div class="container">
    <h1>Blogs</h1>
    <p><strong>Remaining Unseen Blogs:</strong> {{ $unseenBlogsCount }}</p>

    @can('create', App\Models\Blog::class)
        <div class="mb-3 text-end">
            <a href="{{ route('blogs.create') }}" class="btn btn-success btn-custom">Create Blog</a>
        </div>
    @endcan

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Image</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($blogs as $blog)
                    <tr id="blogRow{{ $blog->id }}">
                        <td>{{ $blog->title }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($blog->content, 80) }}</td>
                        <td>
                            @if($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}" width="50" height="50" alt="Blog Image">
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $blog->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-info btn-sm btn-custom">View</a>

                            @if(!auth()->user()->hasRole('Admin'))
                                <input type="checkbox" class="blog-view-checkbox"
                                    data-blog-id="{{ $blog->id }}"
                                    {{ auth()->user()->viewedBlogs->contains($blog->id) ? 'checked' : '' }}>
                                Mark as Viewed
                            @endif

                            @can('update', $blog)
                                <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-warning btn-sm btn-custom">Edit</a>
                            @endcan

                            @can('delete', $blog)
                                <button class="btn btn-danger btn-sm btn-custom deleteBlogBtn" data-id="{{ $blog->id }}">
                                    Delete
                                </button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No blogs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('.deleteBlogBtn').on('click', function(e) {
        e.preventDefault();
        let blogId = $(this).data('id');
        let url = "{{ route('blogs.destroy', ':id') }}".replace(':id', blogId);

        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message ?? 'Blog deleted successfully!',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#blogRow' + blogId).remove();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON?.message ?? 'Something went wrong!'
                        });
                    }
                });
            }
        });
    });
});
</script>

<script>
document.querySelectorAll('.blog-view-checkbox').forEach(function(checkbox){
    checkbox.addEventListener('change', function(){

        let blogId = this.dataset.blogId;

        fetch("{{ route('blogs.markAsViewed') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ blog_id: blogId })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                console.log('Blog marked as viewed');
                // Reload the page
                window.location.reload();
            } else {
                console.error('Error:', data.error);
            }
        })
        .catch(err => console.error(err));
    });
});
</script>
@endsection

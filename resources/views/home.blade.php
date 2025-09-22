@extends('layouts.app')

@section('content')
<style>
    /* === Common Styles === */
    .dashboard-card {
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        padding: 25px;
        margin-top: 40px;
        transition: all 0.3s ease;
    }
    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }
    .dashboard-title {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .btn-custom {
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 500;
        transition: 0.3s;
    }

    /* === Admin Style === */
    .admin-dashboard {
        background: linear-gradient(135deg, #6c63ff, #4e47d3);
        color: #fff;
    }
    .admin-dashboard .btn-custom {
        background: #fff;
        color: #6c63ff;
        border: none;
    }
    .admin-dashboard .btn-custom:hover {
        background: #f1f1f1;
        color: #4e47d3;
    }

    /* === User Style === */
    .user-dashboard {
        background: #f9f9f9;
        border: 1px solid #eee;
        color: #333;
    }
    .user-dashboard .btn-custom {
        background: #6c63ff;
        color: #fff;
        border: none;
    }
    .user-dashboard .btn-custom:hover {
        background: #4e47d3;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @role('Admin')
                <!-- Admin Dashboard -->
                <div class="dashboard-card admin-dashboard">
                    <h2 class="dashboard-title">Admin Dashboard</h2>
                    <p>Welcome back, <strong>{{ Auth::user()->name }}</strong>! 🎉</p>
                    
                    <div class="mt-3">
                        <a href="{{ route('blogs.index') }}" class="btn btn-custom">View Blogs</a>
                        <a href="{{ route('blogs.create') }}" class="btn btn-custom">Create Blog</a>
                    </div>
                </div>
            @endrole
            
            @if(!auth()->user()->hasRole('Admin'))
            <div class="dashboard-card user-dashboard">
                <h2 class="dashboard-title">User Dashboard</h2>
                <p>Hello <strong>{{ Auth::user()->name }}</strong>, here are the latest blogs for you 👇</p>

                <div class="mt-3">
                    <a href="{{ route('blogs.index') }}" class="btn btn-custom">View New Blogs</a>
                </div>
            </div>
            @endif



        </div>
    </div>
</div>
@endsection

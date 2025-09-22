<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ← THIS IS IMPORTANT


class BlogController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user && $user->hasRole('Admin')) {
            // Admin sees all blogs
            $blogs = Blog::latest()->get();
        } else {
            // Non-admin users: exclude blogs they have already viewed
            $blogs = Blog::whereDoesntHave('viewers', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->latest()->get();
        }

        $unseenBlogsCount = Blog::whereDoesntHave('viewedByUsers', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();

        return view('blogs.index', compact('blogs','unseenBlogsCount'));
    }



    public function create()
    {
        $this->authorize('create', Blog::class); // Only Admin
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Blog::class);

        // Validate request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'created_at' => 'required|date',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
            $validated['image'] = $imagePath;
        }

        // Add the logged-in user ID
        $validated['user_id'] = auth()->id();

        Blog::create($validated);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    public function show(Blog $blog)
    {
        // $user = auth()->user();

        // // Eager load viewers
        // $blog->load('viewers');

        // if (!$blog->viewers->contains($user->id)) {
        //     $blog->viewers()->attach($user->id);
        // }

        return view('blogs.show', compact('blog'));
    }

    public function markAsViewed(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
        ]);

            $user = auth()->user();
        $blogId = $request->blog_id;

        // Attach blog to user if not already attached
        $user->viewedBlogs()->syncWithoutDetaching([$blogId]);

        return response()->json(['success' => true]);
    }


    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog);
        return view('blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $this->authorize('update', $blog);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
            $validated['image'] = $imagePath;
        }

        $blog->update($validated);

        return redirect()->route('blogs.show', $blog->id)->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);

        if ($blog->image) {
            \Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }

}


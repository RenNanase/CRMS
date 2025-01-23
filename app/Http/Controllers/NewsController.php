<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

class NewsController extends Controller
{

    public function index()
    {
        $news = News::paginate(9); // This returns a LengthAwarePaginator
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $news = new News(); // Create new instance like in EventController
        $allNews = News::all(); // Get all news if needed for the view
        return view('admin.news.create', compact('news', 'allNews'));
    }



    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $news = new News();
        $news->title = $request->title;
        $news->content = $request->content;

        // Fix the image storage path - remove extra 'public'
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            // Store directly in 'news' folder without extra 'public'
            $path = $request->file('image')->storeAs('news', $filename, 'public');
            $news->image = $path; // This will store just 'news/filename.jpg'
        }
        $news->content = Purifier::clean($request->content);
        $news->user_id = auth()->id();
        $news->save();

        return redirect()->route('news.index')
        ->with('success', 'News created successfully.');
    }

    public function edit($id)
    {
        $news = News::find($id); // Use find() like in EventController
        $allNews = News::all(); // Get all news if needed for the view
        return view('admin.news.edit', compact('news', 'allNews'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image')->store('news', 'public');
            $validated['image'] = $imagePath;
        }

        $news->update($validated);

        return redirect()->route('news.index')->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        // Add delete method like in EventController
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        $news->delete();
        return redirect()->route('news.index')->with('success', 'News deleted successfully.');
    }


    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return redirect('/')->with('error', 'Unauthorized access. Admin only.');
    }
}

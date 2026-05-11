<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type', 'all'); // all, blogs, categories

        // If exact match found, redirect directly
        $exactBlog = Blog::where('slug', $query)->orWhere('title', $query)->first();
        if ($exactBlog) {
            return redirect()->route('blog-details', ['slug' => Str::slug($exactBlog->slug)]);
        }

        // For AJAX requests, return suggestions
        if ($request->ajax()) {
            $suggestions = [];
            
            if ($type === 'all' || $type === 'blogs') {
                $blogs = Blog::where('title', 'like', "%{$query}%")
                    ->orWhere('slug', 'like', "%{$query}%")
                    ->take(5)
                    ->get()
                    ->map(function($blog) {
                        return [
                            'type' => 'blog',
                            'name' => $blog->title,
                            'slug' => $blog->slug,
                            'image' => $blog->category_image ? asset($blog->category_image) : null,
                            'category' => $blog->category->title ?? 'General',
                            'url' => route('blog-details', ['slug' => Str::slug($blog->slug)])
                        ];
                    });
                $suggestions = array_merge($suggestions, $blogs->toArray());
            }

            if ($type === 'all' || $type === 'categories') {
                $categories = Categories::where('title', 'like', "%{$query}%")
                    ->orWhere('slug', 'like', "%{$query}%")
                    ->take(5)
                    ->get()
                    ->map(function($category) {
                        return [
                            'type' => 'category',
                            'name' => $category->title,
                            'slug' => $category->slug,
                            'url' => route('category.details', ['slug' => $category->slug])
                        ];
                    });
                $suggestions = array_merge($suggestions, $categories->toArray());
            }

            return response()->json(['suggestions' => $suggestions]);
        }

        // Redirect to search results page with query
        return redirect()->route('search_results', [
            'query' => $query,
            'type' => $type
        ]);
    }

    public function searchResults(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type', 'all');
        
        $results = [];
        $totalCount = 0;

        // Search in blogs
        if ($type === 'all' || $type === 'blogs') {
            $blogs = Blog::where('title', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%")
                ->orWhereHas('category', function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%");
                })
                ->paginate(10, ['*'], 'blogs_page')
                ->appends(['query' => $query, 'type' => $type]);
            $results['blogs'] = $blogs;
            $totalCount += $blogs->total();
        }

        // Search in categories
        if ($type === 'all' || $type === 'categories') {
            $categories = Categories::where('title', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%")
                ->paginate(10, ['*'], 'categories_page')
                ->appends(['query' => $query, 'type' => $type]);
            $results['categories'] = $categories;
            $totalCount += $categories->total();
        }

        // Check for exact matches and redirect
        if ($totalCount === 1) {
            foreach (['blogs', 'categories'] as $searchType) {
                if (isset($results[$searchType]) && $results[$searchType]->count() === 1) {
                    $item = $results[$searchType]->first();
                    switch ($searchType) {
                        case 'blogs':
                            return redirect()->route('blog-details', ['slug' => Str::slug($item->slug)]);
                        case 'categories':
                            return redirect()->route('category.details', ['slug' => Str::slug($item->slug)]);
                    }
                }
            }
        }

        return view('front-end.search_results', [
            'query' => $query,
            'type' => $type,
            'results' => $results,
            'totalCount' => $totalCount
        ]);
    }
}
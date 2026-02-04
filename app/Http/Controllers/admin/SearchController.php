<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stores;
use App\Models\Blog;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type', 'all'); // all, stores, blogs, categories

        // Check for exact matches
        $exactStore = Stores::where('slug', $query)->orWhere('name', $query)->first();
        if ($exactStore) {
            return redirect()->route('admin.store.store_details', ['slug' => Str::slug($exactStore->slug)]);
        }

        $exactBlog = Blog::where('slug', $query)->orWhere('title', $query)->first();
        if ($exactBlog) {
            return redirect()->route('admin.blog.edit', ['id' => $exactBlog->id]);
        }

        $exactCategory = Categories::where('slug', $query)->orWhere('title', $query)->first();
        if ($exactCategory) {
            return redirect()->route('admin.category.edit', ['id' => $exactCategory->id]);
        }

        // For AJAX requests, return suggestions
        if ($request->ajax()) {
            $suggestions = [];
            
            if ($type === 'all' || $type === 'stores') {
                $stores = Stores::where('name', 'like', "%{$query}%")
                    ->orWhere('slug', 'like', "%{$query}%")
                    ->take(5)
                    ->get()
                    ->map(function($store) {
                        return [
                            'type' => 'store',
                            'name' => $store->name,
                            'slug' => $store->slug,
                            'id' => $store->id,
                            'image' => $store->store_image ? asset('uploads/stores/' . $store->store_image) : null,
                            'category' => $store->category,
                            'url' => route('admin.store.store_details', ['slug' => Str::slug($store->slug)])
                        ];
                    });
                $suggestions = array_merge($suggestions, $stores->toArray());
            }

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
                            'id' => $blog->id,
                            'image' => $blog->category_image ? asset($blog->category_image) : null,
                            'category' => $blog->category->title ?? 'General',
                            'url' => route('admin.blog.edit', ['id' => $blog->id])
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
                            'id' => $category->id,
                            'url' => route('admin.category.edit', ['id' => $category->id])
                        ];
                    });
                $suggestions = array_merge($suggestions, $categories->toArray());
            }

            return response()->json(['suggestions' => $suggestions]);
        }

        // Redirect to search results page
        return redirect()->route('admin.search_results', [
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

        // Search in stores
        if ($type === 'all' || $type === 'stores') {
            $stores = Stores::where('name', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%")
                ->with('language', 'categories')
                ->orderBy('created_at', 'desc')
                ->paginate(15, ['*'], 'stores_page')
                ->appends(['query' => $query, 'type' => $type]);
            $results['stores'] = $stores;
            $totalCount += $stores->total();
        }

        // Search in blogs
        if ($type === 'all' || $type === 'blogs') {
            $blogs = Blog::where('title', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%")
                ->orWhereHas('category', function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%");
                })
                ->with('language', 'category')
                ->orderBy('created_at', 'desc')
                ->paginate(15, ['*'], 'blogs_page')
                ->appends(['query' => $query, 'type' => $type]);
            $results['blogs'] = $blogs;
            $totalCount += $blogs->total();
        }

        // Search in categories
        if ($type === 'all' || $type === 'categories') {
            $categories = Categories::where('title', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%")
                ->orderBy('created_at', 'desc')
                ->paginate(15, ['*'], 'categories_page')
                ->appends(['query' => $query, 'type' => $type]);
            $results['categories'] = $categories;
            $totalCount += $categories->total();
        }

        // Check for exact matches and redirect
        if ($totalCount === 1) {
            foreach (['stores', 'blogs', 'categories'] as $searchType) {
                if (isset($results[$searchType]) && $results[$searchType]->count() === 1) {
                    $item = $results[$searchType]->first();
                    switch ($searchType) {
                        case 'stores':
                            return redirect()->route('admin.store.store_details', ['slug' => Str::slug($item->slug)]);
                        case 'blogs':
                            return redirect()->route('admin.blog.edit', ['id' => $item->id]);
                        case 'categories':
                            return redirect()->route('admin.category.edit', ['id' => $item->id]);
                    }
                }
            }
        }

        return view('admin.search.results', [
            'query' => $query,
            'type' => $type,
            'results' => $results,
            'totalCount' => $totalCount
        ]);
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type', 'all');
        
        $suggestions = [];

        if ($type === 'all' || $type === 'stores') {
            $stores = Stores::where('name', 'like', $query . '%')
                ->orWhere('slug', 'like', $query . '%')
                ->take(5)
                ->pluck('name')
                ->toArray();
            $suggestions = array_merge($suggestions, array_map(function($item) {
                return ['type' => 'store', 'name' => $item];
            }, $stores));
        }

        if ($type === 'all' || $type === 'blogs') {
            $blogs = Blog::where('title', 'like', $query . '%')
                ->orWhere('slug', 'like', $query . '%')
                ->take(5)
                ->pluck('title')
                ->toArray();
            $suggestions = array_merge($suggestions, array_map(function($item) {
                return ['type' => 'blog', 'name' => $item];
            }, $blogs));
        }

        if ($type === 'all' || $type === 'categories') {
            $categories = Categories::where('title', 'like', $query . '%')
                ->orWhere('slug', 'like', $query . '%')
                ->take(5)
                ->pluck('title')
                ->toArray();
            $suggestions = array_merge($suggestions, array_map(function($item) {
                return ['type' => 'category', 'name' => $item];
            }, $categories));
        }

        return response()->json(['relatedSearches' => $suggestions]);
    }

    // Quick search for admin dashboard
    public function quickSearch(Request $request)
    {
        $query = $request->input('query');
        
        $results = [
            'stores' => Stores::where('name', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%")
                ->take(3)
                ->get(),
            'blogs' => Blog::where('title', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%")
                ->take(3)
                ->get(),
            'categories' => Categories::where('title', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%")
                ->take(3)
                ->get(),
        ];

        return view('admin.search.quick-results', compact('results', 'query'));
    }
}
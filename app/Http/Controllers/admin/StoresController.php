<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use App\Models\Categories;
use App\Models\Networks;
use App\Models\Coupons;
use App\Models\DeleteStore;
use App\Models\Language;
use App\Models\Stores;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoresController extends Controller
{

    public function checkSlug(Request $request)
    {
        $slug = $request->slug;
        $exists = Stores::where('slug', $slug)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }
    public function StoreDetails($name)
    {
        $slug = Str::slug($name);
        $title = ucwords(str_replace('-', ' ', $slug));
        $store = Stores::with('networks', 'language', 'categories')->where('slug', $title)->first();
        if (!$store) {
            return redirect('404');
        }
        $coupons = Coupons::where('store_id', $store->id)->orderByRaw('CAST(`order` AS SIGNED) ASC')->get();
        $stores = Stores::orderByDesc('created_at')->get();
        $langs = Language::all();
        $relatedStores = Stores::where('category_id', $store->category->id)->where('id', '!=', $store->id)->get();

        return view('admin.stores.store-detail', compact('store', 'coupons', 'relatedStores', 'stores', 'langs'));
    }

    public function store()
    {
        $stores = Stores::with('language')->select('id', 'name', 'slug', 'status', 'created_at', 'updated_at', 'store_image', 'network_id', 'category_id')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('admin.stores.index', compact('stores',));
    }

    public function create_store()
    {
        $categories = Categories::all();
        $networks = Networks::all();
        $langs = Language::get();

        return view('admin.stores.create', compact('categories', 'networks','langs'));
    }
    public function store_store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'language_id' => 'required|integer',
            'slug' => 'nullable|string|max:255|unique:stores,slug',
            'top_store' => 'nullable|integer',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'affiliate_url' => 'required',
            'destination_url' => 'required|url',
            'category_id' => 'required|integer',
            'title' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'authentication' => 'nullable|string',
            'network_id' => 'required|integer',
            'store_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'content' => 'nullable',
        ]);
        $slug = $validated['slug'] ?? Str::slug($validated['name']);
        $storeImage = 'No Store Image';
        if ($request->hasFile('store_image')) {
            $image = $request->file('store_image');
            $storeImage = $slug . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('uploads/stores/' . $storeImage);
            $image->move(public_path('uploads/stores/'), $storeImage);
            $optimizer = OptimizerChainFactory::create();
            $optimizer->optimize($path);
        }

        // Create store
        $stores = Stores::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'language_id' => $validated['language_id'],
            'top_store' => $validated['top_store'] ?? null,
            'description' => $validated['description'] ?? null,
            'about' => $validated['about'] ?? null,
            'affiliate_url' => $validated['affiliate_url'] ?? null,
            'destination_url' => $validated['destination_url'] ?? null,
            'category_id' => $validated['category_id'],
            'title' => $validated['title'] ?? null,
            'meta_keyword' => $validated['meta_keyword'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'status' => $request->input('status', 1),
            'authentication' => $validated['authentication'] ?? 'No Auth',
            'network_id' => $validated['network_id'],
            'store_image' => $storeImage,
            'content' => $validated['content'] ?? null,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.store.store_details',['slug' => Str::slug($stores->slug)] )->with('success', 'Store Created Successfully');
    }
    public function edit_store($id)
    {
        $stores = Stores::find($id);
        $categories = Categories::all();
        $networks = Networks::all();
        $langs = Language::get();
        return view('admin.stores.edit', compact('stores', 'categories', 'networks','langs'));
    }
    public function update_store(Request $request, $id)
    {
        $store = Stores::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('stores')->ignore($store->id)],
            'language_id' => 'nullable|integer',
            'top_store' => 'nullable|integer',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'affiliate_url' => 'nullable|url',
            'destination_url' => 'nullable|url',
            'category_id' => 'nullable|integer',
            'title' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'nullable|in:enable,disable',
            'authentication' => 'nullable|string',
            'network_id' => 'nullable|integer',
            'store_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'content' => 'nullable'
        ]);
        $slug = $request->slug;
        $storeImage = $store->store_image;
        if ($request->hasFile('store_image')) {
            $file = $request->file('store_image');
            $extension = $file->getClientOriginalExtension();
            $newImageName = $slug . "." . $extension;
            $newImagePath = public_path('uploads/stores/' . $newImageName);

            if ($storeImage && $storeImage !== $newImageName) {
                $oldPath = public_path('uploads/stores/' . $storeImage);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $file->move(public_path('uploads/stores/'), $newImageName);
            if (file_exists($newImagePath)) {
                $optimizer = OptimizerChainFactory::create();
                $optimizer->optimize($newImagePath);
            }

            $storeImage = $newImageName;
        }

        $store->update([
            'name' => $request->name,
            'slug' => $slug, // <-- USE CUSTOM INPUT EXACTLY
            'language_id' => $request->language_id ?? $store->language_id,
            'top_store' => $request->top_store,
            'description' => $request->description,
            'about' => $request->about ?? $store->about,
            'affiliate_url' => $request->affiliate_url,
            'destination_url' => $request->destination_url,
            'category_id' => $request->category_id ?? $store->category_id,
            'title' => $request->title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
            'authentication' => $request->authentication ?? 'No Auth',
            'network_id' => $request->network_id ?? $store->network_id,
            'store_image' => $storeImage,
            'content' => $request->content ?? $store->content,
            'updated_id' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.store.store_details', ['slug' => Str::slug($store->slug)])
            ->with('success', 'Store Updated Successfully');
    }
    public function delete_store($id)
    {
        // Find the store by ID
        $store = Stores::find($id);

        if ($store) {
            // Log the store deletion attempt in the delete_store table
            DeleteStore::create([
                'store_id' => $store->id,
                'store_name' => $store->name,
                'deleted_by' => Auth::id(),

            ]);

            // Delete associated coupons with the same store name
            Coupons::where('store_id', $store->id)->delete();

            // Delete the store (soft delete if the SoftDeletes trait is used)
            $store->delete();

            return redirect()->route('admin.store.index')->with('success', 'Store and associated coupons marked for deletion.');
        }

        return redirect()->back()->with('error', 'Store not found.');
    }
    public function deleteSelected(Request $request)
    {
        // Get the selected store IDs from the request
        $storeIds = $request->input('selected_stores');

        // Check if any store IDs were selected
        if ($storeIds) {
            // Fetch the stores to be deleted
            $stores = Stores::whereIn('id', $storeIds)->get();

            // Loop through each store and log the deletion
            foreach ($stores as $store) {
                DeleteStore::create([
                    'store_id' => $store->id,
                    'store_name' => $store->name,
                    'deleted_by' => Auth::id(),
                ]);
            }

            // Delete the selected stores
            Stores::whereIn('id', $storeIds)->delete();

            return redirect()->back()->with('success', 'Selected stores deleted successfully');
        } else {
            return redirect()->back()->with('error', 'No stores selected for deletion');
        }
    }
}

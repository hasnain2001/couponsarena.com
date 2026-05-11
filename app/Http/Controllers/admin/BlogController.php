<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Stores;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Illuminate\Support\Str;
use App\Models\Language;
use App\Models\Categories;

class BlogController extends Controller
{

    public function checkSlug(Request $request)
    {
        $slug = $request->slug;
        $exists =   Blog::where('slug', $slug)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }
    public function index()
    {
        $blogs = Blog::with('language', 'category')->orderBy('created_at','desc')->get();
        return view('admin.blog.index', compact('blogs'));
    }
    public function create()
    {
     $langs = Language::all();
     $categories = Categories::all();
     $stores = Stores::orderByDesc('created_at')->get();
      return view('admin.blog.create', compact('langs', 'categories','stores'));
    }
    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string|max:255|unique:blogs,slug',
            'content' => 'required|string',
            'category_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
            'top' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'language_id' =>'required|integer',
            'store_id' =>'required|integer',
            'status' => 'nullable|string|in:enable,disabled',
        ]);

        // Handle file upload for category_image
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = 'uploads/blog/'.$imageName;
            $image->move(public_path('uploads/blog'), $imageName);

            if (file_exists(public_path($imagePath))) {

                // $image = ImageManager::imagick()->read(public_path($imagePath))
                // $image->resize(300, 200);
                // $image->resize(null, 200, function ($constraint) {
                //     $constraint->aspectRatio();
                // });
                $optimizer = OptimizerChainFactory::create();
                $optimizer->optimize(public_path($imagePath));
                // $image->save(public_path($imagePath));
            }
        } else {
            $imagePath = null;
        }


        $blog = new Blog();
        $blog->title = $request->input('title');
        $blog->language_id = $request->input('language_id');
        $blog->slug = $request->input('slug');
        $blog->category_image = $imagePath;
        $blog->meta_title = $request->input('meta_title');
        $blog->meta_description = $request->input('meta_description');
        $blog->meta_keyword = $request->input('meta_keyword');
        $blog->top = $request->input('top');
        $blog->category_id = $request->input('category_id');
        $blog->store_id = $request->input('store_id');
        $blog->status = $request->input('status');
        $content = $request->input('content');

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();


        $images = $dom->getElementsByTagName('img');

        /** @var \DOMElement $img */
        foreach ($images as $img) {
            $image_64 = $img->getAttribute('src');
            if (strpos($image_64, 'data:image/') === 0) {
                $image_parts = explode(';', $image_64);
                $image_type_aux = explode('/', $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode(explode(',', $image_parts[1])[1]);
                $imageName = Str::random(10) . '.' . $image_type;
                $path = public_path('uploads/blog/') . $imageName;
                file_put_contents($path, $image_base64);

                // Update the src attribute in the image tag
                $img->setAttribute('src', asset('uploads/blog/' . $imageName));
            }
        }

        // Save the updated content back to the blog
        $blog->content = $dom->saveHTML();
        $blog->save();

        // return redirect()->back()->withInput()->with('success', 'Blog created successfully.');
        return redirect()->route('admin.blog.show', ['id' => $blog->id])->with('success', 'Blog created successfully.');
    }
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.show', compact('blog'));
    }
    public function edit($id)
    {
        $blog = Blog::with('language', 'category')->findOrFail($id);
        $langs = Language::orderByDesc('created_at')->get();
        $categories = Categories::orderByDesc('created_at')->get();
        $stores = Stores::orderByDesc('created_at')->get();
        return view('admin.blog.edit', compact('blog', 'langs', 'categories','stores'));
    }
    public function update(Request $request, $id)
    {
        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $id,
            'language_id' =>'nullable|integer',
            'content' => 'required|string',
            'category_image' => 'image|mimes:jpeg,png,jpg,gif',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
            'top' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'store_id' =>'nullable|integer',
            'status' => 'nullable|string|in:enable,disabled',
        ]);

        // Find the blog by ID
        $blog = Blog::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('category_image')) {
            // Delete the old image if it exists
            if ($blog->category_image && file_exists(public_path($blog->category_image))) {
                unlink(public_path($blog->category_image));
            }

            // Save the new image
            $image = $request->file('category_image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = 'uploads/blog/'.$imageName;
            $image->move(public_path('uploads/blog'), $imageName);

            // Ensure that the file has been saved before trying to read it
            if (file_exists(public_path($imagePath))) {
                // Use Imagick to create a new image instance
                // $imageInstance = ImageManager::imagick()->read(public_path($imagePath));

                // // Resize the image to 300x200 pixels
                // $imageInstance->resize(300, 200);

                // // Optionally, maintain the aspect ratio while resizing the height to 200 pixels
                // $imageInstance->resize(null, 200, function ($constraint) {
                //     $constraint->aspectRatio();
                // });

                // Optimize the image (optional)
                $optimizer = OptimizerChainFactory::create();
                $optimizer->optimize(public_path($imagePath));

                // // Save the resized and optimized image
                // $imageInstance->save(public_path($imagePath));

                // Update the image path in the blog record
                $blog->category_image = $imagePath;
            }
        }

        // Update other blog fields
        $blog->title = $request->input('title');
        $blog->language_id = $request->input('language_id',$blog->language_id);
        $blog->slug = $request->input('slug');
        $blog->meta_title = $request->input('meta_title');
        $blog->meta_description = $request->input('meta_description');
        $blog->meta_keyword = $request->input('meta_keyword');
        $blog->top = $request->input('top');
        $blog->category_id = $request->input('category_id', $blog->category_id);
        $blog->store_id = $request->input('store_id', $blog->store_id);
        $blog->status = $request->input('status', $blog->status);



        // Process content from CKEditor
        $content = $request->input('content');

        // Load HTML content into DOMDocument
        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        // Update the content in the blog record
        $blog->content = $dom->saveHTML();

        // Save the updated blog
        $blog->save();

        // Redirect back with a success message
        return redirect()->route('admin.blog.show', ['id' => $id])->with('success', 'Blog updated successfully.');
    }
    public function destroy($id)
    {

        $blog = Blog::findOrFail($id);

        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog deleted successfully.');
    }
    public function deleteSelected(Request $request)
    {
        $selectedIds = $request->input('selected_blogs');

        if ($selectedIds) {

            Blog::whereIn('id', $selectedIds)->delete();

            return redirect()->back()->with('success', 'Selected blog entries deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'No blog entries selected for deletion.');
        }
    }
    public function bulkDelete(Request $request)
    {
        $selectedBlogs = $request->input('selected_blogs');

        if ($selectedBlogs) {
            Blog::whereIn('id', $selectedBlogs)->delete();
            return redirect()->back()->with('success', 'Selected blog entries deleted successfully.');
        }

            return redirect()->back()->with('error', 'No blog entries selected for deletion.');
    }

}

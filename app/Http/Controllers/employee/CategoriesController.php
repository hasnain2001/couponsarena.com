<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class CategoriesController extends Controller
{
    public function index() {
        $categories = Categories::select('id', 'title', 'category_image', 'status', 'created_at','updated_at')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('employee.categories.index', compact('categories'));
    }


    public function create() {
        return view('employee.categories.create');
    }

    public function store(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
         'slug' => 'required|string|max:255|unique:categories,slug',
            'meta_tag' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            // 'status' => 'required|boolean',
            'authentication' => 'nullable|string|max:255',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


    // $slug = Str::slug($request->slug ?? $categories->title);
        if ($request->hasFile('category_image')) {
            $file = $request->file('category_image');
            $CategoryImage = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $filePath = './uploads/categories/' . $CategoryImage;
            $file->move('./uploads/categories', $CategoryImage);

            if (file_exists($filePath)) {
                // Use Intervention Image to create a new image instance

                // $image = ImageManager::imagick()->read($filePath);

                // // Resize the image to 300x200 pixels
                // $image->resize(300, 200, function ($constraint) {
                //     $constraint->aspectRatio();
                // });

                // // Save the resized image
                // $image->save($filePath);

                // Optimize the image
                $optimizer = OptimizerChainFactory::create();
                $optimizer->optimize($filePath);
            }
        }

        Categories::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'meta_tag' => $request->meta_tag,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
            'authentication' => $request->authentication ?? 'No Auth',
            'category_image' => $CategoryImage ?? 'No Category Image',
        ]);

        return redirect()->back()->with('success', 'Category Created Successfully');
    }


    public function edit_category($id) {
        $category = Categories::find($id);

        return view('employee.categories.edit', compact('category'));
    }



    public function update_category(Request $request, $id) {
        $categories = Categories::find($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => ['required','string','max:255',Rule::unique('categories')->ignore($categories->id),],
            'meta_tag' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            // 'status' => 'required|boolean',
            'authentication' => 'nullable|string|max:255',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
//  // Auto-generate slug only if no slug is provided in the request
// $slug = $request->has('slug') && !empty($request->slug)
// ? Str::slug($request->slug)
// : $categories->slug;


        $CategoryImage = $categories->category_image;
        if (request()->File('category_image'))
        {
            $file = $request->file('category_image');
            $CategoryImage = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $filePath = './uploads/categories/' . $CategoryImage;
            $file->move('./uploads/categories', $CategoryImage);

            if (file_exists($filePath)) {
                // Use Intervention Image to create a new image instance

                $image = ImageManager::imagick()->read($filePath);

                // Resize the image to 300x200 pixels
                $image->resize(300, 200, function ($constraint) {
                    $constraint->aspectRatio();
                });

                // Save the resized image
                $image->save($filePath);

                // Optimize the image
                $optimizer = OptimizerChainFactory::create();
                $optimizer->optimize($filePath);
            }
        }

        $categories->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'meta_tag' => $request->meta_tag,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
            'authentication' => isset($request->authentication) ? $request->authentication : "No Auth",
            'category_image' => isset($CategoryImage) ? $CategoryImage : "No Category Image",
        ]);

        return redirect()->back()->with('success', 'Category Updated Successfully');
    }

    public function delete_category($id) {
        Categories::find($id)->delete();
        return redirect()->back()->with('success', 'Category Deleted Successfully');
    }


public function deleteSelected(Request $request)
{
    $categoryIds = $request->input('selected_categories');

    if ($categoryIds) {
        Categories::whereIn('id', $categoryIds)->delete();
        return redirect()->back()->with('success', 'Selected categories deleted successfully');
    } else {
        return redirect()->back()->with('error', 'No categories selected for deletion');
    }
}



}

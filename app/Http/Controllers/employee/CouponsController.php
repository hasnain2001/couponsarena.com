<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupons;
use App\Models\Language;
use App\Models\Stores;
use Livewire\Attributes\Validate;
use Illuminate\Support\Str;

class CouponsController extends Controller
{

    public function coupon(Request $request) {


        if ($request->ajax()) {
            $coupons = Coupons::get();
            return response()->json($coupons);
        }

        // Get distinct store names only
        $couponstore = Coupons::select('store')->distinct()->get();
        $selectedCoupon = $request->input('store');

        // Initialize query
        $productsQuery = Coupons::query();

        // Filter by selected store if any
        if ($selectedCoupon) {
            $productsQuery->where('store', $selectedCoupon);
        }


        $coupons = $productsQuery
        ->orderBy('store')
        ->orderByRaw('CAST(`order` AS SIGNED) ASC')
        ->limit(1000)
        ->get();
        return view('employee.coupons.index', compact('coupons','couponstore','selectedCoupon'));

    }

public function openCoupon($couponId)
{
    $coupon = Coupons::find($couponId);
    if ($coupon) {
        // Increment click count
        $coupon->clicks++;
        $coupon->save();

        // Assuming you have a route named 'store.detail' that shows the store detail page
        return redirect()->route('store.detail', ['id' => $coupon->store_id]);
    }
    // Handle case where coupon is not found
    return redirect()->back()->with('error', 'Coupon not found.');
}

public function updateClicks(Request $request)
{
    $couponId = $request->input('coupon_id');
    $coupon = Coupons::find($couponId);
    if ($coupon) {
        $coupon->clicks++;
        $coupon->save();
        return redirect()->back()->with('success', 'Coupon Click added');
    }
    return response()->json(['success' => false, 'message' => 'Coupon not found.']);
}


public function update(Request $request)
{
    try {
        $orderData = $request->order;

        // Loop through the order data and update the order column for each coupon
        foreach ($orderData as $order) {
            $coupon = Coupons::find($order['id']);
            $coupon->order = $order['position'];
            $coupon->save();
        }

        return response()->json(['status' => 'success', 'message' => 'Update Successfully.']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
    public function create_coupon() {
        $stores = Stores::all();
        $langs = Language::all();
        return view('employee.coupons.create', compact('stores','langs'));
    }
    public function create_coupon_code() {
        $stores = Stores::all();
        $langs = Language::all();
        return view('employee.coupons.createcode', compact('stores','langs'));
    }

    public function store_coupon(Request $request) {
        // Define validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'language_id' =>'nullable|integer',
            'description' => 'nullable|string|max:1000',
            'code' => 'nullable|string|max:100',
            'destination_url' => 'nullable|url',
            'ending_date' => 'nullable|date|after_or_equal:today',
            // 'status' => 'required|in:active,inactive',
            'authentication' => 'nullable|array',
            'authentication.*' => 'string',
            'store_id' => 'nullable|integer',
        'top_coupons' => 'nullable|integer|min:0',


        ]);

        // Create coupon using validated data
        Coupons::create([
            'name' => $request->name,
            'language_id' => $request->input('language_id'),
            'description' => $request->description,
            'code' => $request->code,
            'destination_url' => $request->destination_url,
            'ending_date' => $request->ending_date,
            'status' => $request->status,
            'authentication' => isset($request->authentication) ? json_encode($request->authentication) : "No Auth",
            'store_id' => $request->store_id,
            'top_coupons' => $request->top_coupons,
        ]);

       return redirect()->back()->withInput()->with(['success' => 'Coupon created Successfully!', 'show_modal' => true]);
    }


    public function edit_coupon($id) {
        $coupons = Coupons::find($id);
        $stores = Stores::all();
        return view('employee.coupons.edit', compact('coupons', 'stores'));
    }

    public function update_coupon(Request $request, $id) {
        // Find the coupon by its ID
        $coupons = Coupons::find($id);

        // Define validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'language_id' => 'nullable|integer', // Allow null, so it doesn't throw an error if not provided
            'description' => 'nullable|string|max:1000',
            'code' => 'nullable|string|max:100',
            'destination_url' => 'nullable',
            'ending_date' => 'nullable|date|after_or_equal:today',
            'authentication' => 'nullable|array',
            'authentication.*' => 'string',
            'store' => 'nullable|string|max:255', // Allow null, so it doesn't throw an error if not provided
            'top_coupons' => 'nullable|integer|min:0',
        ]);

        // Update the coupon details, retain old values if not provided
        $coupons->update([
            'name' => $request->name,
            'language_id' => $request->input('language_id', $coupons->language_id), // Retain previous value if not provided
            'description' => $request->description,
            'code' => $request->code,
            'destination_url' => $request->destination_url,
            'ending_date' => $request->ending_date,
            'status' => $request->status,
            'authentication' => isset($request->authentication) ? json_encode($request->authentication) : "No Auth",
            'store_id' => $request->input('store_id', $coupons->store_id), // Retain previous value if not provided
            'top_coupons' => $request->top_coupons,
        ]);

        $store = Stores::where('id', $coupons->store_id)->first();
        if ($store) {
            $url = route('employee.store_details', ['slug' => Str::slug($store->slug)]);
            return redirect($url)->with('success', 'Coupon Updated Successfully');
        }

        return redirect()->back()->with('error', 'Store not found.');

    }


    public function delete_coupon($id) {
        Coupons::find($id)->delete();
        return redirect()->back()->with('success', 'Coupon Deleted Successfully');
    }

public function deleteSelected(Request $request)
{
    $couponIds = $request->input('selected_coupons');

    if ($couponIds) {
        Coupons::whereIn('id', $couponIds)->delete();
        return redirect()->back()->with('success', 'Selected coupons deleted successfully');
    } else {
        return redirect()->back()->with('error', 'No coupons selected for deletion');
    }
}


}

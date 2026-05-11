<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Coupons;
use App\Models\Language;
use App\Models\Stores;
use Livewire\Attributes\Validate;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class CouponsController extends Controller
{

    public function openCoupon($couponId)
    {
        $coupon = Coupons::find($couponId);
        if ($coupon) {
            // Increment click count
            $coupon->clicks++;
            $coupon->save();

            // Assuming you have a route named 'store.detail' that shows the store detail page
            return redirect()->route('store_details', ['id' => $coupon->store_id]);
        }
        // Handle case where coupon is not found
        return redirect()->back()->with('error', 'Coupon not found.');
    }
// For updating click counts
public function updateClicks(Request $request)
{
    try {
        $couponId = $request->input('coupon_id');
        
        if (!$couponId) {
            return response()->json([
                'success' => false, 
                'message' => 'Coupon ID is required'
            ], 400);
        }
        
        $coupon = Coupons::find($couponId);
        
        if ($coupon) {
            $coupon->increment('clicks');
            return response()->json([
                'success' => true, 
                'message' => 'Click count updated',
                'new_count' => $coupon->clicks
            ]);
        }
        
        return response()->json([
            'success' => false, 
            'message' => 'Coupon not found'
        ], 404);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false, 
            'message' => $e->getMessage()
        ], 500);
    }
}

// For updating order positions (your existing function)
public function updateOrder(Request $request)
{
    try {
        $orderData = $request->order;
        
        foreach ($orderData as $order) {
            $coupon = Coupons::find($order['id']);
            if ($coupon) {
                $coupon->order = $order['position'];
                $coupon->save();
            }
        }
        
        return response()->json(['status' => 'success', 'message' => 'Update Successfully.']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
        public function updatecoupon(Request $request)
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

    public function index(Request $request)
    {
        // Count total coupons (for dashboard or stats)
        $coupon_count = Coupons::count();

        // Handle AJAX request
        if ($request->ajax()) {

            $storeId = $request->input('store_id');

            $couponsQuery = Coupons::query();

            if (!empty($storeId)) {
                $couponsQuery->where('store_id', $storeId);
            }

            $coupons = $couponsQuery
                ->orderBy('store_id', 'asc')
                ->orderByRaw('CAST(`order` AS SIGNED) ASC')
                ->limit(100)
                ->get();

            return response()->json([
                'coupons' => $coupons,
                'coupon_count' => $coupon_count
            ]);
        }

        // For normal page load
        $couponstore = Coupons::select('store_id')->distinct()->get();
        $selectedCoupon = $request->input('store_id');

        $productsQuery = Coupons::query();

        if (!empty($selectedCoupon)) {
            $productsQuery->where('store_id', $selectedCoupon);
        }

        $coupons = $productsQuery
            ->orderBy('store_id', 'asc')
            ->orderByRaw('CAST(`order` AS SIGNED) ASC')
            ->limit(100)
            ->get();

        return view('admin.coupons.index', compact(
            'coupons',
            'couponstore',
            'selectedCoupon',
            'coupon_count'
        ));
    }

    public function create()
    {
        $stores = Stores::orderBy('created_at', 'desc')->get();
        $langs = Language::all();
        return view('admin.coupons.create', compact('stores','langs'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'language_id' => 'nullable|integer',
            'description' => 'nullable|string|max:1000',
            'code' => 'nullable|string|max:100',
            'ending_date' => 'nullable|date|after_or_equal:today',
            'authentication' => 'nullable|string',
             'store_id' => 'required|integer',
            'top_coupons' => 'nullable|integer|min:0',
        ]);

        // Create coupon using validated data
        Coupons::create([
            'name' => $request->name,
            'language_id' => $request->input('language_id'),
            'description' => $request->description,
            'code' => $request->code,
            'ending_date' => $request->ending_date,
            'status' => $request->status,
            'authentication' => $request->authentication ?? 'feature',
            'store_id' => $request->store_id,
            'top_coupons' => $request->top_coupons,
        ]);

        return redirect()->back()->withInput()->with(['success' => 'Coupon created Successfully!', 'show_modal' => true]);
    }
    public function edit($id)
    {
        $coupons = Coupons::find($id);
        $stores = Stores::orderBy('created_at', 'desc')->get();
        $langs = Language::all();
        return view('admin.coupons.edit', compact('coupons', 'stores', 'langs'));
    }
    public function update(Request $request, $id)
    {
        $coupon = Coupons::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'language_id' => 'nullable|integer',
            'description' => 'nullable|string|max:1000',
            'code' => 'nullable|string|max:100',
            'ending_date' => 'nullable|date|after_or_equal:today',
            'authentication' => 'nullable|array',
            'authentication.*' => 'string',
            'store' => 'nullable|string|max:255',
            'top_coupons' => 'nullable|integer|min:0',
        ]);

        // ✅ Update current coupon
        $coupon->update([
            'name' => $request->name,
            'language_id' => $request->input('language_id', $coupon->language_id),
            'description' => $request->description,
            'code' => $request->code,
            'status' => $request->status,
            'authentication' => $request->has('authentication')
                ? json_encode($request->authentication)
                : 'No Auth',
            'store_id' => $request->input('store_id', $coupon->store_id),
            'top_coupons' => $request->top_coupons,
            'updated_id' => Auth::id(),
        ]);

        // ✅ If ending_date is provided → update ALL coupons of same store
        if ($request->filled('ending_date')) {
            Coupons::where('store_id', $coupon->store_id)
                ->update([
                    'ending_date' => $request->ending_date,
                ]);
        }

        $store = Stores::find($coupon->store_id);

        if ($store) {
            $url = route('admin.store.store_details', ['slug' => Str::slug($store->slug)]);
            return redirect($url)->with('success', 'Coupons updated successfully');
        }

        return redirect()->back()->with('error', 'Store not found.');
    }

    public function delete($id)
    {
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

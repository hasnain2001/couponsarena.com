<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Categories;
use App\Models\Coupons;
use App\Models\Language;
use App\Models\Networks;
use App\Models\Stores;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    /**
     * Display the main dashboard
     */
    public function dashboard()
    {
        $data = $this->getDashboardData();
        return view('admin.dashboard', $data);
    }

    /**
     * Get dashboard data for AJAX requests
     */
    public function getStats(Request $request)
    {
        $period = $request->get('period', 'today');
        $data = $this->getDashboardData($period);

        // Remove full collections, keep only counts for AJAX
        $ajaxData = [
            'stores_count' => $data['stores']->count(),
            'blogs_count' => $data['blogs']->count(),
            'categories_count' => $data['categories']->count(),
            'coupons_count' => $data['coupons']->count(),
            'users_count' => $data['users']->count(),
            'langs_count' => $data['langs']->count(),

            // Additional stats
            'activeCoupons' => $data['activeCoupons'],
            'expiringSoon' => $data['expiringSoon'],
            'todayUsers' => $data['todayUsers'],
            'activeStores' => $data['activeStores'],
            'publishedBlogs' => $data['publishedBlogs'],
            'newStoresToday' => $data['newStoresToday'],
            'totalRevenue' => $data['totalRevenue'],
            'todayRevenue' => $data['todayRevenue'],
            'activeUsers' => $data['activeUsers'],
            'onlineUsers' => $data['onlineUsers'],
            'totalViews' => $data['totalViews'],
            'todayViews' => $data['todayViews'],
            'popularCategory' => $data['popularCategory'],
            'popularLanguage' => $data['popularLanguage'],
            'activeNetworks' => $data['activeNetworks'],

            // Collections for recent items
            'recentStores' => $data['recentStores']->orderBy('created_at', 'desc'),
            'recentCoupons' => $data['recentCoupons']->orderBy('created_at', 'desc'),
            'recentBlogs' => $data['recentBlogs']->orderBy('created_at', 'desc'),
            'recentUsers' => $data['recentUsers']->orderBy('created_at', 'desc'),

            'period' => $period,
            'updated_at' => now()->format('H:i:s'),
        ];

        return response()->json($ajaxData);
    }

    /**
     * Get stats for specific time period
     */
    public function getPeriodStats($period)
    {
        $data = $this->getDashboardData($period);

        return response()->json([
            'success' => true,
            'period' => $period,
            'data' => [
                'stores_count' => $data['stores']->count(),
                'blogs_count' => $data['blogs']->count(),
                'coupons_count' => $data['coupons']->count(),
                'users_count' => $data['users']->count(),
                'activeCoupons' => $data['activeCoupons'],
                'todayUsers' => $data['todayUsers'],
                'activeStores' => $data['activeStores'],
                'publishedBlogs' => $data['publishedBlogs'],
                'newStoresToday' => $data['newStoresToday'],
                'totalRevenue' => $data['totalRevenue'],
                'todayRevenue' => $data['todayRevenue'],
            ]
        ]);
    }

    /**
     * Refresh dashboard stats
     */
    public function refreshStats()
    {
        $data = $this->getDashboardData();

        return response()->json([
            'success' => true,
            'message' => 'Stats refreshed successfully',
            'updated_at' => now()->format('Y-m-d H:i:s'),
            'stats' => [
                'stores' => $data['stores']->count(),
                'blogs' => $data['blogs']->count(),
                'coupons' => $data['coupons']->count(),
                'users' => $data['users']->count(),
                'activeCoupons' => $data['activeCoupons'],
                'expiringSoon' => $data['expiringSoon'],
            ]
        ]);
    }

    /**
     * Helper method to get dashboard data
     */
    private function getDashboardData($period = 'today')
    {
        // Calculate date ranges based on period
        $dateRange = $this->getDateRange($period);

        return [
            'stores' => Stores::all(),
            'blogs' => Blog::all(),
            'categories' => Categories::all(),
            'networks' => Networks::all(),
            'coupons' => Coupons::all(),
            'users' => User::all(),
            'langs' => Language::all(),

            // Additional stats for enhanced dashboard
            'recentStores' => Stores::with('language', 'categories')
                ->when($dateRange, function($query) use ($dateRange) {
                    return $query->whereBetween('created_at', $dateRange);
                })
                ->latest()
                ->take(5)
                ->get(),

            'recentCoupons' => Coupons::with('stores')
                ->when($dateRange, function($query) use ($dateRange) {
                    return $query->whereBetween('created_at', $dateRange);
                })
                ->latest()
                ->take(5)
                ->get(),

            'recentBlogs' => Blog::with('language')
                ->when($dateRange, function($query) use ($dateRange) {
                    return $query->whereBetween('created_at', $dateRange);
                })
                ->latest()
                ->take(4)
                ->get(),

            'recentUsers' => User::when($dateRange, function($query) use ($dateRange) {
                    return $query->whereBetween('created_at', $dateRange);
                })
                ->latest()
                ->take(5)
                ->get(),

            'activeCoupons' => Coupons::where('status', 'enable')->count(),
            'expiringSoon' => Coupons::where('status', 'enable')
                ->where('ending_date', '>=', now())
                ->where('ending_date', '<=', now()->addDays(3))
                ->count(),

            'todayUsers' => User::whereDate('created_at', today())->count(),
            'activeStores' => Stores::where('status', 'enable')->count(),
            'publishedBlogs' => Blog::where('status', 'enable')->count(),
            'newStoresToday' => Stores::whereDate('created_at', today())->count(),

            // For demo purposes - you can implement real calculations
            'totalRevenue' => $this->calculateTotalRevenue($period),
            'todayRevenue' => $this->calculateTodayRevenue(),
            'activeUsers' => $this->getActiveUsers(),
            'onlineUsers' => $this->getOnlineUsers(),
            'totalViews' => $this->getTotalViews($period),
            'todayViews' => $this->getTodayViews(),
            'popularCategory' => $this->getPopularCategory($period),
            'popularLanguage' => $this->getPopularLanguage(),
            'activeNetworks' => Networks::count(),

            // System stats
            'diskUsage' => $this->getDiskUsage(),
            'memoryUsage' => $this->getMemoryUsage(),

            // Period info
            'period' => $period,
        ];
    }

    /**
     * Helper method to get date range based on period
     */
    private function getDateRange($period)
    {
        switch ($period) {
            case 'today':
                return [today(), now()];
            case 'week':
                return [now()->subWeek(), now()];
            case 'month':
                return [now()->subMonth(), now()];
            case 'year':
                return [now()->subYear(), now()];
            default:
                return null;
        }
    }

    /**
     * Calculate total revenue (implement your own logic)
     */
    private function calculateTotalRevenue($period = 'today')
    {
        // Implement your revenue calculation logic here
        // This is a placeholder
        $baseRevenue = 24500;

        switch ($period) {
            case 'today':
                return rand(100, 500);
            case 'week':
                return rand(2000, 5000);
            case 'month':
                return rand(15000, 25000);
            default:
                return $baseRevenue;
        }
    }

    /**
     * Calculate today's revenue
     */
    private function calculateTodayRevenue()
    {
        // Implement your today's revenue calculation
        return rand(100, 500);
    }

    /**
     * Get active users (users active in last 30 days)
     */
    private function getActiveUsers()
    {
        return User::where('last_seen', '>=', now()->subDays(30))
            ->orWhere('created_at', '>=', now()->subDays(30))
            ->count();
    }

    /**
     * Get online users (users active in last 2 minutes)
     */
    private function getOnlineUsers()
    {
        return User::where('last_seen', '>=', now()->subMinutes(2))
            ->count();
    }

    /**
     * Get total views
     */
    private function getTotalViews($period)
    {
        // Implement your view tracking logic
        $baseViews = 125000;

        switch ($period) {
            case 'today':
                return rand(1000, 3000);
            case 'week':
                return rand(10000, 20000);
            case 'month':
                return rand(80000, 120000);
            default:
                return $baseViews;
        }
    }

    /**
     * Get today's views
     */
    private function getTodayViews()
    {
        return rand(1000, 3000);
    }

    /**
     * Get popular category
     */
    private function getPopularCategory($period)
    {
        // You can implement logic to get most popular category
        $categories = ['Electronics', 'Fashion', 'Home & Garden', 'Travel', 'Food'];
        return $categories[array_rand($categories)];
    }

    /**
     * Get popular language
     */
    private function getPopularLanguage()
    {
        $languages = Language::all();
        if ($languages->count() > 0) {
            return $languages->first()->name;
        }
        return 'English';
    }

    /**
     * Get disk usage (placeholder - implement your own logic)
     */
    private function getDiskUsage()
    {
        // You can use PHP's disk functions or your own logic
        // This is a placeholder
        return '75%';
    }

    /**
     * Get memory usage (placeholder - implement your own logic)
     */
    private function getMemoryUsage()
    {
        // This is a placeholder
        return '62%';
    }

    // Your existing user management methods...
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.user.index', compact('users'));
    }

    public function create_user()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.user.create', compact('users'));
    }

    public function store_user(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
        ]);
        return redirect()->back()->withInput()->with('success', 'User created successfully.');
    }

    public function edit_user($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update_user(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'role' => 'nullable',
        ]);

        $user->update([
            'role' => $request->input('role'),
        ]);
        return redirect()->route('admin.user.index')->with('success', 'User Updated Successfully');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.user.index')->with('error', 'User not found.');
        }
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User deleted successfully.');
    }
}

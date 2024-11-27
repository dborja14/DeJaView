<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShoeSalesController extends Controller
{
    public function getLineChart(Request $request)
    {
        try {
            $view = $request->input('view', '1 year');
            $salesQuery = DB::table('orders')->where('paymentStatus', 'Approved');

            $dates = []; // Initialize dates
            $totalSales = []; // Initialize totalSales

            // Handle 1 week view
            if ($view === '1 week') {
                $startOfWeek = now()->startOfWeek(Carbon::SUNDAY); // Ensure start of week is Sunday
                $endOfWeek = now()->endOfWeek(Carbon::SATURDAY); // End of the week (Saturday)

                $dates = []; // Days of the week labels (Sunday to Saturday)
                $totalSales = array_fill(0, 7, 0); // Initialize sales data for each day

                // Generate labels for each day of the week (Sunday to Saturday)
                for ($i = 0; $i < 7; $i++) {
                    $dates[] = $startOfWeek->copy()->addDays($i)->format('l'); // "Sunday", "Monday", etc.
                }

                // Get the sales data grouped by day of the week, starting from Sunday
                $sales = $salesQuery->select(
                    DB::raw('DAYOFWEEK(updated_at) as week_day'), // 1 for Sunday, 7 for Saturday
                    DB::raw('SUM(totalPrice) as total_revenue')
                )
                    ->whereBetween('updated_at', [$startOfWeek, $endOfWeek])
                    ->groupBy('week_day')
                    ->orderBy('week_day')
                    ->get();

                // Populate totalSales based on the sales data
                foreach ($sales as $sale) {
                    $index = $sale->week_day - 1; // Adjust to zero-based index (1 for Sunday becomes 0)
                    if ($index >= 0 && $index < 7) {
                        $totalSales[$index] = (float) $sale->total_revenue; // Set the order count for the correct day
                    }
                }

                // Return the labels and data for the 1 week view
                return response()->json(['labels' => $dates, 'data' => $totalSales]);
            } else {
                // Handle other views (unchanged)
                $salesQuery->select(
                    DB::raw('DATE_FORMAT(updated_at, "%Y-%m-%d") as sale_date'), // Change to match view
                    DB::raw('SUM(totalPrice) as total_revenue') // Use SUM for revenue
                )->when($view === '1 month', function ($query) {
                    return $query->whereYear('updated_at', now()->year)
                        ->whereMonth('updated_at', now()->month);
                })->when($view === '3 months', function ($query) {
                    return $query->where('updated_at', '>=', now()->subMonths(3)->startOfDay());
                })->when($view === '6 months', function ($query) {
                    return $query->where('updated_at', '>=', now()->subMonths(6)->startOfDay());
                })->when($view === '1 year', function ($query) {
                    return $query->where('updated_at', '>=', now()->subYear()->startOfDay());
                });

                // Group by sale_date and get the results
                $sales = $salesQuery->groupBy('sale_date')->orderBy('sale_date')->get();

                // Remove the early return to allow all views to handle empty sales data
                // if ($sales->isEmpty()) {
                //     return response()->json(['labels' => [], 'data' => [], 'message' => 'No sales data available for this timeframe.']);
                // }

                // Prepare the data for other views
                switch ($view) {
                    case '1 month':
                        $monthName = now()->format('F'); // Current month name
                        $daysInMonth = now()->daysInMonth;
                        $monthLabels = [];
                        $totalSales = array_fill(0, $daysInMonth, 0); // Initialize with zeros

                        for ($day = 1; $day <= $daysInMonth; $day++) {
                            $monthLabels[] = "$monthName $day";
                        }

                        foreach ($sales as $sale) {
                            $day = (int) date('d', strtotime($sale->sale_date));
                            $totalSales[$day - 1] = (float) $sale->total_revenue; // Adjust for zero-based index
                        }

                        return response()->json(['labels' => $monthLabels, 'data' => $totalSales]);

                    case '3 months':
                        $monthLabels = [];
                        $totalSales = array_fill(0, 3, 0); // Initialize for 3 months
                        for ($i = 2; $i >= 0; $i--) {
                            $monthLabels[] = now()->subMonths($i)->format('F'); // Last 3 months
                        }

                        foreach ($sales as $sale) {
                            $monthIndex = (int) date('n', strtotime($sale->sale_date)) - now()->subMonths(2)->format('n');
                            if ($monthIndex >= 0 && $monthIndex < 3) {
                                $totalSales[$monthIndex] += (float) $sale->total_revenue;
                            }
                        }

                        return response()->json(['labels' => $monthLabels, 'data' => $totalSales]);

                    case '6 months':
                        $monthLabels = [];
                        $totalSales = array_fill(0, 6, 0); // Initialize for 6 months
                        for ($i = 5; $i >= 0; $i--) {
                            $monthLabels[] = now()->subMonths($i)->format('F'); // Last 6 months
                        }

                        foreach ($sales as $sale) {
                            $monthIndex = (int) date('n', strtotime($sale->sale_date)) - now()->subMonths(5)->format('n');
                            if ($monthIndex >= 0 && $monthIndex < 6) {
                                $totalSales[$monthIndex] += (float) $sale->total_revenue;
                            }
                        }

                        return response()->json(['labels' => $monthLabels, 'data' => $totalSales]);

                    case '1 year':
                        $monthLabels = [];
                        $totalSales = array_fill(0, 12, 0); // Initialize for 12 months

                        // Create labels for each month (January to December)
                        for ($i = 0; $i < 12; $i++) {
                            $monthLabels[] = now()->startOfYear()->addMonths($i)->format('F'); // January to December
                        }

                        foreach ($sales as $sale) {
                            // Use Carbon to parse the sale date and get the correct month index (0 for January, 11 for December)
                            $saleDate = Carbon::parse($sale->sale_date); // Ensure the date is parsed correctly

                            // Check if the saleDate is within the current year
                            if ($saleDate->year === now()->year) {
                                $monthIndex = $saleDate->month - 1; // Carbon provides a 1-based month index, subtract 1 to match zero-based array

                                // Ensure monthIndex is between 0 and 11
                                if ($monthIndex >= 0 && $monthIndex < 12) {
                                    $totalSales[$monthIndex] += (float) $sale->total_revenue; // Add sales to the correct month
                                }
                            }
                        }

                        return response()->json(['labels' => $monthLabels, 'data' => $totalSales]);

                    case 'Max':
                        // Fetch all sales data without time constraints
                        $allSales = DB::table('orders')
                            ->where('paymentStatus', 'Approved')
                            ->select(DB::raw('DATE_FORMAT(updated_at, "%Y %M") as sale_month'), DB::raw('SUM(totalPrice) as total_revenue'))
                            ->groupBy('sale_month')
                            ->orderBy('updated_at')
                            ->get();

                        $monthLabels = [];
                        $totalSales = [];

                        foreach ($allSales as $sale) {
                            $monthLabels[] = $sale->sale_month; // "YEAR NAME OF MONTH" format (e.g., "2023 January")
                            $totalSales[] = (float) $sale->total_revenue; // Revenue
                        }

                        return response()->json(['labels' => $monthLabels, 'data' => $totalSales]);
                }

                // If none of the cases match, return empty labels and data
                return response()->json(['labels' => [], 'data' => []]);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching sales data for line chart: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch line chart data.'], 500);
        }
    }

    public function getPieChart(Request $request)
    {
        try {
            // Get the most bought shoes for pie chart
            $shoes = DB::table('orders')
                ->join('products', 'orders.productId', '=', 'products.id')
                ->select('products.productName as name', DB::raw('SUM(orders.quantity) as total_quantity'))
                ->where('paymentStatus', 'Approved')
                ->groupBy('name')
                ->orderBy('total_quantity', 'desc')
                ->get();

            // Prepare data for the pie chart
            $shoeLabels = $shoes->pluck('name');
            $shoeQuantities = $shoes->pluck('total_quantity');

            return response()->json([
                'labels' => $shoeLabels,
                'data' => $shoeQuantities
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching sales data for pie chart: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch pie chart data.'], 500);
        }
    }

    public function getMonthlyComparison()
    {
        $currentYear = now()->year;
    
        // Fetch sales data for the current year
        $revenues = DB::table('orders')
            ->select(
                DB::raw('MONTH(updated_at) as month_number'),
                DB::raw('DATE_FORMAT(updated_at, "%M") as month'), // Month name
                DB::raw('SUM(totalPrice) as total_revenue')
            )
            ->where('paymentStatus', 'Approved')
            ->whereYear('updated_at', $currentYear)
            ->groupBy('month_number', 'month')
            ->orderBy('month_number') // Order by month number
            ->get()
            ->keyBy('month_number'); // Key the results by month_number for easier access
    
        // List of all months
        $allMonths = collect([
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ]);
    
        // Prepare the monthly comparison
        $monthlyComparison = [];
        $previousRevenue = null;
    
        foreach ($allMonths as $monthNumber => $monthName) {
            $current = $revenues->get($monthNumber) ?? (object)[
                'month_number' => $monthNumber,
                'month' => $monthName,
                'total_revenue' => 0
            ];
    
            if ($previousRevenue !== null) {
                $difference = $current->total_revenue - $previousRevenue->total_revenue;
                $monthlyComparison[] = [
                    'month' => $current->month,
                    'revenue' => $current->total_revenue,
                    'difference' => $difference,
                    'percentage_change' => $previousRevenue->total_revenue > 0
                        ? $difference / $previousRevenue->total_revenue * 100
                        : null // Avoid division by zero
                ];
            } else {
                $monthlyComparison[] = [
                    'month' => $current->month,
                    'revenue' => $current->total_revenue,
                    'difference' => null,
                    'percentage_change' => null
                ];
            }
    
            $previousRevenue = $current;
        }
    
        return response()->json($monthlyComparison);
    }  

    public function getPeakAndOffMonths()
    {
        $revenues = DB::table('orders')
            ->select(
                DB::raw('DATE_FORMAT(updated_at, "%M %Y") as month'), // Format as "Month Year"
                DB::raw('SUM(totalPrice) as total_revenue')
            )
            ->where('paymentStatus', 'Approved')
            ->groupBy('month')
            ->orderBy('total_revenue', 'desc')
            ->get();

        $peakMonth = $revenues->first();  // Month with highest revenue
        $offMonth = $revenues->last();    // Month with lowest revenue

        // Format the output with "Month Year - ₱Sales" for each
        $peakMonthFormatted = "{$peakMonth->month} - ₱" . number_format($peakMonth->total_revenue, 2);
        $offMonthFormatted = "{$offMonth->month} - ₱" . number_format($offMonth->total_revenue, 2);

        return response()->json([
            'peak_month' => $peakMonthFormatted,
            'off_month' => $offMonthFormatted,
        ]);
    }

    public function getMostProfitableBrandAndCategory()
    {
        // Query to get the most profitable brand
        $brands = DB::table('orders')
            ->join('products', 'orders.productId', '=', 'products.id')  // Join orders with products
            ->join('features', 'products.id', '=', 'features.productId') // Join products with features
            ->join('brands', 'features.brandId', '=', 'brands.id')      // Join features with brands
            ->select('brands.productBrand as brand_name', DB::raw('SUM(orders.totalPrice) as total_revenue')) // Select brand name and total revenue
            ->where('orders.paymentStatus', 'Approved')                   // Filter for approved payments
            ->groupBy('brands.productBrand')                               // Group by brand name to get total revenue per brand
            ->orderBy('total_revenue', 'desc')                             // Order by total revenue in descending order
            ->first();  // Get the most profitable brand

        // Query to get the most profitable product category
        $categories = DB::table('orders')
            ->join('products', 'orders.productId', '=', 'products.id')  // Join orders with products
            ->select('products.productName as category_name', DB::raw('SUM(orders.totalPrice) as total_revenue')) // Select category name and total revenue
            ->where('orders.paymentStatus', 'Approved')                  // Filter for approved payments
            ->groupBy('products.productName')                         // Group by category name to get total revenue per category
            ->orderBy('total_revenue', 'desc')                            // Order by total revenue in descending order
            ->first();  // Get the most profitable category

        // Return the most profitable brand and category
        return response()->json([
            'most_profitable_brand' => $brands,  // Return the most profitable brand
            'most_profitable_category' => $categories,  // Return the most profitable product category
        ]);
    }

    public function getForecast()
    {
        // Determine the current month and the next month
        $currentMonth = now()->format('m');
        $currentYear = now()->format('Y');
        $nextMonth = now()->addMonth()->format('m');

        // Fetch sales for the next month's historical data from previous years
        $pastSales = DB::table('orders')
            ->select(
                DB::raw('YEAR(updated_at) as year'),
                DB::raw('SUM(totalPrice) as total_revenue')
            )
            ->where('paymentStatus', 'Approved')
            ->whereMonth('updated_at', $nextMonth) // Filter for the next month
            ->whereYear('updated_at', '<', $currentYear) // Exclude the current year's data
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        // Calculate the average revenue for that month
        $averageRevenue = $pastSales->avg('total_revenue') ?? 0; // Default to 0 if no data

        // Format the forecasted revenue with Philippine peso sign and limit to 2 decimal places
        $formattedForecast = '₱' . number_format($averageRevenue, 2);

        // Return the forecast as formatted value
        return response()->json([
            'forecast_next_month' => $formattedForecast,
        ]);
    }

    public function getSurveyResults()
    {
        // Fetch the most frequent category (q1)
        $mostFrequentCategory = Preference::select('q1')
            ->groupBy('q1')
            ->orderByRaw('COUNT(*) DESC')
            ->value('q1'); // Get the most frequent value directly

        // Fetch the most frequent shoe type (q2) with the related shoetype name
        $mostFrequentShoeType = Preference::select('q2')
            ->groupBy('q2')
            ->orderByRaw('COUNT(*) DESC')
            ->first();

        $shoeTypeName = $mostFrequentShoeType
            ? $mostFrequentShoeType->shoetype->name ?? 'No data'
            : 'No data';

        // Fetch the most frequent brand (q5)
        $mostFrequentBrand = Preference::select('q5')
            ->groupBy('q5')
            ->orderByRaw('COUNT(*) DESC')
            ->value('q5'); // Get the most frequent value directly

        // Format results as an array
        $results = [
            'most_frequent_category' => $mostFrequentCategory ?? 'No data',
            'most_frequent_shoe_type' => $shoeTypeName,
            'most_frequent_brand' => $mostFrequentBrand ?? 'No data',
        ];

        // Return results as JSON
        return response()->json($results);
    }
}

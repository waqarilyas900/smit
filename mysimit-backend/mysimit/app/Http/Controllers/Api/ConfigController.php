<?php

namespace App\Http\Controllers\Api;

use App\Models\Zone;
use App\Models\Product;
use App\Models\AboutFaq;
use App\Models\RiderFaq;
use App\Models\Settings;
use App\Models\Appearance;
use App\Models\HowItWorks;
use App\Models\WorkWithUs;
use App\Models\WhyChooseUs;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Facades\ConfigHelper;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Enums\OrderStatus;

class ConfigController extends Controller
{

    /**
     * Get the appearances and settings
     */
    public function __invoke()
    {
        $data = [
            'settings'      => Settings::all(),
            'appearances'   => Appearance::all(),
            'howItWorks'    => HowItWorks::all(),
            'workWithUs'    => WorkWithUs::all(),
            'riderFaqs'     => RiderFaq::all(),
            'aboutFaqs'     => AboutFaq::all(),
            'whyChooseUs'   => WhyChooseUs::all(),
            'enums'         => ConfigHelper::getEnums(),
            'options'       => ConfigHelper::getOptions(),
            'discounted_products' => Product::whereNotNull('discount')->get(),
            // 'featureProducts' => Product::withCount('orderItems')->orderBy('order_items_count', 'desc')->take(6)->get(),
            // 'cities'        => Zone::select('city')->distinct()->pluck('city')->toArray(),
            'cities'        => Zone::where('status',1)->get(),
        ];
        return new ApiResource($data);
    }


    public function getChartData(Request $request)
    {
    $customer = $request->query('customer');
    $dateRange = $request->query('dateRange');
    $orderStatus = $request->query('orderStatus');
    // if($orderStatus){
    //     return $orderStatus;
    // }
    $query = Order::select('customer_id', 'delivery_date', 'status')
        ->with('customer')
        ->when($customer, function ($query, $customer) {
            return $query->where('customer_id', $customer);
        })
        ->when($dateRange, function ($query, $dateRange) {
            switch ($dateRange) {
                case 'weekly':
                    return $query->whereBetween('delivery_date', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                case 'monthly':
                    return $query->whereBetween('delivery_date', [
                        now()->startOfMonth(),
                        now()->endOfMonth()
                    ]);
                case 'yearly':
                    return $query->whereBetween('delivery_date', [
                        now()->startOfYear(),
                        now()->endOfYear()
                    ]);}
        })
        ->when($orderStatus, function ($query, $orderStatus) {
            return $query->where('status', $orderStatus);
        });

    $data = $query->get();

    $groupedData = $data->groupBy(function ($item) {
        return Carbon::parse($item->delivery_date)->format('Y M');
    });

    $months = [];
    $pendingCounts = [];
    $paidCounts = [];
    $pendingCounts = [];
    $shippedCounts = [];
    $deliveredCounts = [];
    $canceledCounts = [];
    $refundedCounts = [];
    foreach ($groupedData as $month => $orders) {
        $months[] = $month;
        $pendingCounts[] = $orders->where('status', 'pending')->count();
        $shippedCounts[] = $orders->where('status', 'shipped')->count();
        $deliveredCounts[] = $orders->where('status', 'delivered')->count();
        $canceledCounts[] = $orders->where('status', 'canceled')->count();
        $refundedCounts[] = $orders->where('status', 'refunded')->count();
    }

    $chartData = [
        'labels' => $months,
        'datasets' => [
            [
                'label' => 'Pending',
                'data' => $pendingCounts,
                'backgroundColor' => 'rgba(0, 0, 0, 1)',
            ],
            [
                'label' => 'Shipped',
                'data' => $shippedCounts,
                'backgroundColor' => 'rgba(241, 194, 50, 1)',
            ],
            [
                'label' => 'Delivered',
                'data' => $deliveredCounts,
                'backgroundColor' => 'rgba(106, 168, 79, 1)', // Example color for "Delivered"
            ],
            [
                'label' => 'Canceled',
                'data' => $canceledCounts,
                'backgroundColor' => 'rgba(128, 0, 128, 1)', // Example color for "Canceled"
            ],
            [
                'label' => 'Refunded',
                'data' => $refundedCounts ? $refundedCounts : [],
                'backgroundColor' => 'rgba(103, 78, 167, 0.5)', // Example color for "Refunded"
            ],
        ],
    ];
        return [
         
            'chartData' => $chartData,
            'month' => [$pendingCounts, $shippedCounts, $deliveredCounts, $canceledCounts, $refundedCounts ],
            'check' => [$customer, $dateRange, $orderStatus],
            'statusOptions' => OrderStatus::toSelectOptions(),
        ];
    }


    public function getUsers()
    {
        return response(['data' => Customer::all()]);
    }
}


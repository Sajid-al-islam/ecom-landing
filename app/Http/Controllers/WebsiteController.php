<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Services\FacebookConversionAPIService;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    protected $facebookService;
    public function __construct(FacebookConversionAPIService $facebookService)
    {
        $this->facebookService = $facebookService;
    }
    public function website()
    {
        $product = Product::first();

        $cart = new CartController();
        $this->facebookService->sendEvent('ViewContent', [
            'event_source_url' => url()->current(),
            'user_data' => $this->getUserData(),
            'custom_data' => [
                'content_ids' => [$product->id],
                'content_name' => $product->product_name,
                'content_category' => $product->categories[0]?->name,
                'content_type' => 'product',
                'value' => $product->sales_price,
                'currency' => 'BDT'
            ],
        ]);
        $cart->add_to_cart($product->id, 1, null);

        $this->facebookService->sendEvent('InitiateCheckout', [
            'event_source_url' => url()->current(),
            'user_data' => $this->getUserData(),
            'custom_data' => [
                'content_ids' => [$product->id],
                'content_type' => [$product->product_name],
                'content_category' => $product->categories[0]?->name,
                'content_type' => 'product',
                'value' => $product->sales_price,
                'currency' => 'BDT',
                "num_items" => 1,
            ],
        ]);
        return view('frontend.home', compact('product'));
    }

    protected function getUserData()
    {
        $user = auth()->user();
        if(!empty($user)) {
            return [
                'em' => hash('sha256', $user->email),
                'ph' => hash('sha256', $user->phone),
                'fn' => hash('sha256', $user->first_name),
                'ln' => hash('sha256', $user->last_name),
            ];
        }else {
            return [
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ];
        }
        return $user;
    }

    public function aboutus()
    {
        return view('frontend.aboutus');;
    }

    public function privacy_policy()
    {
        return view('frontend.privacy_policy');;
    }

    public function terms()
    {
        return view('frontend.terms');;
    }

    public function refund_policy()
    {
        return view('frontend.refund_policy');
    }

    public function product_details($id, $product_name)
    {
        $product = Product::where('id', $id)
            ->withSum('stocks', 'qty')
            ->withSum('sales', 'qty')
            ->with('product_brand')
            ->first();
        return view('frontend.product-details', compact('product'));
    }

    public function invoice_download($invoice)
    {
        $order_details = Order::where('invoice_id', $invoice)->with(['order_address', 'order_payments', 'order_details' => function ($q) {
            $q->with('product');
        }])->first();

        return view('backend.invoice', compact('order_details', $order_details));
    }

    public function category_products($id, $category_name)
    {

        $category = Category::where('id', $id)->first();
        $min_product_price = Product::select('selected_categories', 'sales_price')->whereJsonContains('selected_categories', $id)->orderBy('sales_price', 'ASC')->first();
        $max_product_price = Product::select('selected_categories', 'sales_price')->whereJsonContains('selected_categories', $id)->orderBy('sales_price', 'DESC')->first();

        if ($min_product_price) {
            $min_product_price = $min_product_price->sales_price;
        } else {
            $min_product_price = 0;
        }

        if ($max_product_price) {
            $max_product_price = $max_product_price->sales_price;
        } else {
            $max_product_price = 0;
        }

        return view('frontend.category_products', compact('category', 'min_product_price', 'max_product_price'));
    }

    public function add_to_cart(Request $request)
    {
        $cart = new CartController();
        $cart->add_to_cart($request->id, $request->qty, $request->size);
        return response()->json([
            'cart' => $cart->get(),
            "message" => "Cart added",
            'cart_count' => $cart->cart_count(),
            "cart_total" => $cart->cart_total(),
            "cart_total_formated" => number_format($cart->cart_total()),
        ], 200);
    }

    public function remove_cart(Request $request)
    {
        $cart = new CartController();
        $cart->remove($request->id);
        return response()->json([
            'cart' => $cart->get(),
            "message" => "cart removed",
            'cart_count' => $cart->cart_count(),
            "cart_total" => $cart->cart_total(),
            "cart_total_formated" => number_format($cart->cart_total()),
        ], 200);
    }

    public function clear_cart()
    {
        session()->forget('carts');
    }

    public function single_product_details($id)
    {
        $product = Product::find($id);
        return view('livewire.quick-view-product', compact('product'))->render();
    }

    public function cart_all()
    {
        ddd(session()->get('carts'));
    }
}

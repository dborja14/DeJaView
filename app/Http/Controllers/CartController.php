<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shoesize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class CartController extends Controller
{

    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                env('AcK0OKNydJhucW11-HfccF96OB6OVLxw67irncl3czo0ylrSpiTBMMA_W7ZV7tIGwFFTNdB0bs1iIgiF'),     // Your PayPal Client ID
                env('EAW8SA_U5oTduzYElh0VooIjigMuU_FApBFHsK-ETkoHo15ZuyZ-TPx71YT8qut6k9WYKIMZV3e7gaGq')         // Your PayPal Secret
            )
        );

        // Set the configuration options
        $this->apiContext->setConfig([
            'mode' => env('PAYPAL_MODE'), // 'sandbox' or 'live'
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'DEBUG', // PLEASE USE INFO LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
            'http.ConnectionTimeOut' => 30,
            'http.MaxConnections' => 200,
            'validation.level' => 'log'
        ]);
    }

    public function index(Request $request)
    {
        $userId = Session::get('user.id');

        $carts = Cart::with(['product', 'address'])->where('userId', $userId)->get();

        $totalOrderPrice = $carts->sum(function ($cart) {
            return $cart->product->productPrice * $cart->quantity; // Adjust if Cart model has quantity attribute
        });

        $addresses = Address::with('region')->where('userId', $userId)->get();

        $address = $addresses->first(); // You can change this if you need specific handling

        return view('cart', compact('carts', 'address', 'addresses', 'totalOrderPrice'));
    }


    public function addr(Request $request)
    {
        $userId = Session::get('user.id');
        $carts = Cart::with('product')->where('userId', $userId)->get();
        $addresses = Address::where('userId', $userId)->get();

        $addressId = $request->input('addressId');
        $address = null;

        if ($addressId) {
            $address = Address::find($addressId);
        } else {
            $address = Address::where('userId', $userId)->first();
        }

        return view('cart', compact('carts', 'address', 'addresses'));
    }

    public function changeAddr(Request $request)
    {
        $userId = Session::get('loginId');

        // Get all the cart items for the user
        $carts = Cart::where('userId', $userId)->get();

        if ($carts->isEmpty()) {
            // Optionally handle the case where the cart is empty
            return redirect()->back()->withErrors('Your cart is empty.');
        }

        // Loop through all cart items and update the address
        foreach ($carts as $cart) {
            $cart->addressId = $request->input('addressId');
            $cart->save();
        }

        return redirect()->back()->with('success', 'Address updated for all cart items.');
    }


    public function checkout(Request $request)
    {
        $addressId = $request->input('addressId');
        $products = $request->input('products'); // An array of products with productId, size, and quantity
        $paymentMethod = $request->input('paymentType'); // Get payment method from the request


        $address = Address::find($addressId);
        $totalOrderPrice = 0;
        $orders = [];
        $productIds = []; // To store the product IDs that are being checked out

        foreach ($products as $productData) {
            $product = Product::find($productData['productId']);
            $productIds[] = $productData['productId']; // Collect the product IDs for later cart removal

            $subtotal = $product->productPrice * $productData['quantity'];
            $totalOrderPrice += $subtotal;

            // Create and save the order
            $order = new Order();
            $order->userId = Session::get('user.id');
            $order->productId = $product->id;
            $order->addressId = $address->id;
            $order->size = $productData['size'];
            $order->quantity = $productData['quantity'];
            $order->totalPrice = 0;
            $order->paymentMethod = $request->input('paymentType');
            // Determine payment status based on the payment method
            if ($paymentMethod === 'paypal') {
                $order->paymentStatus = "Approved"; // Set to "Paid" if payment method is PayPal
            } else {
                $order->paymentStatus = "Pending"; // Keep as "Pending" for COD or GCash
            }
            $order->receiveMethod = $request->input('receiveMethod');
            $order->deliveryMethod = $request->input('deliveryMethod');
            $order->deliveryStatus = "Pending";
            $order->paymentImage = $request->input('paymentImage');
            $order->orderStatus = "Pending";

            if ($request->hasFile('paymentImage')) {
                if ($request->file('paymentImage')->isValid()) {
                    $fileName = time() . '.' . $request->file('paymentImage')->getClientOriginalExtension();
                    $path = $request->file('paymentImage')->storeAs('Images', $fileName, 'public');
                    $order->paymentImage = '/storage/' . $path;
                }
            }

            $order->save();

            $orders[] = $order;

            // Update the shoe size quantity
            $shoeSize = Shoesize::where('productId', $productData['productId'])
                ->where('size', $productData['size'])
                ->first();

            if ($shoeSize) {
                // Deduct the quantity sold from the available stock
                $shoeSize->quantity -= $productData['quantity'];

                // Prevent negative quantities
                if ($shoeSize->quantity < 0) {
                    $shoeSize->quantity = 0;
                }

                $shoeSize->save(); // Save the updated quantity
            }
        }

        foreach ($orders as $order) {
            $order->totalPrice = $totalOrderPrice;
            $order->save();
        }

        // Remove all checked-out products from the cart
        Cart::where('userId', Session::get('user.id'))
            ->whereIn('productId', $productIds) // Use 'whereIn' to match all product IDs
            ->delete();

        return redirect('collection')->with('success', 'Order Accepted');
    }

    public function removeCart(Request $request)
    {
        $cartId = $request->input('cartId');

        Cart::where('userId', Session::get('user.id'))
            ->where('id', $cartId)
            ->delete();

        return back()->with('removed', 'Item removed from cart successfully!');
    }

    public function paypalProcess(Request $request)
    {
        // Process the payment based on the chosen method
        $paymentType = $request->input('paymentType');

        if ($paymentType === 'paypal') {
            // Redirect to a PayPal page or create an order
            return view('checkout', ['total' => $request->input('total')]);
        }

        if ($response->status == 'CREATED') {
            // Redirect to PayPal approval URL
            return redirect($response->links[1]->href);
        }

        // If payment creation failed, handle it
        return redirect()->route('cart')->with('error', 'Something went wrong while processing your payment.');
    }

    public function paypalSuccess(Request $request)
    {
        // Confirm payment with PayPal (not shown, assumed completed)

        // Redirect to the checkout function to save the order
        return $this->checkout($request); // You might need to modify this to pass required parameters if any.
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Brand;
use App\Models\Credential;
use App\Models\Feature;
use App\Models\Fit;
use App\Models\Order;
use App\Models\Photo;
use App\Models\Product;
use App\Models\ShoeSale;
use App\Models\Shoesize;
use App\Models\ShoeType;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminControllerMid extends Controller
{
    public function index()
    {

        $usersCount = User::count();
        $users = User::all();
        $monthlySales = DB::table('orders')
        ->where('paymentStatus', 'Approved')
        ->whereMonth('updated_at', now()->month)
        ->whereYear('updated_at', now()->year)
        ->sum('totalPrice');
    
        $products = Product::all();
        $announc = Product::with('shoeSizes')->get();

        $lowStockSizes = [];

       
        foreach ($products as $product) {
            foreach ($product->shoeSizes as $size) {
                if ($size->quantity <= 1) {
                    $lowStockSizes[] = [
                        'productName' => $product->productName,
                        'size' => $size->size,
                        'quantity' => $size->quantity,
                    ];
                }
            }
        }
        $shoeSize = Shoesize::all();
        $productCount = Product::count();
        $pending = Order::where('paymentStatus', 'pending')->count();
        $pendingOrders = Order::where('orderStatus', 'pending')->count();
        $address = Address::all();
        $order = Order::all();
        $credentials = Credential::all();
        $types = ShoeType::all();

        $topBuyer = DB::table('orders')
            ->join('users', 'orders.userId', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.created_at', 
                DB::raw('COUNT(orders.id) as total_orders')
            )
            ->where('orders.paymentStatus', 'Approved')
            ->groupBy('users.id', 'users.name', 'users.email','users.created_at')
            ->orderBy('total_orders', 'desc')
            ->first(); 

       
        if ($topBuyer) {
            $memberSince = (new DateTime($topBuyer->created_at))->format('F d, Y');
        } else {
            $memberSince = 'N/A'; 
        }


        $mostBoughtShoes = DB::table('orders')
            ->join('products', 'orders.productId', '=', 'products.id')
            ->select(
                'products.id',
                'products.productName',
                'products.productDescription',
                'products.productSecond',
                'products.productPrice',
                DB::raw('SUM(orders.quantity) as total_quantity')
            )
            ->where('orders.paymentStatus', 'Approved')
            ->groupBy(
                'products.id',
                'products.productName',
                'products.productDescription',
                'products.productSecond',
                'products.productPrice'
            ) 
            ->orderBy('total_quantity', 'desc')
            ->take(3)
            ->get();



        $orders = Order::with('user')->get()->groupBy(function ($order) {
            return $order->created_at->format('Y-m-d H:i:s');
        });


        if ($monthlySales == 0) {
            $monthlySales = 0;
        }

        $auditLogs = [];

        foreach ($products as $product) {
            $auditLogs[] = [
                'date' => $product->created_at ? Carbon::parse($product->created_at) : null,
                'user' => 'Admin',
                'action' => $product->deleted_at ? 'Product Deleted' : 'Product Created',
                'details' => "Product Name: {$product->productName}, Product ID: {$product->id}, Price: {$product->productPrice}"
            ];
        }

        foreach ($shoeSize as $size) {
            $product = $products->find($size->productId);
            if ($product) {
                $auditLogs[] = [
                    'date' => $size->updated_at ? Carbon::parse($size->updated_at) : null,
                    'user' => 'Admin',
                    'action' => 'Shoe Size Stock Updated',
                    'details' => "Shoe Name: {$product->productName}, Shoe Size: {$size->size}, Updated Stock Quantity: {$size->quantity}, Shoe Size ID: {$size->id}"
                ];
            }
        }

        foreach ($users as $user) {
            $auditLogs[] = [
                'date' => $user->created_at ? Carbon::parse($user->created_at) : null,
                'user' => $user->name,
                'action' => 'User Registered',
                'details' => "User ID: {$user->id}, Email: {$user->email}"
            ];
        }

        foreach ($order as $ord) {
            $auditLogs[] = [
                'date' => $ord->created_at ? Carbon::parse($ord->created_at) : null,
                'user' => $ord->user->name,
                'action' => "Checked Out",
                'details' => "Product: {$ord->product->productName}, Quantity: {$ord->quantity}, Size: {$ord->size}"
            ];
        }

        foreach ($credentials as $cred) {
            $auditLogs[] = [
                'date' => $cred->created_at ? Carbon::parse($cred->updated_at) : null,
                'user' => $user->name,
                'action' => 'Update Account',
                'details' => "User ID: {$user->id}, Email: {$user->email}"
            ];
        }

        usort($auditLogs, function ($a, $b) {
            return $a['date'] <=> $b['date'];
        });


        return view('admin', compact(
            'usersCount',
            'users',
            'monthlySales',
            'products',
            'productCount',
            'pending',
            'pendingOrders',
            'orders',
            'address',
            'shoeSize',
            'auditLogs',
            'order',
            'types',
            'mostBoughtShoes',
            'topBuyer',
            'memberSince',
            'announc',
            'lowStockSizes'
        ));
    }

    public function addProducts()
    {

        $brands = Brand::all();
        $fits = Fit::all();
        $types = ShoeType::all();
        return view('adminPages.addProducts', compact('brands', 'fits', 'types'));
    }

    public function editProducts()
    {

        $brands = Brand::all();
        $fits = Fit::all();
        $products = Product::with('features')->get();
        $types = ShoeType::all();

        return view('adminPages.editProducts', compact('products', 'brands', 'fits', 'types'));
    }

    public function manageProducts()
    {

        $brands = Brand::all();
        $fits = Fit::all();
        $products = Product::all();
        $shoeSize = Shoesize::all();
        return view('adminPages.manageProducts', compact('brands', 'fits', 'products', 'shoeSize'));
    }

    public function removeProducts()
    {

        $brands = Brand::all();
        $fits = Fit::all();
        $products = Product::all();
        $shoeSize = Shoesize::all();
        return view('adminPages.removeProducts', compact('brands', 'fits', 'products', 'shoeSize'));
    }

    public function addProductsPost(Request $request)
    {
        $products = new Product();
        $products->productName = $request->input('productName');
        $products->productCategory = $request->input('productCategory');
        $products->productPrice = $request->input('productPrice');
        $products->productDescription = $request->input('productDescription');

        if ($request->hasFile('productThumbnail') && $request->file('productThumbnail')->isValid()) {
            $image = $request->file('productThumbnail');

            //paggawa ng file name

            $fileName = time() . '.png';
            $destinationPath = public_path('storage/Images/' . $fileName);

            // Create a new true color image
            $source = imagecreatefromstring(file_get_contents($image->getPathname()));

            // orig size
            $width = imagesx($source);
            $height = imagesy($source);

            // gagawing transparent bg
            $resizedImage = imagecreatetruecolor(500, 500);
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
            imagefilledrectangle($resizedImage, 0, 0, 500, 500, $transparent);

            // Resize 
            imagecopyresampled($resizedImage, $source, 0, 0, 0, 0, 300, 300, $width, $height);

            // Save 
            imagepng($resizedImage, $destinationPath);  // Save as PNG

            // Save 
            $products->productThumbnail = '/storage/Images/' . $fileName;
            imagedestroy($source);
            imagedestroy($resizedImage);
        }



        if ($request->hasFile('productSecond') && $request->file('productSecond')->isValid()) {
            $fileName = time() . '.' . $request->file('productSecond')->getClientOriginalExtension();
            $path = $request->file('productSecond')->storeAs('Images', $fileName, 'public');
            $products->productSecond = '/storage/' . $path;
        }

        $products->save();
        $productId = $products->id;

        $features = new Feature();
        $features->productId = $productId;
        $features->fitId = $request->input('productFit');
        $features->brandId = $request->input('productBrand');
        $features->typeId = $request->input('productType');
        $features->traction = $request->input('productTraction');
        $features->cushion = $request->input('productCushion');
        $features->material = $request->input('productMaterial');
        $features->outdoorUse = $request->input('productUse');
        $features->save();

        $sizes = $request->input('sizes', []);

        foreach ($sizes as $size => $quantity) {
            $shoeSize = new Shoesize();
            $shoeSize->productId = $productId;
            $shoeSize->size = $size;
            $shoeSize->quantity = $quantity;
            $shoeSize->save();
        }

        return redirect('addProducts');
    }




    public function editProductsPost(Request $request)
    {
        $id = $request->input('productId');  // Fetch product ID from request

        // Find the product by ID
        $edit = Product::find($id);
        if (!$edit) {
            return redirect()->back()->with('error', 'Product not found.');
        }


        $newBrandId = $request->input('productBrandd');
        $newProdType = $request->input('productType');

        $traction = $request->input('productTraction');
        $cushion = $request->input('productCushion');
        $material = $request->input('productMaterial');
        $outdoorUse = $request->input('productUse');

        if ($newBrandId) {
            Feature::where('productId', $id)->update(['brandId' => $newBrandId]);
        }
        if ($traction) {
            Feature::where('productId', $id)->update(['traction' => $traction]);
        }
        if ($cushion) {
            Feature::where('productId', $id)->update(['cushion' => $cushion]);
        }
        if ($material) {
            Feature::where('productId', $id)->update(['material' => $material]);
        }
        if ($outdoorUse) {
            Feature::where('productId', $id)->update(['outdoorUse' => $outdoorUse]);
        }
        if ($newProdType) {
            Feature::where('productId', $id)->update(['typeId' => $newProdType]);
        }


        // Check if a new thumbnail file was uploaded and update the product accordingly
        if ($request->hasFile('productSecond') && $request->file('productSecond')->isValid()) {
            $fileName = time() . '.' . $request->file('productSecond')->getClientOriginalExtension();
            $path = $request->file('productSecond')->storeAs('Images', $fileName, 'public');
            $edit->productSecond = '/storage/' . $path;
        }

        // Update the other product fields if necessary
        $edit->productCategory = $request->input('productCategory');
        $edit->productName = $request->input('productName');
        $edit->productDescription = $request->input('productDescription');
        $edit->productPrice = $request->input('productPrice');

        // Save the updated product information
        $edit->save();

        return redirect()->back()->with('success', 'Product updated successfully.');
    }



    public function manageProductsPost(Request $request)
    {

        foreach ($request->input('size') as $itemId => $quantity) {

            $existingSize = ShoeSize::find($itemId);

            if ($existingSize) {

                $existingSize->quantity = $quantity;
                $existingSize->save();
            } else {
                $newSize = new ShoeSize();
                $newSize->productId = $request->input('productId');
                $newSize->size = $itemId;
                $newSize->quantity = $quantity;
                $newSize->save();
            }
        }

        return redirect()->back()->with('success', 'Sizes updated successfully.');
    }

    public function removeProductsPost(Request $request)
    {

        $id = $request->input('productId');
        $order = Product::find($id); // Find the order by ID
        if ($order) {
            $order->delete(); // Delete the order
            return redirect()->back()->with('success', 'Product deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Product not found');
        }
    }



    public function addBrand(Request $request)
    {
        $request->validate([
            'brand.*' => 'required|string'
        ]);

        foreach ($request->input('brand') as $brandName) {
            $newBrand = new Brand();
            $newBrand->productBrand = $brandName;
            $newBrand->save();
        }

        return redirect('addProducts');
    }

    public function orderUpdate(Request $request)
    {

        $validatedData = $request->validate([
            'orderId' => 'required|array',
            'paymentStatus' => 'required|string',
            'deliveryStatus' => 'required|string',
            'orderStatus' => 'required|string',
        ]);




        foreach ($validatedData['orderId'] as $orderId) {

            $order = Order::find($orderId);

            if ($order) {
                $order->paymentStatus = $validatedData['paymentStatus'];
                $order->deliveryStatus = $validatedData['deliveryStatus'];
                $order->orderStatus = $validatedData['orderStatus'];
                $order->save();
            }
        }

        // Redirect to account page or any other intended page
        return redirect()->route('account')->with('success', 'Orders updated successfully!');
    }




    public function dropzone()
    {
        return view('dropzonetry');
    }

    public function logoutAdmin(Request $request)
    {
        if (Session::has('loginId')) {
            $request->session()->flush();
            Auth::logout();  // Logs out the user
            $request->session()->invalidate();  // Invalidates the session
            $request->session()->regenerateToken();  // Regenerates CSRF token

            redirect()->route('login');
        }

        return redirect()->route('home');
    }
}
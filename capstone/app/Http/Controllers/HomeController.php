<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Barangay;
use App\Models\Cart;
use App\Models\Credential;
use App\Models\Favorite;
use App\Models\Municipality;
use App\Models\Order;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Province;
use App\Models\Region;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function collection()
    {
        $photos = Photo::all();
        $products = Product::all();
        $userId = Session::get('user.id');
        $fav = Favorite::where('userId', $userId)->pluck('productId')->toArray();

        $addr = Address::where('userId', $userId)->first();

        return view("collection", compact('photos', 'products', 'fav', 'addr'));
    }



    public function account()
    {
        if (Session::has('loginId')) {
            $userId = Session::get('loginId');

            $regions = Region::all();
            $provinces = Province::all();
            $municipalities = Municipality::all();
            $barangays = Barangay::all();
            $address = Address::with('region')->where('userId', $userId)->get();
            $password = Credential::where('user_id', $userId)->first();
            $orders = Order::with('product')->where('userId', $userId)->get();
            $receivedOrder = Order::with('product')->where('userId', $userId)
                ->where('orderStatus', 'Received')->get()->groupBy(function ($order) {
                    return $order->created_at->format('Y-m-d H:i');
                });
            $pendingOrder = Order::with('product')->where('userId', $userId)
                ->where('orderStatus', 'Pending')->get()->groupBy(function ($order) {
                    return $order->created_at->format('Y-m-d H:i');
                });

            $orderSummary = [
                'receivedOrder' => $receivedOrder,
                'pendingOrder' => $pendingOrder,
            ];
            $fav = Favorite::where('userId', $userId)->pluck('productId')->toArray();

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
                ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at')
                ->orderBy('total_orders', 'desc')
                ->first();


            if ($topBuyer) {
                $memberSince = (new DateTime($topBuyer->created_at))->format('F d, Y');
            } else {
                $memberSince = 'N/A';
            }

            //dd($orderSummary);
            return view('account', compact('address', 'password', 'orders', 'orderSummary', 'fav', 'topBuyer', 'memberSince', 'regions', 'provinces', 'municipalities', 'barangays'));
        }



        return redirect()->route('login');
    }



    public function PutItON()
    {
        $shoes = Product::all();

        // Decode JSON in productTryIt for each shoe
        foreach ($shoes as $shoe) {
            if ($shoe->productTryIt) {
                $shoe->productTryIt = json_decode($shoe->productTryIt, true); // Decode JSON
            }
        }

        return view('tryitYourself', compact('shoes'));
    }


    public function updateAccount(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:users',
            'id' => 'required'
        ]);

        $id = $request->input('id');
        $name = $request->input('name');

        DB::table('users')->where('id', $id)->update([
            'name' => $name
        ]);

        return redirect()->back()->with('success', 'Your username has been updated!');
    }

    public function updatePassword(Request $request)
    {
        $user = Session::get('user');

        $currentPassword = $request->input('current');
        $newPassword = $request->input('newPass');
        $confirmPassword = $request->input('newPassConfirmation');

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'New password and confirm password do not match.');
        }
        $credentials = User::where('id', $user->id)->first();

        if (!Hash::check($currentPassword, $credentials->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }
        $credentials->password = Hash::make($newPassword);
        $credentials->save();


        $credentialss = new Credential();
        $credentialss->user_id = Session::get('loginId');
        $credentialss->password = Hash::make($newPassword);
        $credentialss->save();


        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function updateAddress(Request $request)
    {

        $request->validate([
            'address' => 'required'
        ]);

        $name = $request->input('name');
        $email = $request->input('address');

        DB::table('users')->where('name', $name)->update([
            'address' => $email
        ]);

        return redirect()->back()->with('success', 'Your address has been updated');
    }


    public function add(Request $request)
    {

        //dd($request);
        $address = Address::create([
            'userId' => Session::get('user.id'),
            'name' => $request->input('name'),
            'contact' => $request->input('contact'),
            'details' => $request->input('details'),
            'region_id' => $request->input('region'),
            'province_id' => $request->input('province'),
            'municipality_id' => $request->input('municipality'),
            'barangay_id' => $request->input('barangay')
        ]);

        return redirect()->route('account')->with('success', 'Address added successfully');
    }

    public function favorites(Request $request)
    {
        $userId = Session::get('user.id');
        $productId = $request->input('productId');

        $existingFavorite = Favorite::where('userId', $userId)
            ->where('productId', $productId)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            return redirect('collection')->with('success', 'Product removed from favorites.');
        } else {
            $fav = new Favorite();
            $fav->userId = $userId;
            $fav->productId = $productId;
            $fav->save();

            return redirect('collection')->with('success', 'Product added to favorites.');
        }
    }

    public function getProvinces($regionId)
    {
        $provinces = DB::table('table_province')
            ->where('region_id', $regionId)
            ->get(['province_id', 'province_name']); // Adjust field names as needed

        return response()->json($provinces);
    }

    public function getMunicipalities($provinceId)
    {
        // Fetch municipalities based on provinceId
        $municipalities = DB::table('table_municipality')
            ->where('province_id', $provinceId)
            ->get(['municipality_id', 'municipality_name']); // Adjust field names as needed

        return response()->json($municipalities); // Return municipalities as JSON response
    }


    public function getBarangays($municipalityId)
    {
        // Fetch barangays based on municipalityId
        $barangays = DB::table('table_barangay')
            ->where('municipality_id', $municipalityId)
            ->get(['barangay_id', 'barangay_name']); // Adjust field names as needed

        return response()->json($barangays); // Return barangays as JSON response
    }
}

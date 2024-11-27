<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CustomAuthMiddleware;
use App\Models\Cart;
use App\Models\Credential;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function home()
    {
        $products = Product::all();
        Log::info("Home");


        return view('home', compact('products'));
    }

    public function register()
    {
        return view('register');
    }

    public function registerpost(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'security_question' => 'required|string',
            'security_answer' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // Save the new user
        $newUser = new User();
        $newUser->name = $request->input('username');
        $newUser->email = $request->input('email');
        $newUser->password = Hash::make($request->input('password'));
        $newUser->security_question = $request->input('security_question');
        $newUser->security_answer = $request->input('security_answer');

        if ($request->hasFile('productSecond') && $request->file('productSecond')->isValid()) {
            $fileName = time() . '.' . $request->file('productSecond')->getClientOriginalExtension();
            $path = $request->file('productSecond')->storeAs('Images', $fileName, 'public');
            $newUser->validationCard = '/storage/' . $path;
        }

        $newUser->save();

        // Save the credentials
        $credentials = new Credential();
        $credentials->user_id = $newUser->id;
        $credentials->password = Hash::make($request->input('password'));
        $credentials->save();

        return redirect('login');
    }

    public function loginPost(Request $request)
    {
        $middleware = new CustomAuthMiddleware();


        $response = $middleware->handle($request, function ($request) {
            Log::info("Nakapasok");
            return redirect()->route('home');
        });
        //dd($response);

        //return back()->withErrors(['password' => 'Invalid credentials.']);


        //dd("HELLO3");
        $user = $request->session()->get('user');
        //dd($user);
        if ($user && $user->user_type === 1) {
            return redirect()->route('admin.home');
        }

        return $response;
    }

    public function logout(Request $request)
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

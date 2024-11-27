<?php

namespace App\Http\Middleware;

use App\Models\Credential;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!Session::has('loginId')) {

        Log::info("Start");
        Log::info('Current route: ' . $request->path());
        Log::info("Authenticated? " . Auth::check());
        # Auth::check() same lang sya sa viaremember
        if (Auth::check()) {
            Log::info("Authenticated already in");
            $user = $request->session()->get('user');
            if ($user) {
                Log::info($user);
                if ($user && $user->user_type === 1) {
                    return redirect()->route('admin.home')->with('error', 'You do not have access to this page.');
                }
            } else {
                Log::info("Via remember");
                $user = User::where('id', Auth::id())->first();
                Session()->put('user', $user);
                Session()->put('loginId', $user->id);
            }


            return $next($request);
        } else {
            $name = $request->input('name');
            $password = $request->input('password');
            $user = User::where('name', $name)->first();
            $remember = $request->has('remember');  // If the checkbox is checked, remember will be true
            Log::info($name);
            Log::info($user);
            if ($user) {
                if (Auth::attempt(['name' => $name, 'password' => $password], $remember)) {
                    // The user is being remembered...
                    Log::info("Logged in");
                    $request->session()->put('user', $user);
                    $request->session()->put('loginId', $user->id);

                    return $next($request);
                } else {
                    // Authentication failed
                    return back()->withErrors(['password' => 'Invalid password.']);
                }
            } else {
                return redirect('/login')->with('error', 'Invalid credentials.');
            }
        }
    }
}

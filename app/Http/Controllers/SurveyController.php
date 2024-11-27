<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Fit;
use App\Models\Preference;
use App\Models\Product;
use App\Models\ShoeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Import the HTTP facade
use Illuminate\Support\Facades\Log;

class SurveyController extends Controller
{
    public function showSurveyForm()
    {
        $categories = Product::select('productCategory')->distinct()->get();
        $shoeTypes = ShoeType::all();
        $fits = Fit::all();
        $brands = Brand::all();

        return view('survey', compact('categories', 'shoeTypes', 'fits', 'brands'));
    }

    public function handleSurvey(Request $request)
    {
        // Validation
        $request->validate([
            'shoe_category' => 'required',
            'shoe_type' => 'required',
            'fit' => 'required',
            'outdoor_use' => 'required|boolean',
            'brand' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        // Save the survey answers in the 'preferences' table
        $preference = new Preference();
        $preference->q1 = $request->shoe_category;
        $preference->q2 = (int) $request->shoe_type; // FK to shoe_types
        $preference->q3 = (int) $request->fit;        // FK to fits
        $preference->q4 = $request->outdoor_use == '1' ? 'Yes' : 'No';
        $preference->q5 = $request->brand;      // Store the brand ID (integer)
        $preference->q6 = $request->price;
        $preference->save();
        


        // Convert 'outdoor_use' from '1'/'0' to boolean true/false
        $outdoorUse = $request->outdoor_use == '1' ? true : false;

        // Prepare the data to be sent to Spring Boot
        $data = [
            'category' => $request->shoe_category,
            'type' => (int) $request->shoe_type, // Cast to integer
            'fit' => (int) $request->fit, // Cast to integer
            'outdoorUse' => $outdoorUse,
            'brand' => $request->brand,
            'price' => $request->price,
        ];

        // Send a POST request to the Spring Boot API
        $response = Http::post('http://46.202.128.242:8080/api/recommendations', $data); // Adjust the URL as needed

        // Check for successful response
        if ($response->successful()) {
            $recommendedShoes = $response->json(); // Get the response data as an array
        } else {
            // Handle the error case
            $recommendedShoes = [];
        }

        return view('recommendations', compact('recommendedShoes'));
    } 
}

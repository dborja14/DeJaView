<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DropzoneController extends Controller
{
    public function index($id)
    {
        $product = Product::findOrFail($id);
        $photos = Photo::where('productId',  $product->id)->get();
        return view('dropzoneTry', compact('product', 'photos'));
    }

    public function fit($id)
    {
        $product = Product::findOrFail($id);
        $photos = Photo::where('productId',  $product->id)->get();
        return view('fitBlade', compact('product', 'photos'));
    }

    public function uploadImages(Request $request)
    {
        // Validate that each file is an image
        $request->validate([
            'file' => 'required|array', // Ensure 'file' is an array of images
            'file.*' => 'image', // Ensure each file is an image
            'productId' => 'required|exists:products,id', // Validate product ID
        ]);

        // Store each file and save its path and productId in the database
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {
                // Get the product ID and original file name
                $productId = $request->input('productId');
                $originalName = $image->getClientOriginalName();

                // Create a new file name with the product ID
                $name = $productId . '-' . $originalName;

                // Store the file in the 'public/uploads' folder
                $path = $image->storeAs('public/uploads', $name);

                // Save image path and productId to the database
                Photo::create([
                    'image' => str_replace('public/', '', $path),
                    'productId' => $productId, // Save the product ID
                ]);
            }
        }

        return response()->json(['success' => 'Images uploaded successfully']);
    }

    public function saveDimensions(Request $request)
    {
        $request->validate([
            'dimensions' => 'required|string',
            'shoe_id' => 'required|integer',
            'top' => 'required|numeric',
            'left' => 'required|numeric',
        ]);

        // Extract width and height percentages from the dimensions string (e.g., "22.5x40.3")
        [$widthPercent, $heightPercent] = explode('x', $request->input('dimensions'));
        $widthPercent = (float)$widthPercent;
        $heightPercent = (float)$heightPercent;

        // Get top and left percentages
        $topPercent = (float)$request->input('top');
        $leftPercent = (float)$request->input('left');

        // Find the product by ID
        $shoe = Product::find($request->input('shoe_id'));

        if ($shoe && $shoe->productThumbnail) {
            $shoe->productTryIt = json_encode([
                'width' => $widthPercent,
                'height' => $heightPercent,
                'top' => $topPercent,
                'left' => $leftPercent,
            ]);

            // Save the updated dimensions as percentages
            $shoe->save();

            return back()->with('success', 'Dimensions and image saved successfully as percentages!');
        }

        return back()->with('error', 'Shoe or image not found.');
    }
}

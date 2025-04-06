<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RentedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RentController extends Controller
{
    public function return(Request $request, RentedProduct $rentedProduct)
    {
        if ($rentedProduct->return_date) {
            return redirect()->route('home')
                ->with('error', 'This product has already been returned.');
        }

        if ($rentedProduct->user_id != auth()->id()) {
            return redirect()->route('home')
                ->with('error', 'You are not authorized to return this product.');
        }

        return view('return', [
            'rentedProduct' => $rentedProduct,
        ]);
    }

    public function storeReturn(Request $request, RentedProduct $rentedProduct)
    {
        $request->validate([
            'condition' => 'required|in:excellent,good,fair,poor',
            'scratches' => 'required|in:none,minor,major',
            'functionality' => 'required|in:yes,partially,no',
            'cleanliness' => 'required|in:clean,dirty',
            'product_image' => 'required|image|max:2048',
        ]);

        $condition = $request->input('condition');
        $scratches = $request->input('scratches');
        $functionality = $request->input('functionality');
        $cleanliness = $request->input('cleanliness');

        // Base wear percentage on condition
        $wearPercentage = match ($condition) {
            'excellent' => 5,
            'good' => 15,
            'fair' => 30,
            'poor' => 50,
            default => 0,
        };

        // Adjust wear percentage based on additional inputs
        $wearPercentage += match ($scratches) {
            'minor' => 10,
            'major' => 20,
            default => 0,
        };

        $wearPercentage += match ($functionality) {
            'partially' => 15,
            'no' => 30,
            default => 0,
        };

        $wearPercentage += match ($cleanliness) {
            'dirty' => 10,
            default => 0,
        };

        // Ensure wear percentage does not exceed 100%
        $wearPercentage = min(100, $wearPercentage);

        if ($request->hasFile('product_image')) {
            $path = $request->file('product_image')->storeAs('product_images', Str::uuid() . '.' . $request->file('product_image')->getClientOriginalExtension(), 'local');
            $rentedProduct->update(['product_image_path' => $path]);
        }

        $rentedProduct->update([
            'return_date' => now(),
            'return_wear_state' => $wearPercentage,
        ]);

        return redirect()->route('home')
            ->with('success', 'Product returned successfully.');
    }
}

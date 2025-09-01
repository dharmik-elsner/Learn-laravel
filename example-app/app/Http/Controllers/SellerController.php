<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'Seller') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function formtoaddwebsite()
    {
        return view('addwebsite');
    }

    public function saveWebsite(Request $request)
    {
        // Validate and process the request data
        $validated = $request->validate([
            'website_name' => 'required|url',
            'da_score' => 'required|integer|between:1,100',
            'publishing_time' => 'required|integer|min:1',
            'example_website_name' => 'required|url',
            'category' => 'required|array',
            'normal_guest' => 'nullable|integer|min:1',
            'normal_link' => 'nullable|integer|min:1',
            'fc_guest' => 'nullable|integer|min:1',
            'fc_link' => 'nullable|integer|min:1',
        ]);
        

        // Process the validated data (e.g., save to the database)

        return redirect()->route('home')->with('success', 'Website added successfully.');
    }

}

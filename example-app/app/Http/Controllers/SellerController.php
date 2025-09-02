<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sellerWebsiteData;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if(!$user){
                return redirect()->route('login');
            }

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
        if($request->input('bool')){
            $website = sellerWebsiteData::where('id', $request->input('id'))->first();
            $website->da_score = $request->input('da_score');
            $website->publishing_time = $request->input('publishing_time');
            $website->example_website_name = $request->input('example_website_name');
            $website->category = $request->input('category');
            $website->normal_guest_price = $request->input('normal_guest');
            $website->normal_link_price = $request->input('normal_link');
            $website->fc_guest_price = $request->input('fc_guest');
            $website->fc_link_price = $request->input('fc_link');
            $website->save();
            return redirect()->route('view.websites')->with('success', 'Website updated successfully.');

        }
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
        
        $userId = auth()->id();

        sellerWebsiteData::create([
            'user_id' => $userId,
            'website_name' => $validated['website_name'],
            'da_score' => $validated['da_score'],
            'publishing_time' => $validated['publishing_time'],
            'example_website_name' => $validated['example_website_name'],
            'category' => $validated['category'],
            'normal_guest_price' => $validated['normal_guest'],
            'normal_link_price' => $validated['normal_link'],
            'fc_guest_price' => $validated['fc_guest'],
            'fc_link_price' => $validated['fc_link'],
        ]);

        if($request->input('bool')){
            return redirect()->route('view.websites')->with('success', 'Website updated successfully.');
        }
        return redirect()->route('view.websites')->with('success', 'Website added successfully.');
    }

    public function viewWebsites()
    {
        $userId = auth()->id();
        $websites = sellerWebsiteData::where('user_id', $userId)->whereNull('deleted_at')->get();
        return view('view_data_seller', compact('websites'));
    }


    public function edit($id)
    {
        $website = sellerWebsiteData::find($id);

        if (!$website) {
            return redirect()->route('view.websites')->with('error', 'Website not found.');
        }
        return view('addwebsite', compact('website'));
    }

    public function destroy($id)
    {
        $website = sellerWebsiteData::find($id);

        if (!$website) {
            return redirect()->route('view.websites')->with('error', 'Website not found.');
        }
        $website->deleted_at = now();
        $website->save();
        return redirect()->route('view.websites')->with('success', 'Website deleted successfully.');
    }

}

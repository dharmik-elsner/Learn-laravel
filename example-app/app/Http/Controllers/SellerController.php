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
            if ($website->deleted_at) {
                return redirect()->route('seller.index')->with('error', 'Website not found.');
            }

            if (!empty($website)) {
                $website->da_score = $request->input('da_score');
                $website->publishing_time = $request->input('publishing_time');
                $website->example_website_name = $request->input('example_website_name');
                $website->category = $request->input('category');
                $website->normal_guest_price = $request->input('normal_guest');
                $website->normal_link_price = $request->input('normal_link');
                $website->fc_guest_price = $request->input('fc_guest');
                $website->fc_link_price = $request->input('fc_link');
                $website->save();
                return redirect()->route('seller.index')->with('success', 'Website updated successfully.');
            }

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

        $action = $request->input('bool') ? "updated" : "added";

        return redirect()->route('seller.index')->with('success', 'Website ' . $action . ' successfully.');
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

    public function sellerData(Request $request)
    {
        $userId = auth()->id();
        $websites = sellerWebsiteData::where('user_id', $userId)->whereNull('deleted_at');


        //below code is for sorting it handle sorting according to column
        if($request->has('order')){
            if($request->order[0]['column']==0){
                $websites = $websites->orderBy('website_name', $request->order[0]['dir']);
            }
            if($request->order[0]['column']==1){
                $websites = $websites->orderBy('da_score', $request->order[0]['dir']);
            }
            if($request->order[0]['column']==2){
                $websites = $websites->orderBy('publishing_time', $request->order[0]['dir']);
            }
            if($request->order[0]['column']==3){
                $websites = $websites->orderBy('example_website_name', $request->order[0]['dir']);
            }
            if($request->order[0]['column']==4){
                $websites = $websites;
            }  
            if($request->order[0]['column']==5){
                $websites = $websites->orderBy('normal_guest_price', $request->order[0]['dir']);
            }
            if($request->order[0]['column']==6){
                $websites = $websites->orderBy('normal_link_price', $request->order[0]['dir']);
            }
            if($request->order[0]['column']==7){
                $websites = $websites->orderBy('fc_guest_price', $request->order[0]['dir']);
            }
            if($request->order[0]['column']==8){
                $websites = $websites->orderBy('fc_link_price', $request->order[0]['dir']);
            }
        }

        //below code is for searching it handle searching accross the table excluding action column
        if($request->has('search') && $request->search['value'] != ''){
            $search = $request->search['value'];
            $websites = $websites->where(function($query) use ($search) {
                $query->where('website_name', 'like', "%{$search}%")
                      ->orWhere('da_score', 'like', "%{$search}%")
                      ->orWhere('publishing_time', 'like', "%{$search}%")
                      ->orWhere('example_website_name', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%")
                      ->orWhere('normal_guest_price', 'like', "%{$search}%")
                      ->orWhere('normal_link_price', 'like', "%{$search}%")
                      ->orWhere('fc_guest_price', 'like', "%{$search}%")
                      ->orWhere('fc_link_price', 'like', "%{$search}%");
            });
        }


        $websites= $websites->get();
        $start = $request->get('start');
        $length = $request->get('length');
        $totalRecords = $websites->count();
        $returndata = $websites->skip($start)->take($length)->values();

        // Prepare the response in DataTables format which requires JSON
        return  response()->json([
            'draw' => intval($request->get('draw')), // return back to DataTables (required)
            'recordsTotal' => $totalRecords,           // total records in DB
            'recordsFiltered' => $totalRecords,        // same unless you add search
            'data' => $returndata->map(function ($website) {
                $delete = '<a href="' . route('website.delete', $website->id) . '" class="btn btn-danger" style="color: white;">Delete</a>';
                $update = '<a href="' . route('editData', $website->id) . '" class="btn btn-warning" style="color: white; margin: 0px 0px 2px 0px;">Update</a>';
                // Add other fields as needed for DataTables
                return [
                    'website_name' => '<a href="' . $website->website_name . '" target="_blank">' . $website->website_name . '</a>',
                    'example_website_name' => '<a href="' . $website->example_website_name . '" target="_blank">' . $website->example_website_name . '</a>',
                    'da_score' => $website->da_score,
                    'publishing_time' => $website->publishing_time,
                    'category' => is_array($website->category) ? implode(', ', $website->category) : $website->category,
                    'normal_guest_price' => $website->normal_guest_price ?? '--',
                    'normal_link_price' => $website->normal_link_price ?? '--',
                    'fc_guest_price' => $website->fc_guest_price ?? '--',
                    'fc_link_price' => $website->fc_link_price ?? '--',
                    'action' => $update . "  " . $delete,
                ];
            })->toArray(), //send data with action
        ]);
        
        
        
        // datatables()->of($returndata)
        //     ->setTotalRecords($totalRecords)
        //     ->addColumn('website_name', function ($website) {
        //         $txt = $website->website_name;
        //         return '<a href="' . $website->website_name . '" target="_blank">' . $txt . '</a>';
        //     })
        //     ->addColumn('action', function ($website) {
        //         $delete = '<a href="' . route('website.delete', $website->id) . '" class="btn btn-danger" style="color: white;">Delete</a>';

        //         $update = '<a href="' . route('editData', $website->id) . '" class="btn btn-warning" style="color: white; margin: 0px 0px 2px 0px;">Update</a>';

        //         return $update . "  " .$delete;
        //     })
        //     ->addColumn('example_website_name', function ($website) {
        //         $txt = $website->example_website_name;
        //         return '<a href="' . $website->example_website_name . '" target="_blank">' . $txt . '</a>';
        //     })
        //     ->addColumn('normal_guest_price', function ($website) {
        //         if ($website->normal_guest_price === null) {
        //             return '--';
        //         }
        //         return $website->normal_guest_price;
        //     })
        //     ->addColumn('normal_link_price', function ($website) {
        //         if ($website->normal_link_price === null) {
        //             return '--';
        //         }
        //         return $website->normal_link_price;
        //     })
        //     ->addColumn('fc_guest_price', function ($website) {
        //         if ($website->fc_guest_price === null) {
        //             return '--';
        //         }
        //         return $website->fc_guest_price;
        //     })
        //     ->addColumn('fc_link_price', function ($website) {
        //         if ($website->fc_link_price === null) {
        //             return '--';
        //         }
        //         return $website->fc_link_price;
        //     })
        //     ->rawColumns(['website_name', 'action', 'example_website_name', 'normal_guest_price', 'normal_link_price', 'fc_guest_price', 'fc_link_price'])
        //     ->make(true);
    }
    
    public function delete($id){
        $website = sellerWebsiteData::find($id);

        if (!$website) {
            return redirect()->route('seller.index')->with('error', 'Website not found.');
        }

        $website->deleted_at = now();
        $website->save();

        return redirect()->route('seller.index')->with('success', 'Website deleted successfully.');
    }

    public function editData($id){
        $website = sellerWebsiteData::find($id);
        
        if ($website->deleted_at) {
            return redirect()->route('seller.index')->with('error', 'Website not found.');
        }

        if (!$website) {
            return redirect()->route('seller.index')->with('error', 'Website not found.');
        }
        return view('addwebsite', compact('website'));
    }


}

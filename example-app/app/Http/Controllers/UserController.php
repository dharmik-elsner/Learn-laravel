<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'Admin') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function viewUsers()
    {
        $data = User::where('role', '!=', 'Admin')->get();
        return view('view_data_admin', ['data' => $data]);
    }


    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('view.users')->with('error', 'User not found.');
        }
        if ($user->role === 'Admin') {
            return redirect()->route('view.users')->with('error', 'Cannot delete Admin users.');
        }
        User::findOrFail($id)->delete();
        return redirect()->route('view.users')->with('success', 'User deleted successfully.');
    }

    public function updatePage($id)
    {

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('view.users')->with('error', 'User not found.');
        }

        return view('update', ['data' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) {
            return redirect()->route('view.users')->with('error', 'User not found.');
        }
        
        $user->update($request->all());
        return redirect()->route('view.users')->with('success', 'User updated successfully.');
    }

}

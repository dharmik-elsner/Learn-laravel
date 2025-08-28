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
       $this->middleware('auth');
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
            return redirect()->route('home')->with('error', 'User not found.');
        }
        if ($user->role === 'Admin') {
            return redirect()->route('home')->with('error', 'Cannot delete Admin users.');
        }
        User::findOrFail($id)->delete();
        return redirect()->route('home')->with('success', 'User deleted successfully.');
    }

    public function updatePage($id)
    {

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('home')->with('error', 'User not found.');
        }

        return view('update', ['data' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) {
            return redirect()->route('home')->with('error', 'User not found.');
        }
        
        $user->update($request->all());
        return redirect()->route('home')->with('success', 'User updated successfully.');
    }

}

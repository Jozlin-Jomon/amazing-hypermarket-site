<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{

    /*
    View Users List
    Created On: 07-05-2025
    */
    public function index(Request $request){

        $query = User::query();

        //search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['1', '0'])) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('admin.user.partials.table', compact('users'))->render();
        }

        return view('admin.user.index',compact('users'));
    }

    /*
    Update: User status
    Created On: 08-05-2025
    */
    public function updateStatus(Request $request, User $user){
        $validated = $request->validate([
            'status' => 'required|in:0,1',
        ]);
        try{
            $user->status = $validated['status'];
            $user->save();
            return redirect()->back()->with('success', 'User status updated successfully.');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user status.');
        }
        
    }

    /*
    Delete: User
    Created On: 08-05-2025
    */
    public function destroy($userId){
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['success' => 'User removed successfully']);
    }

    /*
    Bulk Delete: User
    Created On: 09-05-2025
    */
    public function bulkDelete(Request $request)
    {
        $userIds = $request->input('userIds');
        if (is_array($userIds) && !empty($userIds)) {
            User::whereIn('id', $userIds)->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    /*
    Update: User
    Created On: 14-05-2025
    */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'phone'         => 'nullable|string|max:20',
        ]);

        $user->update([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'phone'         => $request->phone,
        ]);

        return response()->json(['message' => 'User updated successfully.']);
    }


}
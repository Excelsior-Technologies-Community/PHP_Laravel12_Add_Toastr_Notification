<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        $analytics = [
            'total' => User::count(),
            'active' => User::where('status', 1)->count(),
            'inactive' => User::where('status', 0)->count(),
            'trashed' => User::onlyTrashed()->count(),
        ];

        if ($request->filled('search')) {
            $search = $request->search;

            if (strtolower($search) == 'active') {
                $query->where('status', 1);
            } elseif (strtolower($search) == 'inactive') {
                $query->where('status', 0);
            } else {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }
        }

        $users = $query->paginate(10);
        $trashedUsers = User::onlyTrashed()->get();

        return view('users.index', compact('users', 'trashedUsers', 'analytics'));
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully!');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User moved to trash!');
    }

    public function restore($id)
    {
        User::withTrashed()->findOrFail($id)->restore();

        return redirect()->back()->with('success', 'User restored successfully!');
    }

    public function forceDelete($id)
    {
        User::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->back()->with('success', 'User permanently deleted!');
    }

    public function exportCsv()
    {
        $users = User::all();
        $filename = "users.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Name', 'Email', 'Status']);

        foreach ($users as $user) {
            fputcsv($handle, [$user->id, $user->name, $user->email, $user->status ? 'Active' : 'Inactive']);
        }

        fclose($handle);
        return Response::download($filename);
    }
}
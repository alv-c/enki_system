<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\AccountApproved;

class UserApprovalController extends Controller
{
    public function index()
    {
        $users = User::where('is_approved', false)->get();
        return view('admin.user-approvals.index', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();
        $user->notify(new AccountApproved());
        return redirect()->route('admin.user-approvals.index')
            ->with('success', 'Usuário aprovado com sucesso!');
    }
}

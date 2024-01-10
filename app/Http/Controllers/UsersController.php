<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function doResetPassword(User $user)
    {
        $user->update([
            'password' => bcrypt('siswabaru1122')
        ]);

        return redirect()->back()->with('success', 'Password telah diubah menjadi <strong>siswabaru1122</strong>');
    }
}

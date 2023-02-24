<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function notAuth(Request $request){
        return response()->json([
            'status' => 'fails',
            'redirect' => true,
            'user' => [
                'name' => $request->user()->name,
                'role' => $request->user()->role->name,
                'all' => $request->user(),
            ]
        ]);
    }
}

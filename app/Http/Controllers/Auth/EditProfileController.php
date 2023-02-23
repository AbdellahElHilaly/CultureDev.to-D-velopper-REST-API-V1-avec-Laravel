<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class EditProfileController extends Controller
{
  
   public function __construct(){
    
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    
   }
   

      public function edit() {
       $id = Auth::user()->id;
      $user = User::find($id);
      if(!$user){
         return response()->json([
           'message'=>'profile not found ', 
         ]); 
      }
              
       return response()->json([
         'status'=> 'true',
        'name'=> $user->name,
         'email' =>$user->email,
       ]);

      }

      public function update(Request $request){
        $id = Auth::user()->id;
        $user = User::find($id); 

      $request->validate([
        'name' => 'required',
        'email' => 'required',
        'old_password' => 'required',
        'password'=>'required|confirmed',
      ]);
       //  #Match The Old Password
       if(!Hash::check($request->old_password, $user->password)){
        return  response()->json([
          'messsage'=> 'old password Doesn"t match!',
        ]);
    }

      $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'updated_at' => now(),
    ]);

    return response()->json([
      'status'=>'true',
      'updated'=>$user,

    ]);
}
}
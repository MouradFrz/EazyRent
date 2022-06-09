<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminBan;
use App\Models\AgencyBan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
  function check(Request $request)
  {
    //validation
    $request->validate(
      [
        'username' => 'required|exists:admins,username',
        'password' => 'required'
      ],
      [
        'username.exists' => 'This username does not exist.'
      ]
    );
    $creds = $request->only('username', 'password');

    if (Auth::guard('admin')->attempt($creds)) {
      return redirect()->route('admin.dashboard');
    } else {
      return redirect()->route('admin.login')->with('fail', 'The credentials you entered are wrong');
    }
  }
  public function logout()
  {
    session()->flush();
    Auth::guard('admin')->logout();
    return redirect()->route('admin.login');
  }
  public function loadBans(){
    $bans=AgencyBan::join('users','agencybans.bannedClient','=','users.username')
    ->whereNotIn('users.username', AdminBan::get(['bannedUsername'])->toArray())
    ->latest('startDate')->paginate(25);

    $appbans=AdminBan::join('users','adminbans.bannedUsername','=','users.username')->latest('adminbans.created_at')->paginate(25);
    return view('admin.bansManagement',['bans'=>$bans,'appbans'=>$appbans]);
  }
  public function banUser(Request $request){
    $request->validate(['reason'=>'required']);
    $ban = new AdminBan();
    $ban->bannedBy=Auth::user()->username;
    $ban->bannedUsername=$request->username;
    $ban->reason=$request->reason;
    $ban->created_at=now();

    $ban->save();

    return redirect()->route('admin.loadBans')->with('message','User banned successfully');
  }
  public function unbanUser(Request $request){
    AdminBan::where('bannedUsername',$request->username)->first()->delete();
    return redirect()->route('admin.loadBans')->with('message','User unbanned successfully');
  }

}

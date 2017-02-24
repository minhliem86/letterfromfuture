<?php namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;
use Validator;

class AdminController extends Controller {
	
	public function index()
	{
		return view('Admin::pages.dashboard.index');
	}

	public function getChangePass(){
		return view('Admin::auth.changepass');
	}

	public function postChangePass(Request $request){
		$oldpass = $request->input('oldpassword');
		if(Hash::check($oldpass, Auth::user()->password)){
			$validator = Validator::make($request->all(),[
				'newpassword' => 'required|confirmed|min:6',
			]);
			if($validator->fails()){
				return redirect()->back()->withErrors('Not match New Password!');
			}else{
				$user = Auth::user();
				$user->password = Hash::make($request->input('newpassword'));
				$user->save();
				Auth::logout();
				return redirect()->route('admin.getlogin');
			}
		}else{
			return redirect()->back()->withErrors('Wrong password!');
		}
	}
	
}
<?php namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Hash;
use Auth;
use Validator;
use Notification;


class AdminController extends Controller {

	protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
//           'password' => 'required|min:6|confirmed',
						'password' => 'required|min:3|confirmed',
						'password_confirmation' => 'required|min:3',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

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

	public function getUser(){
		$id = Auth::user()->id;
		$data_teacher = User::with(['roles'=>function($query){
			$query->where('name','teacher');
		}])->whereNotIn('id',[$id])->get();
		return view('Admin::pages.user.index',compact('data_teacher'));
	}

	public function getCreateUser(){
		return view('Admin::pages.user.create');
	}

	public function postCreateUser(Request $request){
		$valid = $this->validator($request->all());
		if($valid->fails()){
			$this->throwValidationException(
				$request
			);
		}

		$user = $this->create($request->all());

		$role = Role::where('name',$request->role)->first();
		if($role){
			$user->attachRole($role);
		}else{
			return redirect()->back()->withInput()->withErrors('error','Do not have Role');
		}
		Notification::success('User Created');
		return redirect()->route('admin');
	}

	public function deleteUser($id){
		User::destroy($id);
		return redirect()->back();
	}

}

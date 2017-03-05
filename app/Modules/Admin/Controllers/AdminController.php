<?php namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;
use Validator;

use App\Models\Permission;
use App\Models\Role;

class AdminController extends Controller {

	protected function create(array $data)
	{
			return App\Models\User::create([
					'name' => $data['name'],
					'email' => $data['email'],
					'password' => bcrypt($data['password']),
			]);
	}
	protected function validator(array $data)
  {
      return Validator::make($data, [
          'name' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users',
					'password' => 'required|min:3|confirmed',
					'password_confirmation' => 'required|min:3',
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

	public function getCreateUser(){
		return view('Admin::pages.user.create');
	}

	public function postCreateUser(Request $request){
		$validator = $this->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}
		$user = $this->registrar->create($request->all());
		$data_role = $request->input('role');

		$permission = new Permission();
		$permission->name = 'can_login';
		$permission->display_name = 'Login Permission';
		$permission->description = 'Can login CMS';
		$permission->save();

		$role = new Role();

		switch ($data_role) {
			case 'admin':
				$role->name = $data_role;
				$role->display_name = 'Administrator';
				break;

			default:
				$role->name = $data_role;
				$role->display_name = 'Teacher ';
				break;
		}

		$role->save();

		$role->attachPermission($permission);

		$user->attachRole($role);

		$this->auth->login($user);

		return redirect()->route('admin');
	}

}

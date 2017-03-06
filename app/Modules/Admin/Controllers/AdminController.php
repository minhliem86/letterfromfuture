<?php namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;
use Validator;

use App\Models\Permission;
use App\Models\Role;
use Notification;

use App\Repositories\Admin\TeacherRepositoryInterface;

class AdminController extends Controller {

	public $user_instance;

	public function __construct(TeacherRepositoryInterface $user_instance){
		$this->user_instance = $user_instance;
	}


	protected function create(array $data)
	{
			return User::create([
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
		$user = $this->create($request->all());
		$data_role = $request->input('role');

		$permission = Permission::where('name','can_login')->first();

		$role = Role::where('name',$data_role)->first();

		$user->attachRole($role);

		// $this->auth->login($user);
		Notification::success('New User is created !!!');
		return redirect()->route('admin.getTeacher');
	}

	public function getTeacher(){
		$data_teacher = $this->user_instance->getUserRole('teacher');
		return view('Admin::pages.user.index',compact('data_teacher'));

	}

 public function postDeleteTeacher($id){
	 $this->user_instance->deleteUserRole($id);
	 Notification::success('User is removed !!!');
	 return redirect()->back();
 }


}

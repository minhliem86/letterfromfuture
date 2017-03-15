<?php namespace App\Modules\Admin\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Notification;


class RoleController extends Controller {

	public function create()
  {
    return view('Admin::pages.role.create');
  }

  public function store(Request $request)
  {
    $data = ['name'=>$request->name,'display_name'=>\Unicode::make($request->name),'description'=>$request->description];

    $role = Role::create($data);
    $canlogin = Permission::find(1);
    $role->attachPermission($canlogin);
    Notification::success('Role Created !');
    return redirect()->route('admin.role.create');
  }



}

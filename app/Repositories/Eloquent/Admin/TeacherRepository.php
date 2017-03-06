<?php
namespace App\Repositories\Eloquent\Admin;

use App\Repositories\Admin\TeacherRepositoryInterface;
use App\Models\User;

class TeacherRepository implements TeacherRepositoryInterface{
  protected $user;

  public function __construct(User $user){
    $this->user = $user;
  }

  public function getUserRole($data){
    return $this->user->whereHas('role_user',function($q) use ($data){
      $q->where('name',$data);
    })->get();
  }

  public function deleteUserRole($id){
    $this->user->destroy($id);
  }
}

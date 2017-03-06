<?php
namespace App\Repositories\Admin;;

interface TeacherRepositoryInterface{
  public function getUserRole($data);

  public function deleteUserRole($id);
}

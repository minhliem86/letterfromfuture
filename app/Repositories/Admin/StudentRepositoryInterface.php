<?php
namespace App\Repositories\Admin;;

interface StudentRepositoryInterface{
  public function getTop50();

  public function getDetailPost($id);
}

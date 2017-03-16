<?php
namespace App\Repositories\Admin;;

interface StudentRepositoryInterface{
  public function getTop50();

  public function getListStudent();

  public function getDetailStudent($id);

  public function updateVoteStudent($id,$data);

  


}

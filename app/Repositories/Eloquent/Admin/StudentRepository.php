<?php
namespace App\Repositories\Eloquent\Admin;

use App\Repositories\Admin\StudentRepositoryInterface;
use App\Models\Student;

class StudentRepository implements StudentRepositoryInterface{
  protected $student;

  public function __construct(Student $student){
    $this->student = $student;
  }

  public function getTop50(){
    return $this->student->where('joined',1)->orderBy('vote','DESC')->get();
  }

  public function getDetailPost($id){
    return $this->student->with('votes')->find($id);
  }


}

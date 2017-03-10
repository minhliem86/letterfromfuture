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

  public function getListStudent(){
    return $this->student->select('id','name','fb_link','fb_img','vote')->where('joined','1')->orderBy('updated_at','DESC')->get();
  }

  public function getDetailStudent($id){
    return $this->student->select('id','name','fb_link','fb_img','vote','letter_content','letter_quote')->find($id);
  }

  public function updateVoteStudent($id,$data){
    $update = $this->student->find($id);
    $update->update($data);
  }


}

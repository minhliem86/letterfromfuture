<?php
namespace App\Repositories\Eloquent\Frontend;

use App\Repositories\Frontend\StudentRepositoryInterface;
use App\Models\Student;

class StudentRepository implements StudentRepositoryInterface{

	protected $student;

	public function __construct(Student $student){
		$this->student = $student;
	}

	public function updateAccount($filter,$data)
	{
		return $this->student->where('student_account',$filter)->update($data);
	}

	public function getStudent($filter){
		return $this->student->where('student_account',$filter)->select('name','student_account','fb_img','fb_name','img_upload','letter_content','letter_quote')->first();
	}
}

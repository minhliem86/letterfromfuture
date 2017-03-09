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
		return $this->student->where('student_account',$filter)->select('id','name','student_account','fb_img','fb_name','img_upload','letter_content','letter_quote','joined','fb_img_thumb')->first();
	}

	/*HOME PAGE*/
	public function getLastBaiDuThi()
  {
      return $this->student->where('joined',1)->orderByRaw("RAND()")->take(8)->get();
  }

	public function getFirstLastBaiDuThi()
	{
		return $this->student->where('joined',1)->orderBy('updated_at','DESC')->first();
	}

	public function getMoreBaiThi($value_filter)
	{
		// return $this->student->where('joined',1)->whereDate('updated_at','<',$value_filter)->orderBy('updated_at','DESC')->take(8)->get();
		return $this->student->where('joined',1)->whereNotIn('id',$value_filter)->orderByRaw("RAND()")->take(8)->get();
	}
	public function getVoteHightes(){
		return $this->student->where('joined',1)->orderBy('vote',"DESC")->orderBy('updated_at',"DESC")->first();
	}

	public function getFourVote($filter){
		return $this->student->where('joined',1)->whereNotIn('id',$filter)->orderBy('vote',"DESC")->take(4)->get();
	}
	public function getMoreVote($filter){
		return $this->student->where('joined',1)->whereNotIn('id',$filter)->orderBy('vote',"DESC")->take(6)->get();
	}

	public function getListLastBaiviet($arr){
		return $this->student->where('joined',1)->whereNotIn('id',$arr)->orderBy('updated_at','DESC')->take(30)->get();
	}


	// DETAIL PAGE
	public function getDetailBaiviet($id)
	{
		return $this->student->find($id);
	}
}

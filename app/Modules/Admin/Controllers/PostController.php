<?php namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Student;

use Notification;
use Auth;

use App\Repositories\Admin\StudentRepositoryInterface;

class PostController extends Controller {
  protected $student;

  public function __construct(StudentRepositoryInterface $student){
    $this->student = $student;
  }

  public function getTop50(){
    $data_top50 = $this->student->getTop50();
    return view('Admin::pages.dashboard.index');
  }

  public function getDetail($id){
    $detail = $this->student->getDetailPost(1);
    $user_id = Auth::user()->id;
    $check_vote_yet = Student::whereHas('votes',function($q) use ($user_id){
      $q->where('user_id',$user_id);
    })->find(1);
    dd($check_vote_yet);
  }

  public function postVotePost(Request $request, $id){
    $user_id = Auth::user()->id;

  }
}

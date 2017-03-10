<?php namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Vote;

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

  public function index(){
    $data = $this->student->getListStudent();
    return view('Admin::pages.student.index',compact('data'));
  }

  public function show($id){
    $student = $this->student->getDetailStudent($id);
    return view('Admin::pages.student.view',compact('student'));
  }

  public function update(Request $request, $id){
    $student = $this->student->getDetailStudent($id);
    $user =Auth::user();

    $inp_diem = $request->input('diem');

    $arr_user_id = [];
    $total = 0;
    foreach($student->votes()->getResults() as $vote){
      $total += $vote->diem;
      array_push($arr_user_id,$vote->user_id);
    }
    if(in_array($user->id,$arr_user_id)){

      $vote = $student->votes()->where('user_id',$user->id)->first();
      $vote->diem = $inp_diem;
      $vote->save();
    }else{
      $vote = new Vote(['diem'=>$inp_diem,'user_id'=>$user->id]);
      $student->votes()->save($vote);
    }

    if($student->votes()->count() == 4){
        $total /= $student->votes()->count();
        $data = [
          'vote' => round($total),
        ];
        $this->student->updateVoteStudent($id, $data);
        Notification::success('Update Successful !');
        return redirect()->route();
    }
    return redirect()->route();
  }
}

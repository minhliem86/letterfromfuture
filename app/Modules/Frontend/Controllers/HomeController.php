<?php namespace App\Modules\Frontend\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\Frontend\StudentRepositoryInterface;
use Carbon\Carbon;

use Session;

class HomeController extends Controller {

  protected $student;
  public function __construct(StudentRepositoryInterface $StudentRepositoryInterface ){
    $this->student = $StudentRepositoryInterface;
  }
  public function getIndex(){
    return view('Frontend::pages.home');
  }
	public function getBaivietDuThi($slug = null){
    /*data bai du thi*/
    $top_baiduthi = $this->student->getLastBaiDuThi();
    $arr_baiduthi = [];

    if($top_baiduthi){
      foreach($top_baiduthi as $item_baiduthi){
        array_push($arr_baiduthi,$item_baiduthi->id);
      }
      $data_arr_baiduthi = json_encode($arr_baiduthi);
    }else{
        $data_arr_baiduthi = null;
    }


    /*data top 50*/
    // $top50 = $this->student->getVoteHightes();
    // if($top50 ){
    //     $id_height = $top50->id;
    //     $top4 = $this->student->getFourVote([$id_height]);
    //     $arr_id_top_current = [$id_height];
    //     foreach($top4 as $item){
    //       array_push($arr_id_top_current,$item->id);
    //     }
    //     $data_id_current = json_encode($arr_id_top_current);
    // }else{
    //   $top4 = null;
    //   $data_id_current = null;
    // }

    $data_baimoinhat = $this->student->getFirstLastBaiDuThi();
    if($data_baimoinhat){
      $data_listbaimoi = $this->student->getListLastBaiviet([$data_baimoinhat->id]);
    }else{
      $data_listbaimoi = null;
    }


    // dd($data);
    return view('Frontend::pages.baiduthi',compact('top_baiduthi','data_arr_baiduthi','data_listbaimoi','data_baimoinhat'));

  }

  public function ajaxShowmoreBaiThi(Request $request)
  {
    if($request->ajax()){
      // $date = $request->input('date');
      // $more_baiviet = $this->student->getMoreBaiThi($date);
      // $date_last = $more_baiviet->last();
      $arr = $request->input('date');
      $more_baiviet = $this->student->getMoreBaiThi($arr);
      foreach($more_baiviet as $item){
        array_push($arr,$item->id);
      }
      $data_arr_id = json_encode($arr);
      $view = view('Frontend::ajax-template.baiduthi',compact('data_arr_id','more_baiviet'))->render();
      return response()->json(['rs'=>$view]);
    }
  }

  public function ajaxShowmoreTop50(Request $request){
    $arr = $request->input('arr');
    $vote = $this->student->getMoreVote($arr);
    foreach($vote as $item){
      array_push($arr,$item->id);
    }
    $data_id_vote = json_encode($arr);
    $view = view('Frontend::ajax-template.top50',compact('vote','data_id_vote'))->render();
    return response()->json(['rs'=>$view]);
  }

  public function getDangnhaphocvien(){
    if(Session::has('my_post')){
      return redirect()->route('frontend.getBaivietcuatoi');
    }else{
      return view('Frontend::pages.login-hocvien');
    }
  }

  public function postDangnhaphocvien(Request $request){
    $student_code = $request->input('code');
		$data = $this->student->getStudent($student_code);
		if(!empty($data)){
			if($data->joined == 1){
				$my_post = $request->session()->put('my_post',$student_code.'-logined');
				// Session::put('id_hocvien',$data->id);
				return redirect()->route('frontend.getBaivietcuatoi');
			}else{
				return redirect()->route('frontend.getLogin')->with('error','Vui lòng tham gia chương trình.');
			}

		}else{
			return redirect()->back()->with('error','Thông tin học viên không chính xác');
		}
  }

  public function getBaivietcuatoi(){
    if(Session::has('my_post')){
      $student_code = str_replace('-logined','',Session::get('my_post'));

      $baiviet = $this->student->getStudent($student_code);
      if($baiviet){
          return view('Frontend::pages.baivietcuatoi',compact('baiviet'));
      }else{
        return view('Frontend::pages.login-hocvien');
      }

    }else{
      return redirect()->route('frontend.getDangnhaphocvien')->with('error','Vui lòng đăng nhập để xem bài viết');
    }
    // dd(Session::get('my_post'));
  }

  public function getBaivietDetail($id){
    if($id){
      $baiviet = $this->student->getDetailBaiviet($id);
      return view('Frontend::pages.detail',compact('baiviet'));
    }
  }


  public function test(){
    // $data_more = $this->student->getMoreBaiThi(Carbon::now());
    dd($data_more);
  }

}

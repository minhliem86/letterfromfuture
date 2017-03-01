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
	public function getBaiduthi($slug = null){
    /*data bai du thi*/
    $top_baiduthi = $this->student->getLastBaiDuThi();
    if($top_baiduthi){
        $latest_item = $top_baiduthi->last();
    }else{
        $latest_item = null;
    }


    /*da top 50*/
    $top50 = $this->student->getVoteHightes();
    if($top50 ){
        $id_height = $top50->id;
        $top4 = $this->student->getFourVote([$id_height]);
        $arr_id_top_current = [$id_height];
        foreach($top4 as $item){
          array_push($arr_id_top_current,$item->id);
        }
        $data_id_current = json_encode($arr_id_top_current);
    }else{
      $top4 = null;
      $data_id_current = null;
    }

    switch ($slug) {
      case 'cuoc-thi':
        Session::flash('section','context');
        return view('Frontend::pages.home',compact('top_baiduthi','latest_item','top50','top4','data_id_current'));
        break;
      case 'the-le':
        Session::flash('section','term');
        return view('Frontend::pages.home',compact('top_baiduthi','latest_item','top50','top4','data_id_current'));
        break;
      case 'top50':
        Session::flash('section','top50');
        return view('Frontend::pages.home',compact('top_baiduthi','latest_item','top50','top4','data_id_current'));
        break;
      case 'bai-du-thi':
        Session::flash('section','baiduthi');
        return view('Frontend::pages.home',compact('top_baiduthi','latest_item','top50','top4','data_id_current'));
        break;
      default:
        Session::forget('section');
        return view('Frontend::pages.home',compact('top_baiduthi','latest_item','top50','top4','data_id_current'));
        break;
    }


    // return view('Frontend::pages.home',compact('top_baiduthi','latest_item','top50','top4','data_id_current'));

  }

  public function ajaxShowmoreBaiThi(Request $request)
  {
    if($request->ajax()){
      $date = $request->date;
      $data_more = $this->student->getMoreBaiThi($date);
      $date_more = $data_more->last();
      $view = view('Frontend::ajax-template.baiduthi',compact('data_more','date_more'))->render();
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

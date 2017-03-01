<?php namespace App\Modules\Frontend\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Repositories\Frontend\StudentRepositoryInterface;
use Session;

class StudentController extends Controller {

	protected $studentRepository;

	public function __construct(StudentRepositoryInterface $studentInterface){
		$this->studentRepository = $studentInterface;
	}

	public function getIndex($slug){

	}

	public function getLogin(){
		return view('Frontend::pages.login');
	}

	public function checkLogin(Request $request){
		if(!$request->ajax()){
			dd('error');
		}else{
			$acc = $request->input('code');
			$student_name = $this->studentRepository->getStudent($acc);
			if(!empty($student_name)){
				if($student_name->joined != 1){
					return response()->json(['result'=>$student_name->name]);
				}else{
					return response()->json(['result'=>'Mỗi học viên chỉ có thể tham gia 01 lần.']);
				}
			}else{
				return response()->json(['result'=>'Mã học viên không chính xác']);
			}
		}
	}


	public function postLogin(Request $request){
		$student_code = $request->input('code');
		$data = $this->studentRepository->getStudent($student_code);
		if(!empty($data)){
			if($data->joined != 1){
				$student_code_ses = $request->session()->put('student_code',$student_code);
				return redirect()->route('frontend.getLetter');
			}else{
				return redirect()->back()->with('error','Mỗi học viê chỉ có thể tham gia 01 lần. Vui lòng đợi kết quả từ ILA.');
			}

		}else{
			return redirect()->back()->with('error','Mã học viên không chính xác');
		}
	}

	public function getLetter(){
		if(Session::has('student_code')){
			$data = $this->studentRepository->getStudent(Session::get('student_code'));
			return view('Frontend::pages.letter',compact('data'));
		}else{
			return redirect()->back();
		}

	}

	public function AjaxImg(Request $request){
		if($request->ajax()){
			$data = [
				'fb_img' => $request->input('img'),
			];
			$this->studentRepository->updateAccount(Session::get('student_code'),$data);
			return response()->json(['rs'=>'ok']);

		}
	}

	public function ajaxLetter(Request $request){
		if($request->ajax()){
			$from = $request->input('from');
			$message = $request->input('message');
			$quote = $request->input('quote');
			$data = [
				'letter_content' => $message,
				'letter_quote' => $quote,
			];
			$update_student = $this->studentRepository->updateAccount(Session::get('student_code'),$data);
			$view = view('Frontend::ajax-template.letter-template',compact('from','message','quote'))->render();
			return response()->json(['rs'=>$view]);
		}
	}

	public function AjaxOrder(Request $request){
		if($request->ajax()){
			$data = [
				'joined' => 1,
				'fb_link' => $request->input('link'),
			];
			$update_student = $this->studentRepository->updateAccount(Session::get('student_code'),$data);
			return response()->json(['rs'=>'Đã tham dự']);
		}
	}

	public function getDone(){
		\Session::forget('student_code');
		return view('Frontend::pages.thankyou');
	}




}

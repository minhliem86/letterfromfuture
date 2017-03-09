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
				Session::put('id_hocvien',$data->id);
				return redirect()->route('frontend.getLetter');
			}else{
				return redirect()->back()->with('error','Mỗi học viê chỉ có thể tham gia 01 lần. Vui lòng đợi kết quả từ ILA.');
			}

		}else{
			return redirect()->back()->with('error','Mã học viên không chính xác');
		}
	}

	public function getLetter(){
		if(Session::has('student_code') && Session::has('id_hocvien')){
			$data = $this->studentRepository->getStudent(Session::get('student_code'));
			return view('Frontend::pages.letter',compact('data'));
		}else{
			return redirect()->back();
		}

	}

	public function AjaxImg(Request $request){
		if($request->ajax()){

			$path = 'public/upload/img-fb';
			$name = time().'-'.Session::get('student_code').'-imgfb';
			$img_thumb = \Image::make($request->input('img'))->resize(80,80)->save($path.'/'.$name.'.jpg');
			$data = [
				'fb_img' => $request->input('img'),
				'fb_img_thumb' => asset('public/upload/img-fb').'/'.$name.'.jpg'
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

			// ADD SESSION MESSAGE
			Session::put('student_message',$message);
			Session::put('student_quote',$quote);

			$data = [
				'letter_content' => $message,
				'letter_quote' => $quote,
			];
			$update_student = $this->studentRepository->updateAccount(Session::get('student_code'),$data);
			$img = $this->studentRepository->getStudent(Session::get('student_code'))->fb_img_thumb;
			$view = view('Frontend::ajax-template.letter-template',compact('from','message','quote','img'))->render();
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

	public function AjaxGetImg(Request $request){
		if($request->ajax()){
			$path = 'public/upload/img-user';
			$name = time().'-'.Session::get('student_code');
			$img = \Image::make($request->input('img'))->save($path.'/'.$name.'.png');
			$data = [
				'img_upload' => asset('public/upload/img-user').'/'.$name.'.png',
			];
			$update_student = $this->studentRepository->updateAccount(Session::get('student_code'),$data);
			return response()->json(['rs'=>'ok']);
		}
	}



	public function getDone(){
		$student = Session::get('student_code').'-logined';
		\Session::put('my_post',$student);
		// \Session::put('my_post',Session::get('student_code').'-logined');
		\Session::forget('student_code');
		\Session::forget('student_message');
		\Session::forget('student_quote');
		return view('Frontend::pages.thankyou');
	}



}

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

	public function getIndex(){
		return view('Frontend::pages.home');
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
				return response()->json(['result'=>$student_name->name]);
			}else{
				return response()->json(['result'=>'Vui lòng nhập chính xác mã học viên']);
			}
		}
	}

	public function postLogin(Request $request){
		$student_code = $request->input('code');
		$data = $this->studentRepository->getStudent($student_code);
		if(!empty($data)){
			$student_code_ses = $request->session()->put('student_code',$student_code);
			return redirect()->route('frontend.getLetter');
		}else{
			return redirect()->back()->with('error','Mã học viên không chính xác');
		}
	}

	public function getLetter(){
		$data = $this->studentRepository->getStudent(Session::get('student_code'));
		return view('Frontend::pages.letter',compact('data'));
	}

	public function ajaxLetter(Request $request){
		if($request->ajax()){
			$from = $request->input('from');
			$message = $request->input('message');
			$quote = $request->input('quote');
			$img_fb = $request->input('img');
			$data = [
				'letter_content' => $message,
				'letter_quote' => $quote,
				'fb_img' => $img_fb,
			];
			$update_student = $this->studentRepository->updateAccount(Session::get('student_code'),$data);
			$view = view('Frontend::ajax-template.letter-template',compact('from','message','quote','img_fb'))->render();
			return response()->json(['rs'=>$view]);
		}
	}


}

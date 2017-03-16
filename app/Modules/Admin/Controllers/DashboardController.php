<?php namespace App\Modules\Admin\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Student;
use Auth;

use App\Repositories\Admin\StudentRepositoryInterface;

class DashboardController extends Controller {

	protected $student;

	public function __construct(StudentRepositoryInterface $student){
		$this->student = $student;
	}

	public function getIndex()
  {
		$top50 = $this->student->getTop50();
		return view('Admin::pages.dashboard.index',compact('top50'));
  }

}

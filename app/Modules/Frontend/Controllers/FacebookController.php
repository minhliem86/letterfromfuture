<?php namespace App\Modules\Frontend\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class FacebookController extends Controller {

	protected $fb;

  public function __construct(LaravelFacebookSdk $fb){
    $this->fb = $fb;
  }

  public function getLetter(){
    $login_url = $this->fb->getLoginUrl(['email,user_photos'],route('fb.postLetter'));
    return view('Frontend::pages.letter-php',compact('login_url'));
  }

}

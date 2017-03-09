<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Student extends Model {

	public $table = 'students';

	protected $fillable = ['id','name','email','student_account','center_code','letter_content','letter_quote','fb_name','fb_img','img_upload','vote','joined','order','fb_img_thumb'];

	public function votes(){
		return $this->morphMany('App\Models\Vote','voteable');
	}

}

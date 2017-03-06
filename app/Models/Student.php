<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

	public $table = 'students';

	protected $fillable = ['id','name','email','student_account','center_code','letter_content','letter_quote','fb_name','fb_img','img_upload','vote','joined','order'];

	public function votes(){
    return $this->belongsToMany('App\Models\Vote','vote_student');
  }

}

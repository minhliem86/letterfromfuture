<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model {

	public $table = 'votes';

	protected $fillable = ['diem','user_id'];

  public function users(){
    return $this->belongsTo('App\Models\User','user_id');
  }

  public function students(){
    return $this->belongsToMany('App\Models\Student','vote_student');
  }
}

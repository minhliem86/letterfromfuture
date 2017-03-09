<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model {

	public $table = 'votes';

	protected $fillable = ['diem','user_id'];

  public function voteable(){
		return $this->morphTo();
	}

	// public function author(){
	// 	return $this->belongsTo('App\Models\User','user_id');
	// }
}

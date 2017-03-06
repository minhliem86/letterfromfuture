<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {

	public function user_role(){
    return $this->belongsToMany('App\Models\User');
  }

  public function perm(){
    return $this->belongsToMany('App\Models\Permission');
  }

}

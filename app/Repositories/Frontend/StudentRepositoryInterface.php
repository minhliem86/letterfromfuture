<?php
namespace App\Repositories\Frontend;

interface StudentRepositoryInterface{

	public function updateAccount($filter_where,$data);

	public function getStudent($filter);
}
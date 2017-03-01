<?php
namespace App\Repositories\Frontend;

interface StudentRepositoryInterface{

	public function updateAccount($filter_where,$data);

	public function getStudent($filter);

	// HOME PAGE
	public function getLastBaiDuThi();

	public function getFirstLastBaiDuThi();

	public function getMoreBaiThi($value_filter);

	public function getVoteHightes();

	public function getFourVote($filter);

	public function getMoreVote($filter);

	// DETAIL PAGE
	public function getDetailBaiviet($id);
}

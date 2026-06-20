<?php
namespace App\Repositories\Interfaces;

interface EnquiryInterface {
	public function store($data);
	public function update($enquiryId, $data);
}
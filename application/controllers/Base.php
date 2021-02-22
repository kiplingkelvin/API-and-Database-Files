<?php
require APPPATH . '/libraries/REST_Controller.php';

use \Restserver\Libraries\REST_Controller;

class Base extends REST_Controller
{

	public function __construct($config = 'rest')
	{
		parent::__construct($config);
	}

	/**
	 * @param $dateRange
	 * @return false|string[]
	 */
	protected function splitDateRange($dateRange)
	{
		$separate_dates = explode(' to ', $dateRange);
		/*Check if delimiter used is hyphen*/
		if (empty($separate_dates)) {
			$separate_dates = explode(' - ', $dateRange);
		}
		return $separate_dates;

	}

	/*Audit*/
	/**
	 * @param $action
	 * @param $username
	 * @param $status
	 */
	function createTrail($action, $username,$status)
	{
		$data = array(
			"action" =>$action,
			"ipAddress" => $this->get_client_ip(),
			"status"=>$status,
			"username"=>$username,
			"actionTime"=>date("Y-m-d H:i:s")
		);

		$this->operations->insertTrail($data);
	}
	// Function to get the client IP address
	function get_client_ip() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

}

<?php


class Reports_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * @param $params
	 * @return array|array[]|object|object[]
	 */
	public function getClients($params)
	{

		$this->db->select("clientId,userId,name,repEmail,repMobil,clients.groupCode,groupDescription,clients.dateCreated,
		addressLocation,descriptions");
		$this->db->from("clients");
		$this->db->join("user_groups", "user_groups.groupCode = clients.groupCode");
		foreach ($params as $key => $value) {
			if ($value != null) {
				$this->db->where("$key", $value);
			}
		}
		return $this->db->get()->result("array");

	}

	/**
	 * @param $params
	 * @return array|array[]|object|object[]
	 */
	public function getOrders($params)
	{
		$this->db->select("orders.orderId,beneficiary.beneficiaryId,beneficiary.beneficiaryName,amount,locationExpected,
		locationDelivered,delivery_status.statusCode,orders.dateCreated
		,orders.dateDispatched,orders.dateDelivered,orders.lastUpdated");
		$this->db->from("orders");
		$this->db->join("delivery_status", "orders.deliveryStatusId = delivery_status.statusCode");
		$this->db->join("orders_beneficiaries", "orders.orderId = orders_beneficiaries.orderId");
		$this->db->join("beneficiary", "orders_beneficiaries.beneficiaryId = beneficiary.beneficiaryId");
		$this->db->join("orders_agents", "orders_agents.orderId = orders.orderId", "LEFT OUTER");
		$this->db->join("agents", "orders_agents.agentId = agents.agentId");
		$this->db->join("orders_donations", "orders.orderId = orders_donations.orderId");
		$this->db->join("client_donations", "client_donations.donationId = orders_donations.clientDonationId");
		foreach ($params as $key => $value) {
			if ($value != null) {
				$this->db->where("$key", $value);
			}
		}
		return $this->db->get()->result("array");
	}

	/**
	 * @param $params
	 * @return array|array[]|object|object[]
	 */
	public function getBeneficiaries($params)
	{
		$this->db->select("beneficiaryId,beneficiaryName,locationAddress,gender,email,mobile");
		$this->db->from("beneficiary");
		foreach ($params as $key => $value) {
			if ($value != null) {
				$this->db->where("$key", $value);
			}
		}
		return $this->db->get()->result("array");
	}

	/**
	 * @param $params
	 * @return array|array[]|object|object[]
	 */
	public function getStaff($params){
		$this->db->select("email,mobile,addressLocation,gender,identificationNumber,responsibilities,dateCreated 
		as dateRegistered, lastModified");
		$this->db->from("staff");
		foreach ($params as $key => $value) {
			if ($value != null) {
				$this->db->where("$key", $value);
			}
		}
		return $this->db->get()->result("array");
	}
	public function getAuditTrail($params){
		$this->db->select("action,ipAddress,actionTime,userName,groupDescription");
		$this->db->from("audit_trail");
		$this->db->join("users","users.userId = audit_trail.userId");
		$this->db->join("user_groups","users.groupCode = user_groups.groupCode");
		foreach ($params as $key => $value) {
			if ($value != null) {
				$this->db->where("$key", $value);
			}
		}
		return $this->db->get()->result("array");
	}

	public function donations_get(){

	}
	public function modules_get(){

	}


}
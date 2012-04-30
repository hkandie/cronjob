<?php

class MCrontodo extends CI_Model{
    function __construct()
    {
        parent::__construct();
        
    }
    function mycronjob(){
        
        $query = $this->db->get_where('orders', array('status' => 1));
	return $query->row_array();
    }
    function get_customer_order_info($id){
       $query = $this->db->get_where('customer', array('status' => 1));
	return $query->row_array(); 
    }
}
?>

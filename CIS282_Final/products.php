<?php
//require('database.php');
class Products extends DB {
  function get_results_per_page($results_per_page, $page) {
	$start_from =($page-1)*$results_per_page;
	return $this->select("SELECT * FROM products ORDER BY id ASC LIMIT $start_from, ".$results_per_page);
  }
  
  function get_total_pages($results_per_page) {
	$total_pages=0;
	$result=$this->select("SELECT COUNT(id) AS total FROM products");
	foreach($result as $r)
	{
	  $total_pages=ceil($r['total']/$results_per_page);
	}
	return $total_pages;
  }

  function get_image($id) {
    return $this->select("SELECT * FROM product_images WHERE product_id='$id'");
  }
  
  function Spurs() {
    return $this->select("SELECT * FROM products WHERE name LIKE '%Spurs%'");
  }

  function Golden() {
    return $this->select("SELECT * FROM products WHERE name LIKE '%Warriors%'");
  }

  function Cavs() {
    return $this->select("SELECT * FROM products WHERE name LIKE '%Cavaliers%'");
  }

  function get_maxLine($session_id) {
	$maxLine=0;
	$result=$this->select("SELECT MAX(shop_line) AS maxLine FROM shopping WHERE shop_no='$session_id'");
	foreach($result as $r)
	{
	  $maxLine=$r['maxLine'];
	}
	return $maxLine;
  }
  
  function insert_cart($session_id, $id, $price, $qty) {
	$newLine=$this->get_maxLine($session_id) + 1;
	$this->edit("INSERT INTO shopping ( shop_line, shop_no, shop_prodid, shop_price, shop_qty ) 
		VALUES ( '$newLine', '$session_id', '$id', '$price', '$qty' )");
  }
  
  function get_cart($session_id) {
	return $this->select("SELECT * FROM shopping WHERE shop_no='$session_id'");
  }
  
  function get_product($id) {
	return $this->select("SELECT * FROM products WHERE id='$id'");
  }
  
  function delete_cart($session_id) {
	$this->edit("DELETE FROM shopping WHERE shop_no='$session_id'");
  }

  function get_maxInvID() {
	$maxInvID=0;
	$result=$this->select("SELECT MAX(inv_id) AS maxInvID FROM invoice WHERE inv_date <> 0");
	foreach($result as $r)
	{
	  $maxInvID=$r['maxInvID'];
	}
	return $maxInvID;
  }

  function insert_lineitem($line_no, $invid, $id, $price, $qty) {
	$this->edit("INSERT INTO lineitem ( line_no, line_invid, line_productid, line_price, line_qty ) 
		VALUES ( '$line_no', '$invid', '$id', '$price', '$qty' )");
  }
  
  function get_lineitem($invid) {
	return $this->select("SELECT * FROM lineitem WHERE line_invid='$invid'");
  }
  
  function insert_invoice($inv_id, $custname, $totalprice, $tax, $date) {
	$this->edit("INSERT INTO invoice ( inv_id, inv_custname, inv_totalprice, inv_tax, inv_date ) 
		VALUES ( '$inv_id', '$custname', '$totalprice', '$tax', '$date' )");
  }  
  
  function update_invoice($inv_id, $custname, $totalprice, $tax, $date) {
	$this->edit("UPDATE invoice SET inv_custname = '$custname', inv_totalprice = '$totalprice', inv_tax = '$tax', inv_date ='$date' WHERE inv_id='$inv_id'");
  }
}
?>
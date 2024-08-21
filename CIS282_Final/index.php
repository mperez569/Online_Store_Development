<?php
require('database.php');
require('products.php');

$products = new Products();

if(session_id() == '')
{
    session_start();
}

$session_id = session_id();
$action=filter_input(INPUT_POST, 'action');

if($action == null)
{
    $action=filter_input(INPUT_GET, 'action');
    if($action == null)
    {
        $action = 'see_products';
    }
}

$error_message = '';
$results_per_page = 6;
if($action == 'see_products')
{
    if(isset($_GET["page"]))
    {
        $page = $_GET["page"];
    }
    else
    {
        $page = 1;
    }
    $results = $products -> get_results_per_page($results_per_page, $page);
    include('view.php');
}
else if ($action == 'filterSpurs')
{
    $results = $products->Spurs();
    include ('view.php');
}
else if ($action == 'filterGolden')
{
    $results = $products->Golden();
    include ('view.php');
}
else if ($action == 'filterCavs')
{
    $results = $products->Cavs();
    include ('view.php');
}
else if ($action == 'insert_cart')
{
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
    if($quantity == null || $quantity == FALSE || $quantity <= 0)
    {
        $error_message = "ERROR---Quantity of item must be a whole number greater than 0<br><br>";
    }
    else
    {
        $products-> insert_cart($session_id, $_POST['id'], $_POST['price'], $_POST['quantity']);
    }
    $page = $_POST['page'];
    $results = $products -> get_results_per_page($results_per_page, $page);
    include('view.php');
}
else if ($action == 'see_cart')
{
    $results = $products->get_cart($session_id);
    include ('cart.php');
}
else if($action == 'empty_cart')
{
    $products->delete_cart($session_id);
    $results = $products->get_cart($session_id);
    include('cart.php');
}
else if ($action == 'checkout')
{
    $results = $products->get_cart($session_id);
    $newInvID = $products->get_MaxInvID() + 1;
    $products -> insert_invoice($newInvID, null, null, null, null);
    foreach($results as $r)
    {
        $products->insert_lineitem($r['shop_line'], $newInvID, $r['shop_prodid'], $r['shop_price'], $r['shop_qty']);
    }
 
    $results = $products->get_lineitem($newInvID);

    include('checkout.php');
}

else if($action == 'order')
{
    $custname=filter_input(INPUT_POST, 'custname');
    $newInvID = $_POST['inv_id'];
    if('custname' == ''||'custname' == null)
    {
        $error_message = "ERROR: Enter an appropriate name for the order";
        $results = $products->get_lineitem($newInvID);
        include('checkout.php');
    }
    else
    {
        //$products->update_invoice($newInvID, $_POST('custname'), $_POST('totalprice'), $_POST('tax'), $_POST('date'));
        $products->delete_cart($session_id);
        session_destroy();
        include('invoice.php');
    }
}
?>
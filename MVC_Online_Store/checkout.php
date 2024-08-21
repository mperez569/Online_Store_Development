<?php include('header.php'); ?>
<nav>
<a href="index.php">Products</a>
<a href="index.php?action=see_cart">View Cart</a>
</nav>
<h2>Checkout</h2>
<table>
<tr>
<th>Line #</th>
<th>Item Description</th>
<th>Price</th>
<th>Quantity</th>
<th>Subtotal</th>
</tr>
<?php
    $pretaxtotal=0;
    foreach($results as $r)
    {
        echo "<tr>";
        echo "<td>".$r['line_no']."</td>";
        $item = $products->get_product($r['line_productid']);
        echo "<td>".$item[0]['name']."</td>";
        echo "<td>$".$r['line_price']."</td>";
        echo "<td>".$r['line_qty']."</td>";
        $subtotal = $r['line_price'] * $r['line_qty'];
        echo "<td>$".number_format($subtotal, 2, '.', '')."</td>";
        echo "</tr>";
        $pretaxtotal = $pretaxtotal + $subtotal;
    }
?>
<tr>
<td></td>
<td>Subtotal (before tax)</td>
<td></td>
<td></td>
<td>$<?php echo number_format($pretaxtotal, 2, '.', ''); ?></td>
</tr>
<tr>
<td></td>
<td>Tax (10%)</td>
<td></td>
<td></td>
<?php $tax = round($pretaxtotal * 0.1, 2); ?>
<td>$<?php echo number_format($tax, 2, '.', ''); ?></td>
</tr>
<tr>
<td></td>
<td>Total Price (including tax)</td>
<td></td>
<td></td>
<?php $totalprice = $pretaxtotal + $tax; ?>
<td>$<?php echo number_format($totalprice, 2, '.', ''); ?></td>
</tr>
</table>
<br><br>
<form action="index.php" method="post">
<input type="hidden" name="action" value="order">
<input type="hidden" name="inv_id" value="<?= $newInvID ?>">
<input type="hidden" name="totalprice" value="<?= $totalprice ?>">
<input type="hidden" name="tax" value="<?= $tax ?>">
<?php date_default_timezone_set("America/Chicago"); ?>
<input type="hidden" name="date" value="<?= date('Y-m-d') ?>">
<label for="custname">Enter Customer Name:&nbsp</label>
<input type="text" name="custname">
<br><br>
<?php echo $error_message; ?>
<input type="submit" value="Submit Order" id="btn">
</form>
<footer>
</footer>
</body>
</html>
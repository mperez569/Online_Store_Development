<?php
    include ('header.php');
?>

<nav>
    <a href = "index.php">Products</a>
    <a href = "index.php?action=empty_cart">Empty Cart</a>
<?php
    if($resutls[0] != null)
    {
        echo "<a href = 'index.php?action=checkout'>Checkout</a>";
    }
?>
</nav>
<h2>Shopping Cart</h2>
<?php
    if($results[0] == null)
    {
        echo "Your Cart is Empty!";
        return;
    }
?>
<table>
    <tr>
        <th>Item</th>
        <th>Item Description</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
    </tr>
    <?php
        foreach($results as $r)
        {
            echo "<tr>";
            $image = $products ->get_image($r['shop_prodid']);
            echo "<td><img src='images/".$image[0]['name']."'></td>";
            $item=$products -> get_product($r['shop_prodid']);
            echo "<td>".$item[0]['name']."</td>";
            echo "<td>".$r['shop_price']."</td>";
            echo "<td>".$r['shop_qty']."</td>";
            $subtotal = $r['shop_price'] * $r['shop_qty'];
            echo "<td>".number_format($subtotal, 2, '.', '')."</td>";
            echo "</tr>";
        }
    ?>
</table>

<br><br>

<button id = "btn"><a href = "index.php?action=checkout">Checkout</a></button>
<?php include('header.php'); ?>
<nav>
    <a href="index.php">Products</a>
    <a href="index.php?action=see_cart">View Cart</a>
</nav>

<h2>Invoice</h2>
<table id = "invoice">
    <?php
        echo "<tr><th>Invoice Number: </th>";
        echo "<td>".$_POST['inv_id']."</td></tr>";

        echo "<tr><th>Customer Name: </th>";
        echo "<td>".$_POST['custname']."</td></tr>";

        echo "<tr><th>Total Price (Including Tax): </th>";
        echo "<td>".$_POST['totalprice']."</td></tr>";
        
        echo "<tr><th>Tax: </th>";
        echo "<td>".$_POST['tax']."</td></tr>";

        echo "<tr><th>Date: </th>";
        echo "<td>".$_POST['date']."</td></tr>";
    ?>
</table>

<footer>
</footer>
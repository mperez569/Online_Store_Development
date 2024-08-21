<?php
include('header.php');
?>

<nav>
    <a href = "index.php">Products</a>
    <a href = "index.php?action=see_cart">View Cart</a>
</nav>
<br>

<div id = "filter">
    <h1>Search by Team:</h1>

    <span>
        <li>
            <span id = "spurs">
                <a href="index.php?action=filterSpurs">
                    <label>Spurs</label>
                </a>
            </span>
        </li>
    </span>

    <span>
        <li>
            <span id = "warriors">
                <a href="index.php?action=filterGolden">
                    <label>Warriors</label>
                </a>
            </span>
        </li>
    </span>

    <span>
        <li>
            <span id = "cavs">
                <a href="index.php?action=filterCavs">
                    <label>Cavaliers</label>
                </a>
            </span>
        </li>
    </span>
</div>

<div id = "gallery">
    <?php
        echo $error_message;
        foreach($results as $r)
        {
            echo "<div class = 'item'>";
            $image = $products->get_image($r['id']);
            foreach($image as $i)
            {
                echo "<img src = 'images/".$i['name']."'></img>";
            }
            echo "<div class = 'desc'>".$r['name'].", $".$r['price']."</div>";

            echo "<form action = 'index.php' method = 'post'>";

            echo "<input type = 'hidden' name = 'action' value = 'insert_cart'>";
            echo "<input type = 'hidden' name = 'page' value = ".$page.">";
            echo "<input type = 'hidden' name = 'id' value = ".$r['id'].">";
            echo "<input type = 'hidden' name = 'price' value = ".$r['price'].">";

            echo "<label for = 'quantity'>Enter Quantity:&nbsp</label>";
            echo "<input type = 'text' id = 'quantity' name = 'quantity' value = '1'><br>";
            echo "<input type = 'submit' id = 'add' value = 'Add to Cart'>";
            echo "</form>";
            echo "</div>";
        }
    ?>
    <footer>
        <?php
            $total_pages = $products->get_total_pages($results_per_page);
            for($i = 1; $i <= $total_pages; $i++)
            {
                echo "<div class = 'pagination'><a ";
                if($i == $page)
                {
                    echo "class = 'current' ";
                }
                echo "href = 'index.php?page=".$i."'>".$i."</a></div>";
            }
        ?>
    </footer>
</div>
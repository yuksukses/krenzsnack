<?php
$base = $_SERVER['REQUEST_URI'];
echo $base;
?>

<form action="<?php echo $base ?>checkout-process.php" method="GET">
    <input type="submit" value="Pay with Snap Redirect">
</form>
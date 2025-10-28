<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['cart'] = $_POST;
}

$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Корзина</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<style>
    body {
        background-color: #99FFCC;
    }
    .cart {
        margin-top: 20px;
    }
</style>

<div class="container">
    <h2>Корзина</h2>
    <div class="cart">
        <form method="POST" action="order.php">
            <div id="cart_items">
                <?php
                $total = 0;
                foreach ($cartItems['Name_pizza'] as $index => $namePizza) {
                    $price = $cartItems['Price_pizza'][$index];
                    $quantity = $cartItems['Quantity'][$index];
                  
                    $sum = $price * $quantity;
                    $total += $sum;
                    echo "
                    <div class='cart-item' data-id='{$index}'>
                        <p>{$namePizza} - {$price} руб. x {$quantity} шт. = {$sum}  руб.</p>
                        <input type='hidden' name='Name_pizza[]' value='{$namePizza}'>
                        <input type='hidden' name='Price_pizza[]' value='{$price}'>
                        <input type='hidden' name='Quantity[]' value='{$quantity}'>
                      
                    </div>";
                }
                ?>
                <h3>Итого: <?php echo $total; ?> руб.</h3>
            </div>
            <div class="form-group">
                <input type="text" name="Surname" class="form-control" placeholder="Введите фамилию" required>
            </div>
            <div class="form-group">
                <input type="text" name="Name" class="form-control" placeholder="Введите имя" required>
            </div>
            <div class="form-group">
                <input type="text" name="Number" class="form-control" placeholder="Телефон" required>
            </div>
            <div class="form-group">
                <input type="text" name="Address" class="form-control" placeholder="Адрес" required>
            </div>
            <button type="submit" class="btn btn-primary">Оформить заказ</button>
        </form>
    </div>
</div>

</body>
</html>
<?php
include 'connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Каталог пицц</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
<header>
    <div class="bx bx-menu" id="menu-icon"></div>
    <ul class="navbar">
        <a href="listener.php">Выход</a>
    </ul>
</header>

<style>
    body {
        background-color: #99FFCC;
    }
    .catalog {
        display: flex;
        flex-wrap: wrap;
    }
    .pizza {
        width: 300px;
        margin: 10px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
        cursor: pointer;
    }
    .pizza img {
        width: 200px;
        height: 200px;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    .pizza h3 {
        font-size: 20px;
        margin-bottom: 10px;
    }
    .pizza p {
        font-size: 16px;
    }
    .cart {
        margin-top: 20px;
    }
</style>

<div class="container">
    <h2><center>Каталог пицц</center></h2>
    <div class="catalog">
        <?php
        // Запрос для получения данных о пиццах
        $pizzaQuery = $mysqli->query("SELECT ID_Pizza, Name_pizza, Price_pizza,size , Weight FROM pizza
        Join size_pizza on size_pizza.ID_size = pizza.Size_ID");
        while ($row = $pizzaQuery->fetch_assoc()) {
            echo "
            <div class='pizza' data-id='{$row['ID_Pizza']}' data-name='{$row['Name_pizza']}' data-price='{$row['Price_pizza']}'>
                <img src='photo/{$row['ID_Pizza']}.jpg' alt='{$row['Name_pizza']}'>
                <h3>{$row['Name_pizza']}</h3>
                <p>Цена: {$row['Price_pizza']} руб.</p>
                <p>Размер: {$row['size']} см</p>
                <p>Вес: {$row['Weight']} г</p>
            </div>";
        }
        ?>
    </div>

    <div class="cart">
     
        <form method="POST" action="cart.php">
            <div id="cart_items"></div>
            <button type="submit" class="btn btn-primary">Перейти к корзине</button>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.pizza').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = $(this).data('price');
        var cartItem = `
        <div class="cart-item" data-id="${id}">
            <p>${name} - ${price} руб.</p>
            <input type="hidden" name="Name_pizza[]" value="${name}">
            <input type="hidden" name="Price_pizza[]" value="${price}">       
          
            <input type="number" name="Quantity[]" value="1" min="1" class="form-control" required>
            <button type="button" class="btn btn-danger" onclick="removeCartItem(this)">Удалить</button>
        </div>`;
        
        $('#cart_items').append(cartItem);
    });
});
function removeCartItem(button) {
    $(button).parent('.cart-item').remove();
}
</script>

</body>
</html>
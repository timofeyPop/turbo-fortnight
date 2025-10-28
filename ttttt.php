<?php
// connect.php - файл для подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "deliverypizza";

$mysqli = new mysqli($servername, $username, $password, $dbname);
if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}
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
    <h2>Каталог пицц</h2>
    <div class="catalog">
        <?php
        // Запрос для получения данных о пиццах
        $pizzaQuery = $mysqli->query("SELECT ID_Pizza, Name_pizza, Price_pizza, Size_ID, Weight FROM pizza");
        while ($row = $pizzaQuery->fetch_assoc()) {
            echo "
            <div class='pizza' data-id='{$row['ID_Pizza']}' data-name='{$row['Name_pizza']}' data-price='{$row['Price_pizza']}'>
                <img src='{$row['ID_Pizza']}.jpg' alt='{$row['Name_pizza']}'>
                <h3>{$row['Name_pizza']}</h3>
                <p>Цена: {$row['Price_pizza']} руб.</p>
                <p>Вес: {$row['Weight']} г</p>
            </div>";
        }
        ?>
    </div>

    <div class="cart">
        <h2>Корзина</h2>
        <form method="POST" action="order.php">
            <div id="cart_items"></div>
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
<?php


if (isset($_POST['Surname'])) {
    $klientSurname = $_POST['Surname'];
    $klientName = $_POST['Name'];
    $klientNumber = $_POST['Number'];
    $klientAddress = $_POST['Address'];
    $currentDateTime = date('Y-m-d H:i:s');
    $min = 30;
    $max = 100;
    $id = rand($min, $max);

    $namePizzas = $_POST['Name_pizza'];
    $prices = $_POST['Price_pizza'];
    $quantities = $_POST['Quantity'];
    $total = 0;

    $mysqli->begin_transaction();

    try {
        foreach ($namePizzas as $index => $namePizza) {
            $price = $prices[$index];
            $quantity = $quantities[$index];

            $stmt = $mysqli->prepare("SELECT ID_Pizza FROM pizza WHERE Name_pizza = ?");
            $stmt->bind_param("s", $namePizza);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            $pizza = $product['ID_Pizza'];

            $orderSum = $price * $quantity;
            $total += $orderSum;

            $stmt = $mysqli->prepare("INSERT INTO pizza_check (ID_check, order_online_ID, Pizza_ID, Quantity) VALUES (?, ?, ?, ?)");
            $idd = rand($min, $max);
            $stmt->bind_param("iiii", $idd, $id, $pizza, $quantity);
            $stmt->execute();
        }

        $stmt = $mysqli->prepare("INSERT INTO order_online (ID_order_online, Surname, Name, Number, Address, Date_and_time, Sum_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssi", $id, $klientSurname, $klientName, $klientNumber, $klientAddress, $currentDateTime, $total);
        $stmt->execute();

        $mysqli->commit();
        echo "Заказ успешно создан с кодом заказа: $id";
    } catch (Exception $e) {
        $mysqli->rollback();
        echo "Ошибка создания заказа: " . $e->getMessage();
    }

    $stmt->close();
}
$mysqli->close();
?>
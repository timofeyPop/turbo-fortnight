
<!DOCTYPE html>
<html>
<head>
    <title>Клиент</title>
    <link rel="stylesheet" href="2.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
<header>
    <div class="bx bx-menu" id="menu-icon"></div>
    <ul class="navbar">
        <a href="listener.php">Выход</a>
    </ul>
</header>
<div class="container">
    <center><h2>Заказ</h2></center>
    <form class="form-style-8" method="POST" action="">
        <div class="form-row">
            <div class="col-md-3 mb-3">
                <input type="text" name="Surname" class="form-control" placeholder="Введите фамилию" required>
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" name="Name" class="form-control" placeholder="Введите имя" required>
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" name="Number" class="form-control" placeholder="телефон" required>
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" name="Address" class="form-control" placeholder="адрес" required>
            </div>
            <div id="order_items">
            <div class="col-md-3 mb-3">
                <select name="Name_pizza[]" class="form-control" required>
                    <option value="">Выберите пиццу</option>
                    <?php
                    $mysqli = new mysqli("localhost", "root", "", "deliverypizza");
                    if ($mysqli->connect_error) {
                        die("Ошибка подключения: " . $mysqli->connect_error);
                    }
                    $pizzaQuery = $mysqli->query("SELECT Name_pizza FROM pizza");
                    while ($row = $pizzaQuery->fetch_assoc()) {
                        $pizzaName = $row['Name_pizza'];
                        echo "<option value='$pizzaName'>$pizzaName</option>";
                    }
                    $mysqli->close();
                    ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <select name="size[]" class="form-control" required>
                    <option value="">Введите размер пиццы</option>
                    <?php
                    $mysqli = new mysqli("localhost", "root", "", "deliverypizza");
                    if ($mysqli->connect_error) {
                        die("Ошибка подключения: " . $mysqli->connect_error);
                    }
                    $pizzaQuery = $mysqli->query("SELECT size FROM size_pizza");
                    while ($row = $pizzaQuery->fetch_assoc()) {
                        $pizzaSize = $row['size'];
                        echo "<option value='$pizzaSize'>$pizzaSize</option>";
                    }
                    $mysqli->close();
                    ?>
                </select>
            </div>
                <div class="col-md-3 mb-3">
                    <input type="text" name="Quantity[]" class="form-control" placeholder="Введите количество" required>
                </div>
            </div>
            <div class="col-md-3">
                <button type="button" onclick="addOrderItem()">Добавить товар</button>
            </div>
            <div class="col-md-3">
                <button type="submit" name="add" class="btn btn-primary">Сделать заказ</button>
            </div>
        </div>
    </form>
</div>

<script>
function addOrderItem() {
    var orderItemsDiv = document.getElementById("order_items");
    var newOrderItem = document.createElement("div");
    newOrderItem.className = "order-item";
    newOrderItem.innerHTML = `
    <div class="col-md-3 mb-3">
                <select name="Name_pizza[]" class="form-control" required>
                    <option value="">Выберите пиццу</option>
                    <?php
                    $mysqli = new mysqli("localhost", "root", "", "deliverypizza");
                    if ($mysqli->connect_error) {
                        die("Ошибка подключения: " . $mysqli->connect_error);
                    }
                    $pizzaQuery = $mysqli->query("SELECT Name_pizza FROM pizza");
                    while ($row = $pizzaQuery->fetch_assoc()) {
                        $pizzaName = $row['Name_pizza'];
                        echo "<option value='$pizzaName'>$pizzaName</option>";
                    }
                    $mysqli->close();
                    ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <select name="size[]" class="form-control" required>
                    <option value="">Введите размер пиццы</option>
                    <?php
                    $mysqli = new mysqli("localhost", "root", "", "deliverypizza");
                    if ($mysqli->connect_error) {
                        die("Ошибка подключения: " . $mysqli->connect_error);
                    }
                    $pizzaQuery = $mysqli->query("SELECT size FROM size_pizza");
                    while ($row = $pizzaQuery->fetch_assoc()) {
                        $pizzaSize = $row['size'];
                        echo "<option value='$pizzaSize'>$pizzaSize</option>";
                    }
                    $mysqli->close();
                    ?>
                </select>
            </div>
        <div class="col-md-3 mb-3">
            <input type="text" name="Quantity[]" class="form-control" placeholder="Введите количество" required>
        </div><br>
    `;
    orderItemsDiv.appendChild(newOrderItem);
}
</script>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "deliverypizza";

$mysqli = new mysqli($servername, $username, $password, $dbname);
if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}

if (isset($_POST['add'])) {
    $klientSurame = $_POST['Surname'];
    $klientName = $_POST['Name'];
    $klientNumber = $_POST['Number'];
    $klientAddress = $_POST['Address'];
    $currentDateTime = date('Y-m-d H:i:s');
    $min = 40;
    $max = 200;
    $id = rand($min, $max);

    $namePizzas = $_POST['Name_pizza'];
    $sizes = $_POST['size'];
    $quantities = $_POST['Quantity'];


    $total = 0;

    foreach ($namePizzas as $index => $namePizza) {
        $sizePizza = $sizes[$index];
        $quantity = $quantities[$index];

        $query = "SELECT ID_Pizza FROM pizza JOIN size_pizza ON pizza.Size_ID = size_pizza.ID_size WHERE pizza.Name_pizza = '$namePizza' and size_pizza.size = $sizePizza";
        $result = $mysqli->query($query);
        $product = $result->fetch_assoc();
        $pizza = $product['ID_Pizza'];

        $query = "SELECT Price_pizza FROM pizza WHERE ID_Pizza = $pizza";
        $result = $mysqli->query($query);
        $product1 = $result->fetch_assoc();
        $price = $product1['Price_pizza'];

        $orderSum = $price * $quantity;
        $total += $orderSum;

        $idd = rand($min, $max);
        $query = "INSERT INTO pizza_check (ID_check, order_online_ID, Pizza_ID, Quantity) VALUES ('$idd', '$id', '$pizza', '$quantity')";
        $mysqli->query($query);
    }

    $query = "INSERT INTO order_online (ID_order_online, Surname, Name, Number, Address, Date_and_time, Sum_order) VALUES ('$id', '$klientSurame', '$klientName', '$klientNumber', '$klientAddress', '$currentDateTime', '$total')";
    $mysqli->query($query);

    echo "Заказ успешно создан с кодом заказа: $id";
    echo "<br><br><h2>Информация о заказе:</h2>";
        echo "<table class='table'>";
        echo "<tr><th>ID заказа</th><th>Фамилия клиента</th><th>Имя клиента</th><th>Номер телефона</th><th>Адрес</th><th>Дата и время заказа</th><th>Сумма заказа</th></tr>";
        echo "<tr><td>$id</td><td>$klientSurame</td><td>$klientName</td><td>$klientNumber</td><td>$klientAddress</td><td>$currentDateTime</td><td>$total</td></tr>";
        echo "</table>";

}
?>

</body>
</html>

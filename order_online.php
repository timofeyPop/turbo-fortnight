<!DOCTYPE html>
<html>
<head>
    <title>Клиент</title>
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style_main.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
<style>
    body{
        background-color: #99FFCC;
    }
 </style>
<header>
    <div class="bx bx-menu" id="menu-icon"></div>
    <ul class="navbar">
        <a href="listener.php">Выход</a>
    </ul>
</header>
<div class="Container">

<div class="menu-container">
            <!-- Box 1 -->
            <div class="box">
                <div class="box-img">
                    <img src="2.jpg" alt="">
                </div>
                <h2>Пицца 4 сыра</h2>
                <h3>Горгондзола, моцарелла,<br> фонтина и пармезан</h3>
                <span>От 600</span>
                <i class='bx bx-cart-alt'></i>
            </div>
            <!-- Box 2 -->
            <div class="box">
                <div class="box-img">
                    <img src="3.avif" alt="">

                </div>
                <h2>Пицца пеперони</h2>
                <h3>Cвинина,говядина,<br> паприка,острый перец</h3>
                <span>От 500</span>
                <i class='bx bx-cart-alt'></i>
            </div>
            <!-- Box 3 -->
            <div class="box">
                <div class="box-img">
                    <img src="5.jpg" alt="">
                </div>
                <h2>Пицца маргарита</h2>
                <h3>Дрожжевое тесто, оливковое масло,<br> томаты, листья базилика, моцарелла</h3>
                <span>От 550</span>
                <i class='bx bx-cart-alt'></i>
            </div>
        </div>  
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
        </div>
        <div id="order_items" class="form-row">
        <div class="col-md-3 mb-3">
                <select name="Name_pizza[]" class="form-control" required>
                    <option value="">Выберите пиццу</option>
                    <?php
                    $mysqli = new mysqli("localhost", "root", "", "deliverypizza");
                    if ($mysqli->connect_error) {
                        die("Ошибка подключения: " . $mysqli->connect_error);
                    }
                    $pizzaQuery = $mysqli->query("SELECT Name_pizza FROM pizza GROUP BY Name_pizza  ");
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
        <div class="form-row">
            <div class="col-md-3 mb-3">
                <button type="button" class="btn btn-secondary" onclick="addOrderItem()">Добавить товар</button>
            </div>
            <div class="col-md-3 mb-3">
                <button type="submit" name="add" class="btn btn-primary">Сделать заказ</button>
            </div>
        </div>
    </form>
</div>
</div>
</div>

<style>
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
</style>

<script>
function addOrderItem() {
    var orderItemsDiv = document.getElementById("order_items");
    var newOrderItem = document.createElement("div");
    newOrderItem.className = "form-row mb-3";
    newOrderItem.innerHTML = `
    <div class="col-md-3 mb-3">
                <select name="Name_pizza[]" class="form-control" required>
                    <option value="">Выберите пиццу</option>
                    <?php
                    $mysqli = new mysqli("localhost", "root", "", "deliverypizza");
                    if ($mysqli->connect_error) {
                        die("Ошибка подключения: " . $mysqli->connect_error);
                    }
                    $pizzaQuery = $mysqli->query("SELECT Name_pizza FROM pizza GROUP BY Name_pizza ");
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
        <div class="col-md-3 mb-3">
            <button type="button" class="btn btn-danger" onclick="removeOrderItem(this)">Удалить</button>
        </div>
    `;
    orderItemsDiv.appendChild(newOrderItem);
}

function removeOrderItem(button) {
    var orderItemDiv = button.parentNode.parentNode;
    orderItemDiv.parentNode.removeChild(orderItemDiv);
}
</script>

</body>
</html>
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
    $min = 30;
    $max = 100;
    $id = rand($min, $max);

    $namePizzas = $_POST['Name_pizza'];
    $sizes = $_POST['size'];
    $quantities = $_POST['Quantity'];
    $total = 0;

    $mysqli->begin_transaction();

    try {
        foreach ($namePizzas as $index => $namePizza) {
            $sizePizza = $sizes[$index];
            $quantity = $quantities[$index];

            $stmt = $mysqli->prepare("SELECT ID_Pizza FROM pizza JOIN size_pizza ON pizza.Size_ID = size_pizza.ID_size WHERE pizza.Name_pizza = ? AND size_pizza.size = ?");
            $stmt->bind_param("si", $namePizza, $sizePizza);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            $pizza = $product['ID_Pizza'];

            $stmt = $mysqli->prepare("SELECT Price_pizza FROM pizza WHERE ID_Pizza = ?");
            $stmt->bind_param("i", $pizza);
            $stmt->execute();
            $result = $stmt->get_result();
            $product1 = $result->fetch_assoc();
            $price = $product1['Price_pizza'];

            $orderSum = $price * $quantity;
            $total += $orderSum;

            $idd = rand($min, $max);
            $stmt = $mysqli->prepare("INSERT INTO pizza_check (ID_check, order_online_ID, Pizza_ID, Quantity) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $idd, $id, $pizza, $quantity);
            $stmt->execute();
        }

        $stmt = $mysqli->prepare("INSERT INTO order_online (ID_order_online, Surname, Name, Number, Address, Date_and_time, Sum_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssi", $id, $klientSurame, $klientName, $klientNumber, $klientAddress, $currentDateTime, $total);
        $stmt->execute();

        $mysqli->commit();
        echo "Заказ успешно создан с кодом заказа: $id";
        echo "<br><br><h2>Информация о заказе:</h2>";
        echo "<table class='table'>";
        echo "<tr><th>ID заказа</th><th>Фамилия клиента</th><th>Имя клиента</th><th>Номер телефона</th><th>Адрес</th><th>Дата и время заказа</th><th>Сумма заказа</th></tr>";
        echo "<tr><td>$id</td><td>$klientSurame</td><td>$klientName</td><td>$klientNumber</td><td>$klientAddress</td><td>$currentDateTime</td><td>$total</td></tr>";
        echo "</table>";

    } catch (Exception $e) {
        $mysqli->rollback();
        echo "Ошибка создания заказа: " . $e->getMessage();
    }

    $stmt->close();
}
$mysqli->close();

?>
</body>
</html>


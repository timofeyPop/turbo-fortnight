
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<header>
    <div class="bx bx-menu" id="menu-icon"></div>
    <ul class="navbar">
        <a href="listener.php">Выход</a>
    </ul>
</header>
</body>
</html>

<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $klientSurname = $_POST['Surname'];
    $klientName = $_POST['Name'];
    $klientNumber = $_POST['Number'];
    $klientAddress = $_POST['Address'];
    $currentDateTime = date('Y-m-d H:i:s');

    // Получаем максимальные значения ID_check и ID_order_online
    $resultCheck = $mysqli->query("SELECT MAX(ID_check) AS maxID_check FROM pizza_check");
    $rowCheck = $resultCheck->fetch_assoc();
    $nextID_check = $rowCheck['maxID_check'] + 1;

    $resultOrder = $mysqli->query("SELECT MAX(ID_order_online) AS maxID_order_online FROM order_online");
    $rowOrder = $resultOrder->fetch_assoc();
    $nextID_order_online = $rowOrder['maxID_order_online'] + 1;

    $namePizzas = $_POST['Name_pizza'];
    $prices = $_POST['Price_pizza'];
    $quantities = $_POST['Quantity'];
    $status = 1;
     // Добавлено получение размеров пицц из формы
    $total = 0;
    
    session_start();

    if (isset($_SESSION['number']) && $_SESSION['number'] == 2) {
        $_SESSION['number'] = 2;
        $empli =  2;
    } else {
        $_SESSION['number'] = 4;
        $empli =  4;
    }
    $mysqli->begin_transaction();

    try {
        foreach ($namePizzas as $index => $namePizza) {
            $price = $prices[$index];
            $quantity = $quantities[$index];
            // Размер пиццы

            // Обновленный запрос для получения ID_Pizza по названию пиццы и её размеру
            $stmt = $mysqli->prepare("
                SELECT p.ID_Pizza 
                FROM pizza p
                JOIN size_pizza s ON p.Size_ID = s.ID_size
                WHERE p.Name_pizza = ? AND Price_pizza = ?
            ");
            $stmt->bind_param("si", $namePizza, $price);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            $pizza = $product['ID_Pizza'];

            $orderSum = $price * $quantity;
            $total += $orderSum;

            $stmt = $mysqli->prepare("INSERT INTO pizza_check (ID_check, order_online_ID, Pizza_ID, Quantity) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $nextID_check, $nextID_order_online, $pizza, $quantity);
            $stmt->execute();
            $nextID_check++;
        }

        $stmt = $mysqli->prepare("INSERT INTO order_online (ID_order_online, Surname, Name, Number, Address, Date_and_time, Sum_order, status_ID, employees_id) VALUES (?, ?, ?, ?, ?, ?, ?,?,?)");
        $stmt->bind_param("isssssssi", $nextID_order_online, $klientSurname, $klientName, $klientNumber, $klientAddress, $currentDateTime, $total, $status, $empli);
        $stmt->execute();

        $mysqli->commit();
        echo "Заказ успешно создан с кодом заказа: $nextID_order_online";
        echo "<br><br><h2>Информация о заказе:</h2>";
        echo "<table class='table'>";
        echo "<tr><th>ID заказа</th><th>Фамилия клиента</th><th>Имя клиента</th><th>Номер телефона</th><th>Адрес</th><th>Дата и время заказа</th><th>Сумма заказа</th></tr>";
        echo "<tr><td>$nextID_order_online</td><td>$klientSurname</td><td>$klientName</td><td>$klientNumber</td><td>$klientAddress</td><td>$currentDateTime</td><td>$total</td></tr>";
        echo "</table>";
    } catch (Exception $e) {
        $mysqli->rollback();
        echo "Ошибка создания заказа: " . $e->getMessage();
    }

    $stmt->close();
}
$mysqli->close();
?>
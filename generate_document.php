
<?php
// Подключение к базе данных
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'deliverypizza';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получение ID заказа из URL
$order_id = $_GET['id'];

// Запрос к базе данных для получения заказа клиента
$sql = "SELECT * FROM order_online WHERE ID_order_online = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Создание текстового документа
    $filename = 'заказ_клиента_' . $order_id . '.txt';
    $file = fopen($filename, 'w');

    fwrite($file, "Заказ клиента:\n");
    fwrite($file, "--------------\n");
    fwrite($file, "Номер заказа: " . $row['ID_order_online'] . "\n");
    fwrite($file, "Фамилия: " . $row['Surname'] . "\n");
    fwrite($file, "Имя: " . $row['Name'] . "\n");
    fwrite($file, "Адрес: " . $row['Address'] . "\n");
    fwrite($file, "Номер телефона: " . $row['Number'] . "\n");
    fwrite($file, "Сумма заказа: " . $row['Sum_order'] . "\n");

    // Запрос к базе данных для получения информации о пиццах в заказе
    $pizzaSql = "
        SELECT p.Name_pizza, pc.Quantity, sz.size
        FROM pizza_check pc
        JOIN pizza p ON pc.Pizza_ID = p.ID_Pizza
        JOIN size_pizza sz ON p.Size_ID = sz.ID_size
        WHERE pc.order_online_ID = ?";
    $pizzaStmt = $conn->prepare($pizzaSql);
    $pizzaStmt->bind_param('i', $order_id);
    $pizzaStmt->execute();
    $pizzaResult = $pizzaStmt->get_result();

    if ($pizzaResult->num_rows > 0) {
        fwrite($file, "\nПиццы в заказе:\n");
        fwrite($file, "----------------\n");

        while ($pizzaRow = $pizzaResult->fetch_assoc()) {
            fwrite($file, "Название пиццы: " . $pizzaRow['Name_pizza'] . "\n");
            fwrite($file, "Размер: " . $pizzaRow['size'] . " см\n");
            fwrite($file, "Количество: " . $pizzaRow['Quantity'] . "\n");
            fwrite($file, "----------------\n");
        }
    } else {
        fwrite($file, "\nПиццы в заказе не найдены.\n");
    }
    
    fclose($file);

    // Вывод текстового документа
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($filename));
    header('Content-Length: ' . filesize($filename));
    readfile($filename);

    // Удаление файла после скачивания
    unlink($filename);
} else {
    echo "Заказ не найден";
}

// Закрытие соединения с базой данных
$stmt->close();
$conn->close();
?>
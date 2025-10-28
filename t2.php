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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Список клиентов</title>
  
  <div class="bx bx-menu" id="menu-icon"></div>
  <ul class="navbar">
      <a href="index2.php">Выход</a>
  </ul>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Список клиентов</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID заказа</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Документ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Запрос к базе данных для получения списка клиентов
            $sql = "SELECT ID_order_online, Surname, Name FROM order_online";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['ID_order_online']}</td>
                        <td>{$row['Surname']}</td>
                        <td>{$row['Name']}</td>
                        <td><a href='generate_document.php?id={$row['ID_order_online']}' class='btn btn-primary'>Создать документ</a></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Нет клиентов</td></tr>";
            }

            // Закрытие соединения с базой данных
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>
</body>
</html>


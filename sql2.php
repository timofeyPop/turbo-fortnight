<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Root</title>
  <link rel="stylesheet" href="2.css">
</head>
<body>


<header>
  
        <div class="bx bx-menu" id="menu-icon"></div>
        <ul class="navbar">
            <a href="index2.php">Выход</a>
            
        </ul>
    </header>
<?php
    $serverName = "localhost";
    $userName = "root";
    $password = "";
    $dbname = "deliverypizza";

          $conn = new mysqli($serverName, $userName, $password, $dbname);

          // Проверка подключения
          if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
          }

          

         
      
?>
<div class="sql-container">
        <form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
          <label class="sql-label" for="sql_query"><span class="sql-span">Введите SQL запрос:</span></label><br>
          <form method="post">
          <textarea id="myTextarea" name="sql_query" rows="4" cols="37" placeholder='Введите запрос'onChange='updateText("myInput")'><?= $_POST['sql_query']; ?></textarea><br>
             
          <div class="list">
  <h2>Готовые запросы</h2>
  <ul>
    <li><span><button onclick="autoFill()">Вывести имена курьеров и  их общее количество заказов</button></span></li>
    <li><span><button onclick="autoFill1()">Вывести выручку за каждый месяц</button></span></li>
    <li><span><button onclick="autoFill2()">Вывести среднее время доставки курьеров за первый месяц 2023 года</button></span></li>
    
  </ul>
</div>
          >
          

          
          <script>
function autoFill() {
    document.getElementById("myTextarea").value += "SELECT name_employees AS 'Имя курьера ', COUNT( * ) AS 'Количество заказов' FROM `order_online` JOIN employees ON order_online.employees_id = employees.ID_Employees GROUP BY employees_id";
}
</script>
<script>
function autoFill1() {
    document.getElementById("myTextarea").value += "SELECT MONTH( Date_order ) AS 'месяца', SUM( Sum_order ) AS 'Выручка за месяц' FROM `order_online` GROUP BY MONTH( Date_order )";
}
</script>
<script>
function autoFill2() {
    document.getElementById("myTextarea").value += "SELECT AVG_date AS 'Дата', AVG AS 'Среднее время доставки', name_employees AS 'Имя курьера' FROM avg_delivery JOIN employees ON employees.ID_Employees = avg_delivery.employees_id WHERE EXTRACT( MONTH FROM AVG_date ) = 1";
}
</script>

          </form>


          <?php

            //Функция вывода таблицы
            function getTable($result) {
              if ($result->num_rows > 0) {
                echo "<table class='table'><tr class='table__row'>";
                while ($fieldinfo = $result->fetch_field()) {
                  echo "<th class='table__heading'>".$fieldinfo->name."</th>";
                }
                echo "</tr>";
                while($row_data = $result->fetch_assoc()) {
                  echo "<tr class='table__row'>";
                    foreach ($row_data as $key => $value) {
                      echo "<td class='table__data'>".$value."</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
              }
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              switch (isset($_POST)) {

                
                // Вывод запроса
                case $_POST['sql_query']:
                  //Получение запроса из поля
                  $sql_query = $_POST['sql_query'];

                  // Проверка на то, что поле не пустое
                  if (!$sql_query) {
                    $sql_query = '#';
                  }

                  // Выполнение SQL запроса
                  $result = $conn->query($sql_query);

                  // Вывод результата запроса
                  echo "<h2 class='table__title'>Результат запроса:</h2>";
                  getTable($result);
                  break;
              }
            }

            // Закрытие соединения с базой данных
            $conn->close();
          ?>
    

        
        <section class="sql-table">
        </secton>
        <script>
            function fillText() {
            document.getElementById("myInput").value = "привет ";
            }

        </script>
        </form>
      </div>
      </body>
</html>
  
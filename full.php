<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Root</title>
  <link rel="stylesheet" href="1.css">
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

          // Запрос для получения списка таблиц в базе данных
          $sql_table_name = "SHOW TABLES FROM $dbname";
          $result_table_name = $conn->query($sql_table_name);
          
          // Формирование меню для выбора таблицы
          
          echo "<form class='.nav__form form' method='post' action='".$_SERVER['PHP_SELF']."'>";
        
        
          echo "<ul class='inside'>";
         
          while($row_table = $result_table_name->fetch_row()) {
            $table_name = $row_table[0];
            echo "<div class='wrapper'>";
            echo"<article class='flow'>";
            echo "<div class='list-container'>";
            echo "<li class='nav__item'><label class='form__label'><input class='nav__radio' type='radio' name='table' value='$table_name'><span class='nav__text'>$table_name</span></label></li>";
            echo "</div>";
            echo"</article>";
            echo "</div>";
          
          }
        
          echo "</ul>";
          echo "<input class='nav__button button' type='submit' value='Показать таблицу'>";
          echo "</form>";

         
      
?>

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

                // Вывод выбранной таблицы
                case $_POST['table']:
                  // Получение данных из поля
                  $selected_table = $_POST['table'];
                  $sql_data = "SELECT * FROM $selected_table";

                  // Выполнение запроса
                  $result_data = $conn->query($sql_data);

                  //Вывод результата
                  echo "<h2 class='table__title'>Таблица: $selected_table</h2>";
                  getTable($result_data);
                  break;

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
        
</body>
</html>

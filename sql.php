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
            <a href="sql2.php">Готовые запросы</a>
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
          <textarea name="sql_query" rows="4" cols="37" placeholder='Введите запрос'><?= $_POST['sql_query']; ?></textarea><br>
          <input class="button" type="submit" value="Выполнить запрос">    
         
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
    

        </form>
        <section class="sql-table">
        </secton>
      </div>
      </body>
</html>
  
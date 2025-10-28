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
          $sql = "SELECT ID_order_fact, klient.Surname, klient.Name, klient.Number ,Date_order, Sum_order FROM klient INNER JOIN order_fact ON order_fact.klient_ID = klient.ID_klient";
          $result = $conn->query($sql);
          if ($result->num_rows > 0){
            $data = array();
            while($row = $result->fetch_assoc()){
                $data[]= $row;
            }
          
         
        }
          else{
            echo "не кайф";
          }
          echo $json_data;
         

          // Формирование меню для выбора таблицы
          
    
            $conn->close();
          ?>
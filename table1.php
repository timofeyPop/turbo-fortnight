<!DOCTYPE html>
<html>
<head>
    <title>Pizza</title>
</head>
<body>
<header>
  
        <div class="bx bx-menu" id="menu-icon"></div>
        <ul class="navbar">
            <a href="index2.php">Выход</a>
        </ul>
    </header>
<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "deliverypizza";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
  }

// Обработка запроса на удаление клиента
if (isset($_GET['delete'])) {
    $pizzaId = $_GET['delete'];
    $sql = "DELETE FROM pizza WHERE ID_Pizza = $pizzaId";
    $conn->query($sql);
    
}

// Обработка запроса на добавление клиента
if (isset($_POST['add'])) {
    $pizzaId = $_POST['ID_Pizza'];
    $pizzaName = $_POST['Name_pizza'];
    $pizzaPrice = $_POST['Price_pizza'];
    $pizzaSize = $_POST['Size_ID'];
    $pizzaWeight = $_POST['Weight'];
   if ($pizzaSize ==33){
    $pizzaSize = 3;
   }
   elseif($pizzaSize == 25){
    $pizzaSize = 2;
   } 
   elseif($pizzaSize == 15){
    $pizzaSize = 1;
   };
    $sql = "INSERT INTO pizza (ID_Pizza, Name_pizza,Price_pizza, Size_ID,Weight) VALUES ( '$pizzaId','$pizzaName', '$pizzaPrice', '$pizzaSize', '$pizzaWeight')";
    $conn->query($sql);
    
}

// Обработка запроса на редактирование клиента
if (isset($_POST['save'])) {
    $pizzaId = $_POST['ID_Pizza'];
    $pizzaName = $_POST['Name_pizza'];
    $pizzaPrice = $_POST['Price_pizza'];
    $pizzaSize = $_POST['Size_ID'];
    $pizzaWeight = $_POST['Weight'];

    $sql = "UPDATE pizza SET  Name_pizza = '$pizzaName', Price_pizza = '$pizzaPrice', Size_ID = '$pizzaSize', Weight = '$pizzaWeight' WHERE ID_Pizza = $pizzaId";
    $conn->query($sql);
    

}

// Получение списка клиентов из базы данных
$sql = "SELECT * FROM pizza join size_pizza on pizza.Size_ID = size_pizza.ID_size";
$result = $conn->query($sql);
$pizzas = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<html>
<head>
  <!-- Подключение стилей Bootstrap -->
  <link rel="stylesheet" href="2.css">
</head>
<body>
  <div class="container">
    <h2>Таблица: Пицца</h2>

    <!-- Форма добавления/редактирования клиента -->
    <form class="form-style-8" method="POST" action="">
      <div class="form-row">
      <div class="col-md-3 mb-3">
          <input type="text" name="ID_Pizza" class="form-control" placeholder="Введите id" required>
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" name="Name_pizza" class="form-control" placeholder="Введите название пиццы" required>
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" name="Price_pizza" class="form-control" placeholder="Введите цену пиццы" required>
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" name="Size_ID" class="form-control" placeholder="Введите размер пиццы" required>
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" name="Weight" class="form-control" placeholder="Введите вес пиццы" required>
        </div> 
        <div class="col-md-3">
          <button type="submit" name="add" class="btn btn-primary">Добавить </button>
          <button type="submit" name="save" class="btn btn-primary">Сохранить</button>
        </div>
      </div>
    </form>

    <!-- Список клиентов -->
    <table border='1'>
    <tr>
<th>Название</th>
<th>Цена пиццы</th>
<th>Размер</th>
<th>Вес</th>
<th></th>
<th></th>
</tr>
    <ul class="list-group">
      <?php foreach ($pizzas as $client): ?>
        
          <div class="row">
           
            <div class="col-md-3">
            <td> <strong><?php echo $client['Name_pizza']; ?></strong>  </td>           
            </div>
            <div class="col-md-3">
            <td> <?php echo $client['Price_pizza']; ?></td>
            </div>
            <div class="col-md-3">
            <td>  <?php echo $client['size']; ?></td>
            </div>
            <div class="col-md-3">
            <td> <?php echo $client['Weight']; ?></td>
            </div>   
            <div class="col-md-3">
            <td> <a href="?delete=<?php echo $client['ID_Pizza']; ?>" class="btn btn-danger">Удалить</a></td>
            <td> <a href="#" onclick="editClient('<?php echo $client['ID_Pizza']; ?>', '<?php echo $client['Name_pizza']; ?>', '<?php echo $client['Price_pizza']; ?>', '<?php echo $client['size']; ?>', '<?php echo $client['Weight']; ?>')" class="btn btn-primary">Редактировать</a></td>
            </div>
      </tr>
          </div>
        
      <?php endforeach; ?>
    </ul>
  </div>

  <script>
    function editClient(id, Name_pizza, Price_pizza, Size_ID, Weight) {
        document.querySelector('input[name="ID_Pizza"]').value = id;
        document.querySelector('input[name="Name_pizza"]').value = Name_pizza;
        document.querySelector('input[name="Price_pizza"]').value = Price_pizza;
        document.querySelector('input[name="Size_ID"]').value = Size_ID;
        document.querySelector('input[name="Weight"]').value = Weight;
        
    }
  </script>

  <!-- Подключение скриптов Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>

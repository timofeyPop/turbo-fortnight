<!DOCTYPE html>
<html>
<head>
    <title>Клиент</title>
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
  
if (isset($_GET['delete'])) {
    $klientId = $_GET['delete'];
    $sql = "DELETE FROM klient WHERE ID_klient = $klientId";
    $conn->query($sql);
    
}

// Обработка запроса на добавление клиента
if (isset($_POST['add'])) {
    $klientId = $_POST['ID_klient'];
    $klientSurame = $_POST['Surname'];
    $klientName = $_POST['Name'];
    $klientAddress = $_POST['Address'];
    $klientEmail = $_POST['email'];
    $klientNumber = $_POST['Number'];
    $klientProgram = $_POST['program_loyalty_ID'];

    $sql = "INSERT INTO klient (ID_klient, Surname, Name, Address, email, Number, program_loyalty_ID) VALUES ( '$klientId','$klientSurame', '$klientName', '$klientAddress', '$klientEmail','$klientNumber','$klientProgram')";
    $conn->query($sql);
    
}

// Обработка запроса на редактирование клиента
if (isset($_POST['save'])) {
    $klientId = $_POST['ID_klient'];
    $klientSurame = $_POST['Surname'];
    $klientName = $_POST['Name'];
    $klientAddress = $_POST['Address'];
    $klientEmail = $_POST['email'];
    $klientNumber = $_POST['Number'];
    $klientProgram = $_POST['program_loyalty_ID'];

    $sql = "UPDATE klient SET  Surname = '$klientSurame', Name = '$klientName', Address = '$klientAddress', email = '$klientEmail', Number = '$klientNumber', program_loyalty_ID = '$klientProgram' WHERE ID_klient = $klientId ";
    $conn->query($sql);
    

}

// Получение списка клиентов из базы данных
$sql = "SELECT * FROM klient";
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
    <h2>Таблица:Клиенты</h2>

    <!-- Форма добавления/редактирования клиента -->
    <form class="form-style-8" method="POST" action="">
      <div class="form-row">
      <div class="col-md-3 mb-3">
          <input type="text" name="ID_klient" class="form-control" placeholder="Введите id" required>
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" name="Surname" class="form-control" placeholder="Введите Фамилию" required>
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" name="Name" class="form-control" placeholder="Введите Имя" required>
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" name="Address" class="form-control" placeholder="Введите адрес" required>
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" name="email" class="form-control" placeholder="Введите email" required>
        </div> 
        <div class="col-md-3 mb-3">
          <input type="text" name="Number" class="form-control" placeholder="Введите номер телефона" required>
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" name="program_loyalty_ID" class="form-control" placeholder="Введите программу лояльности " required>
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
<th>Фамилия</th>
<th>Имя</th>
<th>Адрес</th>
<th>email</th>
<th>Номер телефона</th>
<th>Программа лояльности</th>
<th></th>
<th></th>
</tr>
    <ul class="list-group">
      <?php foreach ($pizzas as $client): ?>
        
          <div class="row">
           
            <div class="col-md-3">
            <td> <strong><?php echo $client['Surname']; ?></strong>  </td>           
            </div>
            <div class="col-md-3">
            <td> <?php echo $client['Name']; ?></td>
            </div>
            <div class="col-md-3">
            <td>  <?php echo $client['Address']; ?></td>
            </div>
            <div class="col-md-3">
            <td> <?php echo $client['email']; ?></td>
            </div>   
            <div class="col-md-3">
            <td> <?php echo $client['Number']; ?></td>
            </div>  
            <div class="col-md-3">
            <td> <?php echo $client['program_loyalty_ID']; ?></td>
            </div>  
            <div class="col-md-3">
            <td> <a href="?delete=<?php echo $client['ID_klient']; ?>" class="btn btn-danger">Удалить</a></td>
            <td> <a href="#" onclick="editClient('<?php echo $client['ID_klient']; ?>', '<?php echo $client['Surname']; ?>', '<?php echo $client['Name']; ?>', '<?php echo $client['Address']; ?>', '<?php echo $client['email']; ?>', '<?php echo $client['Number']; ?>', '<?php echo $client['program_loyalty_ID']; ?>')" class="btn btn-primary">Редактировать</a></td>
            </div>
      </tr>
          </div>
        
      <?php endforeach; ?>
    </ul>
  </div>

  <script>
    function editClient(id, Surname, Name, Address, email, Number, program_loyalty_ID) {
        document.querySelector('input[name="ID_klient"]').value = id;
        document.querySelector('input[name="Surname"]').value = Surname;
        document.querySelector('input[name="Name"]').value = Name;
        document.querySelector('input[name="Address"]').value = Address;
        document.querySelector('input[name="email"]').value = email;
        document.querySelector('input[name="Number"]').value = Number;
        document.querySelector('input[name="program_loyalty_ID"]').value = program_loyalty_ID;
        
    }
  </script>

  <!-- Подключение скриптов Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
// Проверка наличия данных в форме 
if(isset($_POST['username']) && isset($_POST['password'])) { 
 $userName = $_POST['username']; 
 $password = $_POST['password']; 
 // Проведение проверки ролей 
 if($userName == 'root' && $password == '') { 
 // Перенаправление на страницу для пользователя "root" 
 header("Location: index2.php"); 
  } 
  elseif($userName == 'timofey' && $password == '123') { 
 // Перенаправление на страницу для пользователя "listeners" 
 
 header("Location: listener.php"); 
 
 } else { 
 echo "Неправильное имя пользователя или пароль"; 
 
 } 
} 
?> 
</body>
</html>

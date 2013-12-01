<html>
<head>
  <title>Результат загрузки файла</title>
</head>
<body>
<?php

ini_set("memory_limit", "32M");
session_start();

$host = "localhost";
$db = "mageia";
$login = "root";
$password = "newbsserver";

$desc = $_POST['desc'];
$arch = $_POST['arch'];

$connect = mysql_connect($host, $login, $password);
$select_db = mysql_select_db($db, $connect);

if ( !$connect )
   die ("Невозможно подключение к MySQL");
   mysql_select_db ( $db ) or die ("Невозможно открыть $db");
   
   // Вычисляем последний id загруженного пакета и плюсуем ему 1
   $id_pkg = mysql_query("select max(id) from `tsrc`;");
   if (!$id_pkg) {
       echo 'Ошибка запроса: ' . mysql_error();
           exit;
           }
    $id_pkg_max = mysql_fetch_row($id_pkg);
    $id_true = $id_pkg_max[0]+1;
    mkdir("/var/www/html/pbs/users/user1/srpms/$id_true/", 0700);
mysql_close ( $connect );



if($_FILES["filename"]["size"] > 1024*3*1024)
   {
     echo ("Размер файла превышает три мегабайта");
     exit;
   }
   // Проверяем загружен ли файл
if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
     // Если файл загружен успешно, перемещаем его
     // из временной директории в конечную
    move_uploaded_file($_FILES["filename"]["tmp_name"], "/var/www/html/pbs/users/user1/srpms/$id_true/".$_FILES["filename"]["name"]);

} else {
    echo("Ошибка загрузки файла");
   }

#$title  = addslashes ( $_FILES["filename"]["name"] ) ;

$connect = mysql_connect($host, $login, $password);
$select_db = mysql_select_db($db, $connect);

if ( !$connect )
   die ("Невозможно подключение к MySQL");
   mysql_select_db ( $db ) or die ("Невозможно открыть $db");
   
   // Вычисляем последний id загруженного пакета и плюсуем ему 1
   $id_pkg = mysql_query("select max(id) from `tsrc`;");
   if (!$id_pkg) {
       echo 'Ошибка запроса: ' . mysql_error();
           exit;
           }
    $id_pkg_max = mysql_fetch_row($id_pkg);
    $id_true = $id_pkg_max[0]+1;
   
   $query = "INSERT INTO `mageia`.`tsrc` (`id`, `user_id`, `filename`, `description`) VALUES (NULL, '2', '".$_FILES["filename"]["name"]."', '".$desc."')";
   $build = "INSERT INTO `mageia`.`jobs` (`id`, `file_id`, `platform_id`, `status`) VALUES (NULL, '".$id_true."', '".$arch."', '0');";

mysql_query ( $query );
mysql_query ( $build );
mysql_close ( $connect );

echo "Ваш временный репозиторий: <a href=http://pbs.mageialinux.ru:8090/users/user1/repo/>http://pbs.mageialinux.ru:8090/users/user1/repo</a>";
echo "<br>";
echo "Файл лога сборки: <a href=http://pbs.mageialinux.ru:8090/users/user1/logs/>http://pbs.mageialinux.ru:8090/users/user1/logs/</a></a>";

echo "<font size=4>Идет сборка!</font>";
?>
</body>
</html>

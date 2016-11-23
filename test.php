<?php
include 'Model/Database.php';
$objDb=new Database();
$objDb->connect();
$where ='all';
$result=$objDb->select('monhoc', $where);
foreach ($result as $value) {
    echo $value['ten']."<br>";
 echo "test";
<<<<<<< HEAD
 echo "echo";
=======
 echo "test";
>>>>>>> origin/master
}

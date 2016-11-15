<?php
include 'Model/Database.php';
$objDb=new Database();
$objDb->connect();
$where ='all';
$result=$objDb->select('monhoc', $where);
foreach ($result as $value) {
    echo $value['ten']."<br>";
}
<<<<<<< HEAD
echo "ABC";
=======
echo "string";
>>>>>>> parent of 113df7b... test2

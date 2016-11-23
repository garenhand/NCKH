<?php

$dir = 'pdfsample/';
$sample = 'demo.pdf';
include './Model/Database.php';
$objDb = new Database();
$objDb->connect();
$sql = 'SELECT ma FROM monhoc';
$result = $objDb->getlist($sql);
$lop = array(
    "58PM",
    "58CD",
    "58CA",
    "58BC",
    "58LO",
    "58TY",
    "58IK",
    "58PL",
    "58HJ",
    "59PM",
    "59KM",
    "59DS",
    "59DA",
    "59GF",
    "59DC",
    "59CA",
    "59SA",
    "59FF"
);
if ($result) {
    for ($i = 0; $i < 5000; $i++) {
        while (1) {
            $ma = $result[rand(0, 2000)]['ma'];
            $class = $lop[rand(0, 17)];
            $year = rand(2010, 2016);
            $term = rand(1, 3);
            $term = '0' . $term;
            $file = $dir . $ma . '_' . $class . '_' . $year . $term . '.pdf';
            if (copy($sample, $file)) {
                break;
                echo $file . '<br>';
            }
        }
    }
}

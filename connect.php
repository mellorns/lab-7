<?php
    error_reporting(E_ALL);

    $db_driver="mysql";
    $host = "localhost";
    $database = "car_rent";
    $dsn = "$db_driver:host=$host;dbname=$database";
    $user = 'root';
    $pass = "";
    try
    {
      $dbh = new PDO($dsn, $user, $pass);
    }
    catch (PDOException $ex)
    {
        print "Error!: " . $ex->getMessage() . "<br/>";
        exit();
    }
?>
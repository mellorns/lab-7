<?php
function costInDate(PDO $db, $date)
{
    $statement = $db->prepare("SELECT name, date_start, time_start, cost FROM cars INNER JOIN rent ON ID_Cars=FID_Car WHERE ? BETWEEN date_start and date_end");
    $statement->execute([$date]);
    $str = "<table style='text-align: center'>";
    $str .= " <tr>
         <th> Name  </th>
         <th> Cost </th>
        </tr> ";
    while ($data = $statement->fetch()) {
        $cost = (strtotime($date) - strtotime($data["date_start"]."T".$data["time_start"]))/3600*$data["cost"];
        $str .= " <tr>
             <td> {$data['name']}  </td>
             <td> {$cost} </td>
            </tr> ";
    }
    $str .= "</table>";
    echo $str;
}

function carByVendor(PDO $db, $vendor)
{
    $statement = $db->prepare("SELECT name, release_date, race FROM cars WHERE FID_Vendors=?");
    $statement->execute([$vendor]);
    $str = "<table style='text-align: center'>";
    $str .= " <tr>
         <th> Name  </th>
         <th> Release Date </th>
         <th> Race </th>
        </tr> ";
    while ($data = $statement->fetch()) {
        $str .= " <tr>
             <td> {$data['name']}  </td>
             <td> {$data['release_date']} </td>
             <td> {$data['race']} </td>
            </tr> ";
    }
    $str .= "</table>";
    echo json_encode($str);
}

function freeCarInDate(PDO $db, $free_car)
{
    $statement = $db->prepare("SELECT name, release_date, race FROM cars INNER JOIN rent ON ID_Cars=FID_Car WHERE ? NOT BETWEEN date_start and date_end");
    $statement->execute([$free_car]);
    $str = "<table style='text-align: center'>";
    $str .= " <tr>
         <th> Name  </th>
         <th> Release Date </th>
         <th> Race </th>
        </tr> ";
    while ($data = $statement->fetch()) {
        $str .= " <tr>
             <td> {$data['name']}  </td>
             <td> {$data['release_date']} </td>
             <td> {$data['race']} </td>
            </tr> ";
    }
    $str .= "</table>";
    echo $str;
}

$db = new PDO("mysql:host=127.0.0.1;dbname=car_rent", "root", "");

if (isset($_POST["date"])) {
    costInDate($db, $_POST["date"]);
} elseif (isset($_POST["vendor"])) {
    carByVendor($db, $_POST["vendor"]);
} elseif (isset($_POST["free_car"])) {
    freeCarInDate($db, $_POST["free_car"]);
}

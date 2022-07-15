<?php
$db = new PDO("mysql:host=127.0.0.1;dbname=car_rent", "root", "");

function vendors(PDO $db)
{
    $statement = $db->query("SELECT DISTINCT * FROM vendors");
    while ($data = $statement->fetch()) {
        echo "<option value='$data[0]'>$data[1]</option>";
    }
}

function cars(PDO $db)
{
    $statement = $db->query("SELECT DISTINCT ID_Cars, name FROM cars");
    while ($data = $statement->fetch()) {
        echo "<option value='$data[0]'>$data[1]</option>";
    }
}

function addCar($db, $car, $date_start, $date_end, $cost)
{
    $statement = $db->prepare("INSERT INTO rent (FID_Car, date_start, date_end, cost) VALUES (?, ?, ?, ?)");
    $statement->execute([$car, $date_start, $date_end, $cost]);
}

function updateRace($db, $car, $race)
{
    $statement = $db->prepare("UPDATE cars SET race = ? WHERE ID_Cars = ?");
    $statement->execute([$race, $car]);
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LB3</title>
    <script src="script.js"></script>
</head>
<body>
<form action="" method="post" id="date">
    <input type="datetime-local" name="date">
    <input type="submit"><br>
</form>

<form action="" method="post" id="vendor">
    <select name="vendor">
        <?php
        vendors($db);
        ?>
    </select>
    <input type="submit"><br>
</form>

<form action="" method="post" id="free_car">
    <input type="date" name="free_car">
    <input type="submit"><br>
</form>

<form action="" method="post">
    <select name="car">
        <?php
        cars($db);
        ?>
    </select>
    <input type="date" name="date_start">
    <input type="date" name="date_end">
    <input type="number" name="cost">
    <input type="submit"><br>
</form>

<form action="" method="post">
    <select name="carUpd">
        <?php
        cars($db);
        ?>
    </select>
    <input type="number" name="race">
    <input type="submit"><br>
</form>
<hr>
<div id="content"></div>
<?php
if (isset($_POST["car"])) {
    addCar($db, $_POST["car"], $_POST["date_start"], $_POST["date_end"], $_POST["cost"]);
} elseif (isset($_POST["carUpd"])) {
    updateRace($db, $_POST["carUpd"], $_POST["race"]);
}
?>
</body>
</html>


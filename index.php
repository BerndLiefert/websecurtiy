<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Security</title>

    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;

            background: #F54927;
        }

        input {
            border: none;
            padding: 20px;
            background: #F5B027;
            margin: 4px 0;
        }

        p {
            font-size: 1.2em;
            color: #FFFFFF;
        }

        form {
            text-align: right;
        }
    </style>
</head>

<body>
    <form method="GET" action="connect.php">
        <input name="username"><br>
        <input type="submit" value="Absenden">
    </form>
</body>

</html>
<?php
$host = 'localhost';
$dbname = 'xss';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    // PDO Fehler-Modus aktivieren
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindung fehlgeschlagen: " . $e->getMessage());
}

$sql = "SELECT username, comment FROM entries WHERE username = :username";
$stmt = $pdo->prepare($sql);

if (isset($_GET['username'])) {
    $stmt->bindValue(':username', trim($_GET['username']), PDO::PARAM_STR);

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
        //echo '<p>' . htmlspecialchars($row['username']) . ': ' . htmlspecialchars($row['comment']) . "</p>";
        echo '<p>' . $row['username'] . ': ' . $row['comment'] . "</p>";
    }
}

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'] ?? '';
    $loginName = $_POST['login_name'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $car = isset($_POST['car']) ? (int)$_POST['car'] : 0;
    $pc = isset($_POST['pc']) ? (int)$_POST['pc'] : 0;
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=kisprojekt;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO reg (nev, login_nev, jelszo, szerepkor, auto, pc, mobil, email)
                VALUES (:name, :loginName, :password, :role, :car, :pc, :phone, :email)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':loginName' => $loginName,
            ':password' => $password,
            ':role' => $role,
            ':car' => $car,
            ':pc' => $pc,
            ':phone' => $phone,
            ':email' => $email
        ]);

    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Adatbázis hiba: " . htmlspecialchars($e->getMessage()) . "</div>";
        exit;
    }

    $roleNames = [
        'felhasznalo' => 'felhasználó',
        'admin' => 'admin',
        'karbantarto' => 'karbantartó'
    ];
    $roleDisplay = $roleNames[$role] ?? $role;
    ?>
    <!DOCTYPE html>
    <html lang="hu">
    <head>
        <meta charset="UTF-8">
        <title>Regisztráció eredménye</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="container mt-5">

        <div class="alert alert-success">
            <h3>Sikeres regisztráció!</h3>
            <p>Az adatok bekerültek az adatbázisba.</p>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Az Ön adatai</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tr><th style="width: 200px;">Név:</th><td><?= htmlspecialchars($name) ?></td></tr>
                    <tr><th>Login név:</th><td><?= htmlspecialchars($loginName) ?></td></tr>
                    <tr><th>Jelszó:</th><td><?= htmlspecialchars($password) ?></td></tr>
                    <tr><th>Szerepkör:</th><td><?= htmlspecialchars($roleDisplay) ?></td></tr>
                    <tr><th>Autó:</th><td><?= $car ? 'van' : 'nincs' ?></td></tr>
                    <tr><th>PC:</th><td><?= $pc ? 'van' : 'nincs' ?></td></tr>
                    <tr><th>Mobil:</th><td><?= htmlspecialchars($phone) ?></td></tr>
                    <tr><th>Email:</th><td><?= htmlspecialchars($email) ?></td></tr>
                </table>
            </div>
        </div>

        <div class="mt-4 mb-5">
            <a href="reg.html" class="btn btn-primary">Új regisztráció</a>
        </div>

    </body>
    </html>
    <?php
}
?>
<?php
$servername = "localhost:";
$username = "root";
$password = "";
$dbname = "my_db";

try {
    // Connexion au serveur MySQL
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Création de la base de données
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $conn->exec($sql);
    // echo "Base de données créée avec succès<br>";

    // // Connexion à la base de données
    // $conn->exec("USE $dbname");

    // // Création de la table
    // $sql = "CREATE TABLE IF NOT EXISTS utilisateurs (
    //     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    //     nom VARCHAR(30) NOT NULL,
    //     prenom VARCHAR(30) NOT NULL,
    //     email VARCHAR(50),
    //     password VARCHAR(255) NOT NULL,
    //     reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    // )";
    $conn->exec($sql);
    echo "Table utilisateurs créée avec succès<br>";

    // Insertion des données avec confirmation de mot de passe
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $sex = isset($_POST['sex']) ? $_POST['sex'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $nationality = isset($_POST['nationality']) ? $_POST['nationality'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $cpassword = isset($_POST['cpassword']) ? $_POST['cpassword'] : '';

    if ($password === $cpassword) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare($sql);
        $stmt = $conn->prepare("INSERT INTO crea_compte (fname, lname, sex, phone, nationality, email,  Passwd) VALUES (?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssss", $fname, $lname, $sex, $phone, $nationality, $email, $hashed_password);
        $stmt->execute();
        echo "Nouvel enregistrement créé avec succès<br>";
    } else {
        echo "Les mots de passe ne correspondent pas<br>";
    }

    // Sélection des données
    $sql = "SELECT id, nom, prenom, email FROM utilisateurs";
    $stmt = $conn->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "id: " . $row['id'] . " - Nom: " . $row['nom'] . " - Prénom: " . $row['prenom'] . " - Email: " . $row['email'] . "<br>";
    }
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
$conn = null;
?>

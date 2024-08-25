<?php
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$conn = new mysqli('localhost','root','','loginatria');
if ($conn->connect_error) {
    die('Connection Failed : ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO atria (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password); 
    $stmt->execute();
    echo "Successful...";
    $stmt->close();
    $conn->close(); 
}
Header("Location: message.html");
?>;
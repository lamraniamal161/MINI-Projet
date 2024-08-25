<?php
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $sex = isset($_POST['sex']) ? $_POST['sex'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $nationality = isset($_POST['nationality']) ? $_POST['nationality'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $cpassword = isset($_POST['cpassword']) ? $_POST['cpassword'] : '';

    if ($password == $cpassword) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $conn = new mysqli('localhost:', 'root', '', 'mydb');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO crea_compte (fname, lname, sex, phone, email, nationality, passwrd) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fname, $lname, $sex, $phone, $nationality, $email, $hashed_password);

        if ($stmt->execute()) {
                echo "Successful registration";
        } else {
                echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Passwords do not match";
    }
?>



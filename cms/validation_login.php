<?php
$emailErr = "";
$passwordErr = "";
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = input_data($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid Email format";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = input_data($_POST["password"]);
        if (!preg_match("/^[a-zA-Z0-9_]*$/", $password)) {
            $passwordErr =
                "Only alphabets, numbers, and underscores are allowed for Password";
        }
    }
}

function input_data($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
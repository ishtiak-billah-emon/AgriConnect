<?php
session_start();
require_once('../model/database.php');

if (isset($_POST['submit'])) {
    // Sanitize and trim inputs
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $password = trim($_POST['password']);
    $retype_password = trim($_POST['retype_password']);
    $role = trim($_POST['role']);
    $country = trim($_POST['country']);
    $address = trim($_POST['address']);
    $dob = trim($_POST['dob']);

    // Check for empty fields
    if (
        empty($first_name) || empty($last_name) || empty($email) ||
        empty($mobile) || empty($password) || empty($retype_password) ||
        empty($role) || empty($country) || empty($address) || empty($dob)
    ) {
        echo "All fields are required!";
    } elseif ($password !== $retype_password) {
        echo "Passwords do not match!";
    } else {
        if (!isEmailUnique($email)) {
            echo "The email is already registered. Please use another email.";
        } else {
            $status = false;

            if ($role == 'Consumer') {
                $status = addConsumer($first_name, $last_name, $email, $mobile, $password, $country, $address, $dob, $role);
            } elseif ($role == 'Farmer') {
                $status = addFarmer($first_name, $last_name, $email, $mobile, $password, $country, $address, $dob);
            }

            if ($status) {
                header('location: ../view/login.html');
                exit();
            } else {
                echo "Registration failed. Please try again.";
            }
        }
    }
} else {
    header('location: ../view/reg.html');
    exit();
}
?>

<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $role     = $_POST['role'];
    
    if (empty($username) || empty($password) || empty($email) || empty($phone)) {
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Error</title>
                  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              </head>
              <body>
                  <script>
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'All fields are required!'
                      }).then(() => {
                          window.history.back();
                      });
                  </script>
              </body>
              </html>";
        exit();
    }
    
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM admin_instructor WHERE email = :email OR phone = :phone");
        $stmt->execute(['email' => $email, 'phone' => $phone]);
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            echo "<!DOCTYPE html>
                  <html lang='en'>
                  <head>
                      <meta charset='UTF-8'>
                      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                      <title>Error</title>
                      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                  </head>
                  <body>
                      <script>
                          Swal.fire({
                              icon: 'error',
                              title: 'Error',
                              text: 'Email or Phone already exists!'
                          }).then(() => {
                              window.history.back();
                          });
                      </script>
                  </body>
                  </html>";
            exit();
        }
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insertStmt = $conn->prepare("INSERT INTO admin_instructor (username, password, email, phone, role) VALUES (:username, :password, :email, :phone, :role)");
        $insertStmt->execute([
            'username' => $username,
            'password' => $hashed_password,
            'email'    => $email,
            'phone'    => $phone,
            'role'     => $role
        ]);
        
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Success</title>
                  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              </head>
              <body>
                  <script>
                      Swal.fire({
                          icon: 'success',
                          title: 'Success',
                          text: 'Instructor created successfully!'
                      }).then(() => {
                          window.location.href = 'admin_dashboard.html';
                      });
                  </script>
              </body>
              </html>";
        exit();
        
    } catch (PDOException $e) {
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Error</title>
                  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              </head>
              <body>
                  <script>
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'An error occurred: " . addslashes($e->getMessage()) . "'
                      }).then(() => {
                          window.history.back();
                      });
                  </script>
              </body>
              </html>";
        exit();
    }
} else {
    header('Location: admin_dashboard.html');
    exit();
}
?>

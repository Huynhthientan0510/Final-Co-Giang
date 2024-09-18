<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $course_name        = trim($_POST['course_name']);
    $course_description = trim($_POST['course_description']);
    $price              = trim($_POST['price']);
    
    // Validate inputs
    if (empty($course_name) || empty($course_description) || empty($price)) {
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
    
    if (!is_numeric($price) || $price < 0) {
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Invalid Price</title>
                  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              </head>
              <body>
                  <script>
                      Swal.fire({
                          icon: 'error',
                          title: 'Invalid Price',
                          text: 'Please enter a valid price.'
                      }).then(() => {
                          window.history.back();
                      });
                  </script>
              </body>
              </html>";
        exit();
    }
    
    try {
        // Insert the new course
        $stmt = $conn->prepare("INSERT INTO courses (course_name, course_description, price) VALUES (:course_name, :course_description, :price)");
        $stmt->execute([
            'course_name'        => $course_name,
            'course_description' => $course_description,
            'price'              => $price
        ]);
        
        // Success notification
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
                          text: 'Course added successfully!'
                      }).then(() => {
                          window.location.href = 'admin_dashboard.html';
                      });
                  </script>
              </body>
              </html>";
        exit();
        
    } catch (PDOException $e) {
        // Handle database errors
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
    // If not POST request, redirect to admin dashboard
    header('Location: admin_dashboard.html');
    exit();
}
?>

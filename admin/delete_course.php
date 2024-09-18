<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form input
    $identifier = trim($_POST['course_identifier']);
    
    if (empty($identifier)) {
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
                          text: 'Please provide a Course Name or ID.'
                      }).then(() => {
                          window.history.back();
                      });
                  </script>
              </body>
              </html>";
        exit();
    }
    
    try {
        // Check if identifier is a number (ID) or text (course name)
        if (is_numeric($identifier)) {
            // Delete by ID
            $stmt = $conn->prepare("DELETE FROM courses WHERE id = :identifier");
        } else {
            // Delete by course name
            $stmt = $conn->prepare("DELETE FROM courses WHERE course_name = :identifier");
        }
        
        $stmt->execute(['identifier' => $identifier]);
        
        // Check if any rows were affected
        if ($stmt->rowCount() > 0) {
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
                              title: 'Deleted!',
                              text: 'Course has been deleted successfully.'
                          }).then(() => {
                              window.location.href = 'admin_dashboard.html';
                          });
                      </script>
                  </body>
                  </html>";
            exit();
        } else {
            // No rows affected (course not found)
            echo "<!DOCTYPE html>
                  <html lang='en'>
                  <head>
                      <meta charset='UTF-8'>
                      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                      <title>Not Found</title>
                      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                  </head>
                  <body>
                      <script>
                          Swal.fire({
                              icon: 'error',
                              title: 'Not Found',
                              text: 'No course found with the provided Course Name or ID.'
                          }).then(() => {
                              window.history.back();
                          });
                      </script>
                  </body>
                  </html>";
            exit();
        }
        
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

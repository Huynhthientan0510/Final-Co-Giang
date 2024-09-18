<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input
    $identifier = trim($_POST['identifier']);
    
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
                          text: 'Please provide an Email or Phone.'
                      }).then(() => {
                          window.history.back();
                      });
                  </script>
              </body>
              </html>";
        exit();
    }
    
    try {
        // Determine if identifier is email or phone
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $stmt = $conn->prepare("SELECT * FROM admin_instructor WHERE email = :identifier AND role = 'instructor'");
        } else {
            $stmt = $conn->prepare("SELECT * FROM admin_instructor WHERE phone = :identifier AND role = 'instructor'");
        }
        
        $stmt->execute(['identifier' => $identifier]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Proceed to delete
            $deleteStmt = $conn->prepare("DELETE FROM admin_instructor WHERE id = :id");
            $deleteStmt->execute(['id' => $user['id']]);
            
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
                              text: 'Instructor has been deleted successfully.'
                          }).then(() => {
                              window.location.href = 'admin_dashboard.html';
                          });
                      </script>
                  </body>
                  </html>";
            exit();
        } else {
            // User not found
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
                              text: 'No instructor found with the provided Email or Phone.'
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

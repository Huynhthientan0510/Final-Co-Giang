<?php
session_start();
session_destroy();  // Destroy the session

// Optionally, clear localStorage via JavaScript
echo '<script>
        localStorage.removeItem("isLoggedIn");
        window.location.href = "index.html";
      </script>';
?>

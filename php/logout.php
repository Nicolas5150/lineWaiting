<?php
// Destroy the session.
session_destroy();
// Send user to login page
header("location: index.php");
?>

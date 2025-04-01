<?php
session_start();
session_unset();
session_destroy();
header("Location: server.html"); // Redirect to login page
exit();
?>

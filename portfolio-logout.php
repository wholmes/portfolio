<?php
session_start();
unset($_SESSION['portfolio_access']);
unset($_SESSION['access_time']);
header('Location: portfolio-access.php');
exit;
?>

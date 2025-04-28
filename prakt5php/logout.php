<?php
session_start();


session_unset();
session_destroy();


setcookie('remembered_email', '', time() - 3600, "/"); // Встановлюємо час закінчення в минуле

header("Location: index.php");
exit();
?>
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: register.php");
    exit();
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$rememberedEmail = isset($_COOKIE['remembered_email']) ? $_COOKIE['remembered_email'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Профіль користувача</title>
</head>
<body>
    <h2>Профіль користувача</h2>
    <p>Ім'я: <?php echo htmlspecialchars($username); ?></p>
    <p>Email: <?php echo htmlspecialchars($email); ?></p>

    <?php if ($rememberedEmail): ?>
        <p>Ваш email запам'ятали: <?php echo htmlspecialchars($rememberedEmail); ?></p>
    <?php endif; ?>

    <form method="post" action="logout.php">
        <button type="submit">Вийти</button>
    </form>
</body>
</html>
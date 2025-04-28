<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Увага: У реальному проєкті ніколи не зберігайте паролі в чистому вигляді!

    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;

    setcookie('remembered_email', $email, time() + (86400 * 7), "/"); // 86400 секунд в дні * 7 днів

    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Реєстрація</title>
</head>
<body>
    <h2>Реєстрація</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label for="username">Ім'я:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <br>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <br>
        <div>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <br>
        <button type="submit">Зареєструватися</button>
    </form>
</body>
</html>
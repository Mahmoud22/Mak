<?php
// Connect to the database
include('conn.php');

// Start session
session_start();

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database to find the user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Successful login, create session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to the dashboard or homepage
        header('Location: ../form.php');
        exit;
    } else {
        echo "<p class='error'>البيانات المدخلة غير صحيحة . يرجى التأكد من اسم المستخدم وكلمة المرور</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .login-container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .login-container p {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
        }

        .login-container label {
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: block;
        }

        .login-container input {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .login-container button {
            width: 100%;
            padding: 0.8rem;
            border: none;
            background-color: #007bff;
            color: #fff;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        .login-container .signup-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .login-container .signup-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-container .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>تسجيل الدخول</h1>
        <?php if (!empty($error)) echo "<p>$error</p>"; ?>
        <form method="POST" action="">
            <label for="username">اسم المستخدم</label>
            <input type="text" id="username" name="username" required>

            <label for="password">كلمة المرور</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">دخول</button>
        </form>
        <div class="signup-link">
            هل لديك حساب مسبق؟ <a href="register.php">تسجيل حساب</a>
        </div>
    </div>
</body>
</html>

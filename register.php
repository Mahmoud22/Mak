<?php
// Connect to the database
include('conn.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $id_number = $_POST['id_number'];
    
    // Check if the username already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    if ($stmt->rowCount() > 0) {
        echo "<p class='error'>Username already exists. Please choose a different one.</p>";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, password, mobile, id_number) VALUES (:username, :password, :mobile, :id_number)");
        $stmt->execute([
            'username' => $username,
            'password' => $hashedPassword,
            'mobile' => $mobile,
            'id_number' => $id_number
        ]);

        echo "<p class='success'>Registration successful. <a href='login.php'>Login here</a></p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .register-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .register-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .register-container button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .register-container button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        .success {
            color: green;
            font-size: 14px;
            margin-top: 10px;
        }

        a {
            text-decoration: none;
            color: #0056b3;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>تسجيل المستخدم</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="ادخل اسم المستخدم" required><br>
        <input type="password" name="password" placeholder="ادخل كلمة المرور" required><br>
        <input type="text" name="mobile" placeholder="ادخل رقم الجوال" required><br>
        <input type="text" name="id_number" placeholder="ادخل رقم الهوية" required><br>
        <button type="submit">تسجيل</button>
    </form>
</div>

</body>
</html>

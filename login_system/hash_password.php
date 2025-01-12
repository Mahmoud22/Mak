<?php
$passwords = ['testpassword1', 'testpassword2', 'mypassword123', 'admin123'];

foreach ($passwords as $password) {
    echo "Password: $password => Hash: " . password_hash($password, PASSWORD_BCRYPT) . "<br>";
}
?>

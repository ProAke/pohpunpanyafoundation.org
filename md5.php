<?php
$password = "!Q2w3e4r5t6y7u8i";
$hashed_password = md5($password);

echo "Original password: " . $password . "<br>";
echo "MD5 hashed password: " . $hashed_password;
?>

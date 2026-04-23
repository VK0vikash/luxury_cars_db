<?php
$password = 'admin123'; // Your desired password
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash for '$password':<br>";
echo "<strong>$hash</strong>";
?>
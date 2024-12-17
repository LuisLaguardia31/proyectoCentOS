<?php
try {
    $pdo = new PDO("mysql:unix_socket=/var/lib/mysql/mysql.sock;dbname=foroplatosLuisLaguardia", "admin", "admin");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

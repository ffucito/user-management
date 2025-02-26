<?php
// Configurazione Database
$servername = "mysql_db";
$username = "admin";
$password = "adminpassword";
$dbname = "user_management";

// Connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ricezione dati dalla richiesta POST
$name = $_POST['name'];
$email = $_POST['email'];
$raw_password = $_POST['password'];

// Verifica se l'email è già registrata
$check_sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Error: Email already in use!";
} else {
    // Crittografia della password con bcrypt
    $hashed_password = password_hash($raw_password, PASSWORD_BCRYPT);

    // Inserimento nel database
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Chiudere connessione
$stmt->close();
$conn->close();
?>

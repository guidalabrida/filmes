<?php
$conn = new mysqli('localhost', 'root', '', 'busca_filmes');

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);  // Criptografando a senha

    // Verifica se o e-mail já está cadastrado
    $sql_verifica_email = "SELECT id FROM usuarios WHERE email = '$email'";
    $resultado = $conn->query($sql_verifica_email);

    if ($resultado->num_rows > 0) {
        echo "E-mail já cadastrado. Tente outro.";
    } else {
        // Inserindo os dados no banco de dados
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

        if ($conn->query($sql) === TRUE) {
            header('Location: login.php');  // Redireciona para a página de login
            exit();
        } else {
            echo "Erro ao cadastrar: " . $conn->error;
        }
    }
}

$conn->close();
?>

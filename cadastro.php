<?php

include_once("conexao.php");

if ($conexao->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
}

// Processamento do formulário de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $nickname = $_POST["nickname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordC = $_POST["passwordC"];

    // Verificar se o nickname já existe no banco de dados
    $checkNicknameQuery = "SELECT id FROM usuarios WHERE nickname = '$nickname'";
    $result = $conexao->query($checkNicknameQuery);

    if ($result->num_rows > 0) {
        echo "Este Nome de Usuário já existe.";
    } else {
        // Validação e inserção no banco de dados
        if ($password !== $passwordC) {
            echo "As senhas não coincidem. Tente novamente.";
        } else {
            $sql = "INSERT INTO usuarios (name, lastname, nickname, email, password) VALUES ('$name', '$lastname', '$nickname', '$email', '$password')";

            if ($conexao->query($sql) === TRUE) {
                // Redireciona para a página "chooseGame.html" após o registro bem-sucedido
                header("Location: chooseGame.html");
                exit();
            } else {
                echo "Erro ao inserir no banco de dados. Tente novamente.";
            }
        }
    }
}

$conexao->close();

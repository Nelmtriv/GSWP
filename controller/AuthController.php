<?php
require_once __DIR__ . '/Conexao.php';
session_start();

$conexao = new Conexao();
$conn = $conexao->getConexao();

$erro = "";

try {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $email = $_POST["email"] ?? "";
        $senha = $_POST["senha"] ?? "";

        if ($email == "" || $senha == "") {
            throw new Exception("Preencha os campos");
        }

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {

            if (password_verify($senha, $row["senha"])) {

                $_SESSION["usuario"] = $row["nome"];

                header("Location: /GSWP/controller/VendedorController.php");
                exit;
            }
        }

        throw new Exception("Login inválido");
    }

} catch (Exception $e) {
    $erro = $e->getMessage();
}

require __DIR__ . '/../view/auth/login.php';

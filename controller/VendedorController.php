<?php
require_once __DIR__ . '/Conexao.php';
require_once __DIR__ . '/../model/Vendedor.php';

$conexao = new Conexao();
$conn = $conexao->getConexao();

$editarVendedor = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {

    $acao = $_POST['acao'];

    if ($acao === 'adicionar') {

        $codigo = $_POST['codigo'];
        $nome = $_POST['nome'];
        $contacto = $_POST['contacto'];
        $quantidade = $_POST['quantidade'];
        $diasTrabalhados = $_POST['diasTrabalhados'];
        $salarioDiario = $_POST['salarioDiario'];

        $bonus = 0;
        if ($quantidade >= 50) $bonus = $salarioDiario * 0.5;
        else if ($quantidade >= 25) $bonus = $salarioDiario * 0.25;
        else if ($quantidade >= 10) $bonus = $salarioDiario * 0.1;

        $stmt = $conn->prepare(
            "INSERT INTO vendedores 
            (codigo, nome, contacto, quantidade, diasTrabalhados, salarioDiario, bonusDiario)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "issiidd",
            $codigo,
            $nome,
            $contacto,
            $quantidade,
            $diasTrabalhados,
            $salarioDiario,
            $bonus
        );

        $stmt->execute();
    }

    if ($acao === 'editar') {

        $codigo = $_POST['codigo'];

        $stmt = $conn->prepare("SELECT * FROM vendedores WHERE codigo = ?");
        $stmt->bind_param("i", $codigo);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $editarVendedor = new Vendedor(
                $row['codigo'],
                $row['nome'],
                $row['contacto'],
                '',
                '',
                0,
                $row['quantidade'],
                $row['diasTrabalhados'],
                $row['salarioDiario'],
                $row['bonusDiario']
            );
        }
    }

    if ($acao === 'atualizar') {

        $codigo = $_POST['codigo'];
        $nome = $_POST['nome'];
        $contacto = $_POST['contacto'];
        $quantidade = $_POST['quantidade'];
        $diasTrabalhados = $_POST['diasTrabalhados'];
        $salarioDiario = $_POST['salarioDiario'];

        $bonus = 0;
        if ($quantidade >= 50) $bonus = $salarioDiario * 0.5;
        else if ($quantidade >= 25) $bonus = $salarioDiario * 0.25;
        else if ($quantidade >= 10) $bonus = $salarioDiario * 0.1;

        $stmt = $conn->prepare(
            "UPDATE vendedores 
             SET nome=?, contacto=?, quantidade=?, diasTrabalhados=?, salarioDiario=?, bonusDiario=?
             WHERE codigo=?"
        );

        $stmt->bind_param(
            "ssiiddi",
            $nome,
            $contacto,
            $quantidade,
            $diasTrabalhados,
            $salarioDiario,
            $bonus,
            $codigo
        );

        $stmt->execute();
    }

    if ($acao === 'remover') {

        $codigo = $_POST['codigo'];

        $stmt = $conn->prepare("DELETE FROM vendedores WHERE codigo = ?");
        $stmt->bind_param("i", $codigo);
        $stmt->execute();
    }
}

$vendedores = [];

$result = $conn->query("SELECT * FROM vendedores ORDER BY codigo");

while ($row = $result->fetch_assoc()) {
    $vendedores[] = new Vendedor(
        $row['codigo'],
        $row['nome'],
        $row['contacto'],
        '',
        '',
        0,
        $row['quantidade'],
        $row['diasTrabalhados'],
        $row['salarioDiario'],
        $row['bonusDiario']
    );
}

require __DIR__ . '/../view/vendedor/index.php';

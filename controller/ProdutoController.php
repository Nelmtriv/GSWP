<?php
require_once __DIR__ . '/Conexao.php';
require_once __DIR__ . '/../model/Produto.php';

class ProdutoController {

    public static function listarProdutos(): array {
        $con = new Conexao();
        $conn = $con->getConexao();

        $result = mysqli_query($conn, "SELECT * FROM Produtos");
        $produtos = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $dataValidade = $row['data_validade'] ?? '';

            $produtos[] = new Produto(
                (int)$row['codigo_produto'],
                $row['nome'],
                $row['unidade_medida'],
                (float)$row['quantidade'],
                (float)$row['preco_unitario'],
                $dataValidade
            );
        }

        mysqli_close($conn);
        return $produtos;
    }
}

$con = new Conexao();
$conn = $con->getConexao();

$editarProduto = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {

    $acao = $_POST['acao'];

    if ($acao === 'cadastrar') {

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO Produtos (nome, unidade_medida, quantidade, preco_unitario, data_validade)
             VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssdds",
            $_POST['nome'],
            $_POST['unidadeMedida'],
            $_POST['quantidade'],
            $_POST['precoUnitario'],
            $_POST['dataValidade']
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    if ($acao === 'editar') {

        $codigo = $_POST['codigo'];

        $stmt = mysqli_prepare(
            $conn,
            "SELECT * FROM Produtos WHERE codigo_produto = ?"
        );

        mysqli_stmt_bind_param($stmt, "i", $codigo);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $editarProduto = new Produto(
                (int)$row['codigo_produto'],
                $row['nome'],
                $row['unidade_medida'],
                (float)$row['quantidade'],
                (float)$row['preco_unitario'],
                $row['data_validade'] ?? ''
            );
        }

        mysqli_stmt_close($stmt);
    }

    if ($acao === 'atualizar') {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE Produtos
             SET nome = ?, unidade_medida = ?, quantidade = ?, preco_unitario = ?, data_validade = ?
             WHERE codigo_produto = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssddsi",
            $_POST['nome'],
            $_POST['unidadeMedida'],
            $_POST['quantidade'],
            $_POST['precoUnitario'],
            $_POST['dataValidade'],
            $_POST['codigo']
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    if ($acao === 'remover') {

        $stmt = mysqli_prepare(
            $conn,
            "DELETE FROM Produtos WHERE codigo_produto = ?"
        );

        mysqli_stmt_bind_param($stmt, "i", $_POST['codigo']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);

$produtos = ProdutoController::listarProdutos();
$editarProduto = $editarProduto ?? null;

require __DIR__ . '/../view/produto/index.php';

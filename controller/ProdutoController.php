<?php
require_once __DIR__ . '/Conexao.php';
require_once __DIR__ . '/../model/Produto.php';

class ProdutoController
{

    public static function listarProdutos(): array
    {
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

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {

        $acao = $_POST['acao'];

        if ($acao === 'cadastrar') {

            $nome = trim($_POST['nome']);
            $unidade = trim($_POST['unidadeMedida']);
            $quantidade = (float)$_POST['quantidade'];
            $preco = (float)$_POST['precoUnitario'];
            $dataValidade = $_POST['dataValidade'] ?? null;

            $unidadesValidas = ["kg", "g", "l", "ml"];

            if (!in_array($unidade, $unidadesValidas)) {
                throw new Exception("Unidade de medida inválida");
            }


            if ($nome === "" || $unidade === "") {
                throw new Exception("Preencha todos os campos obrigatórios");
            }

            if ($quantidade < 0) {
                throw new Exception("Quantidade não pode ser negativa");
            }

            if ($preco <= 0) {
                throw new Exception("Preço deve ser maior que 0");
            }



            if (!empty($dataValidade)) {

                $hoje = date("Y-m-d");

                if ($dataValidade < $hoje) {
                    throw new Exception("Data de validade não pode ser no passado");
                }
            }


            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO Produtos (nome, unidade_medida, quantidade, preco_unitario, data_validade)
             VALUES (?, ?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssdds",
                $nome,
                $unidade,
                $quantidade,
                $preco,
                $dataValidade
            );

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Erro ao cadastrar produto");
            }

            mysqli_stmt_close($stmt);

            header("Location: ProdutoController.php?ok=1");
            exit;
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

            $codigo = $_POST['codigo'];
            $nome = trim($_POST['nome']);
            $unidade = trim($_POST['unidadeMedida']);
            $quantidade = (float)$_POST['quantidade'];
            $preco = (float)$_POST['precoUnitario'];
            $dataValidade = $_POST['dataValidade'] ?? null;

            $unidadesValidas = ["kg", "g", "l", "ml"];

            if (!in_array($unidade, $unidadesValidas)) {
                throw new Exception("Unidade de medida inválida");
            }

            if ($nome === "" || $unidade === "") {
                throw new Exception("Preencha todos os campos");
            }

            if ($quantidade < 0) {
                throw new Exception("Quantidade inválida");
            }

            if ($preco <= 0) {
                throw new Exception("Preço deve ser maior que 0");
            }


            if (!empty($dataValidade)) {
                $hoje = date("Y-m-d");

                if ($dataValidade < $hoje) {
                    throw new Exception("Data de validade não pode ser no passado");
                }
            }


            $stmt = mysqli_prepare(
                $conn,
                "UPDATE Produtos
             SET nome = ?, unidade_medida = ?, quantidade = ?, preco_unitario = ?, data_validade = ?
             WHERE codigo_produto = ?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssddsi",
                $nome,
                $unidade,
                $quantidade,
                $preco,
                $dataValidade,
                $codigo
            );

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Erro ao atualizar");
            }

            mysqli_stmt_close($stmt);

            header("Location: ProdutoController.php?ok=2");
            exit;
        }

        if ($acao === 'remover') {

            $stmt = mysqli_prepare(
                $conn,
                "DELETE FROM Produtos WHERE codigo_produto = ?"
            );

            mysqli_stmt_bind_param($stmt, "i", $_POST['codigo']);

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Erro ao remover");
            }

            mysqli_stmt_close($stmt);

            header("Location: ProdutoController.php?ok=3");
            exit;
        }
    }
} catch (Exception $e) {
    header("Location: ProdutoController.php?erro=" . $e->getMessage());
    exit;
}

mysqli_close($conn);

$produtos = ProdutoController::listarProdutos();
$editarProduto = $editarProduto ?? null;

require __DIR__ . '/../view/produto/index.php';

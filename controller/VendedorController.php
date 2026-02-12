<?php
require_once __DIR__ . '/Conexao.php';
require_once __DIR__ . '/../model/Vendedor.php';

$conexao = new Conexao();
$conn = $conexao->getConexao();

$editarVendedor = null;

$mensagemErro = "";
$mensagemOk = "";
$acao = $_POST['acao'] ?? null;

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {

        if ($acao === 'adicionar') {

            $codigo = $_POST['codigo'];
            $nome = $_POST['nome'];
            $contacto = $_POST['contacto'];
            $genero = $_POST['genero'];
            $estadoCivil = $_POST['estadoCivil'];
            $codigo_produto = $_POST['codigo_produto'];
            $quantidade = $_POST['quantidade'];
            $diasTrabalhados = $_POST['diasTrabalhados'];
            $salarioDiario = $_POST['salarioDiario'];

            if (empty($codigo) || empty($nome) || empty($contacto) || empty($quantidade)) {
                throw new Exception("Preencha todos os campos");
            }
            if(empty($genero) || empty($estadoCivil)){
    throw new Exception("Selecione género e estado civil");
}


            $stockQuery = $conn->prepare("SELECT quantidade FROM Produtos WHERE codigo_produto=?");
            $stockQuery->bind_param("i", $codigo_produto);
            $stockQuery->execute();
            $stockQuery->bind_result($stockAtual);
            $stockQuery->fetch();
            $stockQuery->close();

            if ($quantidade > $stockAtual) {
                throw new Exception("Quantidade maior que o stock disponível");
            }

            $check = $conn->prepare("SELECT codigo FROM vendedores WHERE codigo=?");
            $check->bind_param("i", $codigo);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                throw new Exception("Código já existe");
            }

            $bonus = 0;
            if ($quantidade >= 50) $bonus = $salarioDiario * 0.5;
            else if ($quantidade >= 25) $bonus = $salarioDiario * 0.25;
            else if ($quantidade >= 10) $bonus = $salarioDiario * 0.1;

            $stmt = $conn->prepare(
"INSERT INTO vendedores 
(codigo, nome, contacto, genero, estadoCivil, codigo_produto, quantidade, diasTrabalhados, salarioDiario, bonusDiario)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);


            $stmt->bind_param(
"issssiiidd",
$codigo,
$nome,
$contacto,
$genero,
$estadoCivil,
$codigo_produto,
$quantidade,
$diasTrabalhados,
$salarioDiario,
$bonus
);


            if (!$stmt->execute()) {
                throw new Exception("Erro ao salvar vendedor");
            }

            $novoStock = $stockAtual - $quantidade;

            $updateStock = $conn->prepare("UPDATE Produtos SET quantidade=? WHERE codigo_produto=?");
            $updateStock->bind_param("di", $novoStock, $codigo_produto);
            $updateStock->execute();
        }


        if ($acao === 'atualizar') {

            $codigo = $_POST['codigo'];
            $nome = $_POST['nome'];
            $contacto = $_POST['contacto'];
            $genero = $_POST['genero'];
            $estadoCivil = $_POST['estadoCivil'];
            $codigo_produto = $_POST['codigo_produto'];
            $quantidade = $_POST['quantidade'];
            $diasTrabalhados = $_POST['diasTrabalhados'];
            $salarioDiario = $_POST['salarioDiario'];

            if (empty($nome) || empty($contacto)) {
                throw new Exception("Preencha todos os campos");
            }

            $bonus = 0;
            if ($quantidade >= 50) $bonus = $salarioDiario * 0.5;
            else if ($quantidade >= 25) $bonus = $salarioDiario * 0.25;
            else if ($quantidade >= 10) $bonus = $salarioDiario * 0.1;

            $stmt = $conn->prepare(
"UPDATE vendedores 
SET nome=?, contacto=?, genero=?, estadoCivil=?, codigo_produto=?, quantidade=?, diasTrabalhados=?, salarioDiario=?, bonusDiario=?
WHERE codigo=?"
);


    $stmt->bind_param(
"ssssiiiddi",
$nome,
$contacto,
$genero,
$estadoCivil,
$codigo_produto,
$quantidade,
$diasTrabalhados,
$salarioDiario,
$bonus,
$codigo
);


            if (!$stmt->execute()) {
                throw new Exception("Erro ao atualizar");
            }
        }

        if ($acao === 'remover') {

            $codigo = $_POST['codigo'];

            $stmt = $conn->prepare("DELETE FROM vendedores WHERE codigo = ?");
            $stmt->bind_param("i", $codigo);

            if (!$stmt->execute()) {
                throw new Exception("Erro ao remover");
            }
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
$row['genero'],
$row['estadoCivil'],
$row['codigo_produto'],
$row['quantidade'],
$row['diasTrabalhados'],
$row['salarioDiario']
);

            }
        }
    }
} catch (Exception $e) {
    $mensagemErro = $e->getMessage();
}

$result = $conn->query("
SELECT v.*, p.nome AS nome_produto
FROM vendedores v
LEFT JOIN Produtos p ON p.codigo_produto = v.codigo_produto
ORDER BY v.codigo
");


$vendedores = [];

while ($row = $result->fetch_assoc()) {

    $vendedores[] = [
        "vendedor" => new Vendedor(
            (int)$row['codigo'],
            $row['nome'],
            $row['contacto'],
            $row['genero'] ?? '',
            $row['estadoCivil'] ?? '',
            (int)$row['codigo_produto'],
            (int)$row['quantidade'],
            (int)$row['diasTrabalhados'],
            (float)$row['salarioDiario']
        ),
        "nome_produto" => $row['nome_produto']
    ];
}



$listaProdutos = [];

$res = $conn->query("SELECT codigo_produto, nome, quantidade FROM Produtos");

while ($p = $res->fetch_assoc()) {
    $listaProdutos[] = $p;
}


require __DIR__ . '/../view/vendedor/index.php';

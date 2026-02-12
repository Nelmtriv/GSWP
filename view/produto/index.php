<?php
$produtos = $produtos ?? [];
$editarProduto = $editarProduto ?? null;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Produtos</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f7fb;
            margin: 0;
        }

        .container {
            width: 95%;
            margin: auto;
            padding: 20px;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-nav {
            padding: 12px 22px;
            background: #2a9d8f;
            color: #fff;
            text-decoration: none;
            border-radius: 20px;
            font-weight: bold;
        }

        .form-box {
            background: #ffffff;
            padding: 18px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.07);
            margin-bottom: 22px;
        }

        .form-row {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
        }

        .form-row input {
            flex: 1;
            padding: 9px 10px;
            border-radius: 9px;
            border: 1px solid #ccc;
            font-size: 13px;
        }

        .form-actions {
            text-align: right;
        }

        .form-actions button {
            padding: 9px 18px;
            border-radius: 18px;
            border: none;
            background: #2a9d8f;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-cancel {
            padding: 9px 18px;
            border-radius: 18px;
            border: none;
            background: #999;
            color: #fff;
            cursor: pointer;
            font-size: 13px;
            margin-right: 8px;
            text-decoration: none;
        }

        .table-box {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.07);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead {
            background: #2a9d8f;
            color: #fff;
        }

        th {
            padding: 9px;
            font-weight: 600;
        }

        td {
            padding: 8px;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background: #f3f6fb;
        }

        .ops {
            white-space: nowrap;
        }

        .ops form {
            display: flex;
            gap: 6px;
            justify-content: center;
        }

        .btn-edit {
            padding: 5px 10px;
            border-radius: 14px;
            border: none;
            background: #3f72af;
            color: #fff;
            cursor: pointer;
            font-size: 12px;
        }

        .btn-remove {
            padding: 5px 10px;
            border-radius: 14px;
            border: none;
            background: #e63946;
            color: #fff;
            cursor: pointer;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="top">
        <h1>Sistema de Produtos</h1>
        <a href="../controller/VendedorController.php" class="btn-nav">Vendedores</a>
    </div>

    <div class="form-box">
        <form method="post" action="../controller/ProdutoController.php">
            <div class="form-row">
                <input type="hidden" name="codigo"
                       value="<?= $editarProduto ? $editarProduto->getCodigo() : '' ?>">

                <input type="text" name="nome"
                       placeholder="Nome do Produto"
                       value="<?= $editarProduto ? $editarProduto->getNome() : '' ?>"
                       required>

                <input type="text" name="unidadeMedida"
                       placeholder="Unidade de Medida"
                       value="<?= $editarProduto ? $editarProduto->getUnidadeMedida() : '' ?>"
                       required>

                <input type="number" step="0.01" name="quantidade"
                       placeholder="Quantidade"
                       value="<?= $editarProduto ? $editarProduto->getQuantidade() : '' ?>"
                       required>
            </div>

            <div class="form-row">
                <input type="number" step="0.01" name="precoUnitario"
                       placeholder="Preço Unitário"
                       value="<?= $editarProduto ? $editarProduto->getPrecoUnitario() : '' ?>"
                       required>

                <input type="date" name="dataValidade"
                       value="<?= $editarProduto ? $editarProduto->getDataValidade() : '' ?>"
                       required>
            </div>

            <div class="form-actions">
                <?php if ($editarProduto): ?>
                    <a href="../controller/ProdutoController.php" class="btn-cancel">Cancelar</a>
                <?php endif; ?>

                <button type="submit" name="acao"
                        value="<?= $editarProduto ? 'atualizar' : 'cadastrar' ?>">
                    <?= $editarProduto ? 'Atualizar Produto' : 'Adicionar Produto' ?>
                </button>
            </div>
        </form>
    </div>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Unidade</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Validade</th>
                    <th>Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><?= $p->getCodigo() ?></td>
                    <td><?= $p->getNome() ?></td>
                    <td><?= $p->getUnidadeMedida() ?></td>
                    <td><?= $p->getQuantidade() ?></td>
                    <td><?= $p->getPrecoUnitario() ?></td>
                    <td><?= $p->getDataValidade() ?></td>
                    <td class="ops">
                        <form method="post" action="../controller/ProdutoController.php">
                            <input type="hidden" name="codigo" value="<?= $p->getCodigo() ?>">
                            <button class="btn-edit" name="acao" value="editar">Editar</button>
                            <button class="btn-remove" name="acao" value="remover">Remover</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>

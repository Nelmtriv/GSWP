<?php
$vendedores = $vendedores ?? [];
$editarVendedor = $editarVendedor ?? null;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Vendedores</title>
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
            background: #1f3c88;
            color: #fff;
            text-decoration: none;
            border-radius: 20px;
            font-weight: bold;
        }

        .form-box {
            background: #ffffff;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-row input {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .form-actions {
            text-align: right;
        }

        .form-actions button {
            padding: 10px 20px;
            border-radius: 20px;
            border: none;
            background: #1f3c88;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

        .table-box {
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead {
            background: #1f3c88;
            color: #fff;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background: #f4f7fb;
        }

        .ops form {
            display: flex;
            gap: 6px;
            justify-content: center;
        }

        .btn-edit {
            padding: 6px 12px;
            border-radius: 14px;
            border: none;
            background: #3f72af;
            color: #fff;
            cursor: pointer;
            font-size: 12px;
        }

        .btn-remove {
            padding: 6px 12px;
            border-radius: 14px;
            border: none;
            background: #e63946;
            color: #fff;
            cursor: pointer;
            font-size: 12px;
        }

        .btn-cancel {
            padding: 6px 12px;
            border-radius: 14px;
            border: none;
            background: #999;
            color: #fff;
            cursor: pointer;
            font-size: 12px;
            margin-right: 8px;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="top">
        <h1>Sistema de Vendedores</h1>
        <a href="../controller/ProdutoController.php" class="btn-nav">Produtos</a>
    </div>

    <div class="form-box">
        <form method="post" action="../controller/VendedorController.php">
            <div class="form-row">
                <input type="number" name="codigo"
                       placeholder="Código"
                       value="<?= $editarVendedor ? $editarVendedor->getCodigo() : '' ?>"
                       <?= $editarVendedor ? 'readonly' : '' ?>
                       required>

                <input type="text" name="nome"
                       placeholder="Nome"
                       value="<?= $editarVendedor ? $editarVendedor->getNome() : '' ?>"
                       required>

                <input type="text" name="contacto"
                       placeholder="Contacto"
                       value="<?= $editarVendedor ? $editarVendedor->getContacto() : '' ?>"
                       required>
            </div>

            <div class="form-row">
                <input type="number" name="quantidade"
                       placeholder="Quantidade"
                       value="<?= $editarVendedor ? $editarVendedor->getQuantidade() : '' ?>"
                       required>

                <input type="number" name="diasTrabalhados"
                       placeholder="Dias Trabalhados"
                       value="<?= $editarVendedor ? $editarVendedor->getDiasTrabalhados() : '' ?>"
                       required>

                <input type="number" step="0.01" name="salarioDiario"
                       placeholder="Salário Diário"
                       value="<?= $editarVendedor ? $editarVendedor->getSalarioDiario() : '' ?>"
                       required>
            </div>

            <div class="form-actions">
                <?php if ($editarVendedor): ?>
                    <a href="../controller/VendedorController.php" class="btn-cancel">Cancelar</a>
                <?php endif; ?>

                <button type="submit" name="acao"
                        value="<?= $editarVendedor ? 'atualizar' : 'adicionar' ?>">
                    <?= $editarVendedor ? 'Atualizar Vendedor' : 'Adicionar Vendedor' ?>
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
                    <th>Contacto</th>
                    <th>Quantidade</th>
                    <th>Salário</th>
                    <th>Bónus</th>
                    <th>Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendedores as $v): ?>
                <tr>
                    <td><?= $v->getCodigo() ?></td>
                    <td><?= $v->getNome() ?></td>
                    <td><?= $v->getContacto() ?></td>
                    <td><?= $v->getQuantidade() ?></td>
                    <td><?= $v->getSalarioDiario() ?></td>
                    <td><?= $v->getBonusDiario() ?></td>
                    <td class="ops">
                        <form method="post" action="../controller/VendedorController.php">
                            <input type="hidden" name="codigo" value="<?= $v->getCodigo() ?>">
                            <button name="acao" value="editar" class="btn-edit">Editar</button>
                            <button name="acao" value="remover" class="btn-remove">Remover</button>
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

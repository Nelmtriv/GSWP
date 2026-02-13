<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<?php
$produtos = $produtos ?? [];
$editarProduto = $editarProduto ?? null;
?>
<?php if (isset($_GET['erro'])): ?>
    <div class="erro">
        <?= $_GET['erro'] ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['ok'])): ?>
    <div class="ok">
        Operação realizada com sucesso
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Sistema de Produtos</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    </style>
</head>

<body>

    <div class="container">

        <div class="top-bar">
            <div class="top-left">
                <h1>Sistema de Produtos</h1>
                <span class="user">👤 <?= $_SESSION["usuario"] ?></span>
            </div>

            <div class="top-right">
                <a href="/GSWP/controller/VendedorController.php" class="btn-nav">
                    <i class="fa-solid fa-box"></i> Vendedor
                </a>

                <a href="/GSWP/controller/logout.php" class="btn-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Sair
                </a>
            </div>
        </div>

        <div class="form-box">
            <form method="post" action="../controller/ProdutoController.php">
                <?php if ($editarProduto): ?>
                    <input type="hidden" name="codigo" value="<?= $editarProduto->getCodigo() ?>">
                <?php endif; ?>

                <div class="form-row">
                    <input type="text" name="nome" placeholder="Nome"
                        value="<?= $editarProduto ? $editarProduto->getNome() : '' ?>" required>

                    <select name="unidadeMedida" required>
                        <option value="">Unidade</option>

                        <option value="kg"
                            <?= ($editarProduto && $editarProduto->getUnidadeMedida() == "kg") ? 'selected' : '' ?>>
                            kg</option>

                        <option value="g"
                            <?= ($editarProduto && $editarProduto->getUnidadeMedida() == "g") ? 'selected' : '' ?>>
                            g</option>

                        <option value="l"
                            <?= ($editarProduto && $editarProduto->getUnidadeMedida() == "l") ? 'selected' : '' ?>>
                            l</option>

                        <option value="ml"
                            <?= ($editarProduto && $editarProduto->getUnidadeMedida() == "ml") ? 'selected' : '' ?>>
                            ml</option>
                    </select>

                    <input type="number" name="quantidade" placeholder="Quantidade"
                        value="<?= $editarProduto ? $editarProduto->getQuantidade() : '' ?>" required>

                    <input type="number" step="0.01" name="precoUnitario" placeholder="Preço Unitário"
                        value="<?= $editarProduto ? $editarProduto->getPrecoUnitario() : '' ?>" required>

                    <input type="date" name="dataValidade" placeholder="Data de validade"
                        value="<?= $editarProduto ? $editarProduto->getDataValidade() : '' ?>">

                </div>

                <div class="form-actions">
                    <?php if ($editarProduto): ?>
                        <a href="../controller/ProdutoController.php" class="btn-cancel">
                            Cancelar
                        </a>
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
                                    <button name="acao" value="editar" class="btn-edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>

                                    <button name="acao" value="remover" class="btn-remove">

                                        <i class="fa-solid fa-trash"></i>
                                    </button>
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
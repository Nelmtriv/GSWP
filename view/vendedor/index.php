<?php
if (!isset($_SESSION["usuario"])) {
    header("Location: /GSWP/controller/AuthController.php");

    exit;
}
?>

<?php
$vendedores = $vendedores ?? [];
$editarVendedor = $editarVendedor ?? null;
?>
<?php if (!empty($mensagemErro)): ?>
    <div class="erro"><?= $mensagemErro ?></div>
<?php endif; ?>

<?php if (!empty($mensagemOk)): ?>
    <div class="ok"><?= $mensagemOk ?></div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Sistema de Vendedores</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">

        <div class="top-bar">
            <div class="top-left">
                <h1>Sistema de Vendedores</h1>
                <span class="user">👤 <?= $_SESSION["usuario"] ?></span>
            </div>

            <div class="top-right">
                <a href="/GSWP/controller/ProdutoController.php" class="btn-nav">
                    <i class="fa-solid fa-box"></i> Produtos
                </a>

                <a href="/GSWP/controller/logout.php" class="btn-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Sair
                </a>
            </div>
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
                    <select name="genero" required>
                        <option value="">Género</option>

                        <option value="Masculino"
                            <?= ($editarVendedor && $editarVendedor->getGenero() == "Masculino") ? 'selected' : '' ?>>
                            Masculino</option>

                        <option value="Feminino"
                            <?= ($editarVendedor && $editarVendedor->getGenero() == "Feminino") ? 'selected' : '' ?>>
                            Feminino</option>
                    </select>


                    <select name="estadoCivil" required>
                        <option value="">Estado civil</option>

                        <option value="Solteiro"
                            <?= ($editarVendedor && $editarVendedor->getEstadoCivil() == "Solteiro") ? 'selected' : '' ?>>
                            Solteiro(a)</option>

                        <option value="Casado"
                            <?= ($editarVendedor && $editarVendedor->getEstadoCivil() == "Casado") ? 'selected' : '' ?>>
                            Casado(a)</option>

                        <option value="Divorciado"
                            <?= ($editarVendedor && $editarVendedor->getEstadoCivil() == "Divorciado") ? 'selected' : '' ?>>
                            Divorciado(a)</option>

                        <option value="Viuvo"
                            <?= ($editarVendedor && $editarVendedor->getEstadoCivil() == "Viuvo") ? 'selected' : '' ?>>
                            Viuvo(a)</option>
                    </select>


                    <select name="codigo_produto" required>
                        <option value="">Selecionar produto</option>

                        <?php foreach ($listaProdutos as $p): ?>
                            <option value="<?= $p['codigo_produto'] ?>"
                                <?= ($editarVendedor && $editarVendedor->getCodigoProduto() == $p['codigo_produto']) ? 'selected' : '' ?>>
                                <?= $p['nome'] ?> (stock: <?= $p['quantidade'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>

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
                        <th>Género</th>
                        <th>Estado civil</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Salário</th>
                        <th>Bónus</th>
                        <th>Operações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vendedores as $item):
                        $v = $item['vendedor'];
                    ?>

                        <td><?= $v->getCodigo() ?></td>
                        <td><?= $v->getNome() ?></td>
                        <td><?= $v->getContacto() ?></td>
                        <td><?= $v->getGenero() ?></td>
                        <td><?= $v->getEstadoCivil() ?></td>
                        <td><?= $item['nome_produto'] ?></td>
                        <td><?= $v->getQuantidade() ?></td>
                        <td><?= $v->getSalarioDiario() ?></td>
                        <td><?= $v->getBonusDiario() ?></td>



                        <td class="ops">
                            <form method="post" action="../controller/VendedorController.php">
                                <input type="hidden" name="codigo" value="<?= $v->getCodigo() ?>">
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
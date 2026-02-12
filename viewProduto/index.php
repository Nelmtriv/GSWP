<?php
session_start();

require_once __DIR__ . '/../controller/produtoController.php';
require_once __DIR__ . '/../model/Produto.php';
require_once __DIR__ . '/../controller/Conexao.php';
            // Processa ações via POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $action = $_POST['action'] ?? '';
                $message = '';
                $messageType = '';
                
                switch ($action) {
                    case 'cadastrar':
                        $nome = $_POST['nome'] ?? '';
                        $unidade = $_POST['unidade'] ?? '';
                        $quantidade = (float)($_POST['quantidade'] ?? 0);
                        $preco = (float)($_POST['preco'] ?? 0);
                        $dataValidade = !empty($_POST['dataValidade']) ? $_POST['dataValidade'] : null;
                        
                        if ($nome && $unidade && $quantidade > 0 && $preco > 0) {
                            $success = ProdutoController::cadastrarProduto($nome, $unidade, $quantidade, $preco, $dataValidade);
                            if ($success) {
                                $message = 'Produto cadastrado com sucesso!';
                                $messageType = 'success';
                            } else {
                                $message = 'Erro ao cadastrar produto!';
                                $messageType = 'error';
                            }
                        } else {
                            $message = 'Preencha todos os campos corretamente!';
                            $messageType = 'error';
                        }
                        break;
                        
                    case 'editar':
                        $codigo = (int)($_POST['codigo'] ?? 0);
                        $nome = $_POST['nome'] ?? '';
                        $unidade = $_POST['unidade'] ?? '';
                        $quantidade = (float)($_POST['quantidade'] ?? 0);
                        $preco = (float)($_POST['preco'] ?? 0);
                        $dataValidade = !empty($_POST['dataValidade']) ? $_POST['dataValidade'] : null;
                        
                        if ($codigo > 0 && $nome && $unidade && $quantidade > 0 && $preco > 0) {
                            $success = ProdutoController::editarProduto($codigo, $nome, $unidade, $quantidade, $preco, $dataValidade);
                            if ($success) {
                                $message = 'Produto editado com sucesso!';
                                $messageType = 'success';
                            } else {
                                $message = 'Erro ao editar produto!';
                                $messageType = 'error';
                            }
                        } else {
                            $message = 'Selecione um produto e preencha todos os campos!';
                            $messageType = 'error';
                        }
                        break;
                        
                    case 'remover':
                        $codigo = (int)($_POST['codigo'] ?? 0);
                        if ($codigo > 0) {
                            $success = ProdutoController::removerProduto($codigo);
                            if ($success) {
                                $message = 'Produto removido com sucesso!';
                                $messageType = 'success';
                            } else {
                                $message = 'Erro ao remover produto!';
                                $messageType = 'error';
                            }
                        }
                        break;
                }
                
                if ($message) {
                    $_SESSION['message'] = $message;
                    $_SESSION['message_type'] = $messageType;
                }
                
                header('Location: index.php');
                exit;
            }
            
            // Mostra mensagens
            if (isset($_SESSION['message'])) {
                echo '<div class="message ' . $_SESSION['message_type'] . '">' . $_SESSION['message'] . '</div>';
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
            ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CADASTRO PRODUTO</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Arial:wght@400;700&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #000000;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .window-frame {
            width: 1100px;
            min-height: 650px;
            background-color: #f0f0f0;
            border: 2px solid #999999;
            box-shadow: 3px 3px 15px rgba(0,0,0,0.3);
        }

        .window-title {
            background-color: #e0e0e0;
            padding: 12px 20px;
            font-weight: bold;
            font-size: 16px;
            border-bottom: 2px solid #999999;
            color: #000000;
            letter-spacing: 0.5px;
        }

        .content-area {
            padding: 30px;
        }

        .panel {
            background-color: #ffffff;
            border: 2px solid #999999;
            padding: 25px;
            margin-bottom: 25px;
            float: left;
            box-shadow: 1px 1px 5px rgba(0,0,0,0.1);
        }

        .panel-produto {
            width: 500px;
            height: 380px;
        }

        .panel-operacoes {
            width: 450px;
            height: 380px;
            margin-left: 50px;
        }

        .panel-title {
            font-weight: bold;
            font-size: 16px;
            margin: -30px -25px 25px -25px;
            padding: 10px 20px;
            background-color: #ffffff;
            border-bottom: 2px solid #999999;
            color: #000000;
            letter-spacing: 0.5px;
        }

        .form-group {
            margin-bottom: 20px;
            clear: both;
        }

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
            height: 40px;
        }

        .form-label {
            width: 200px;
            font-size: 15px;
            color: #000000;
            font-weight: normal;
        }

        .form-input {
            width: 220px;
            padding: 10px 12px;
            border: 1px solid #999999;
            background-color: #ffffff;
            font-size: 15px;
            border-radius: 3px;
        }

        .form-input:focus {
            outline: 2px solid #4a6fa5;
            outline-offset: -1px;
        }

        .radio-group {
            width: 220px;
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }

        .radio-option {
            display: flex;
            align-items: center;
            font-size: 15px;
        }

        .radio-option input {
            margin-right: 6px;
            transform: scale(1.2);
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 10px;
        }

        .button {
            width: 150px;
            height: 35px;
            background-color: #c3c3c3;
            border: 2px solid #999999;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            padding: 0;
            color: #000000;
            transition: all 0.2s;
            border-radius: 4px;
            letter-spacing: 0.5px;
        }

        .button:hover {
            background-color: #d3d3d3;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .button:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .table-container {
            clear: both;
            margin-top: 35px;
            background-color: #ffffff;
            border: 2px solid #999999;
            padding: 20px;
            box-shadow: 1px 1px 5px rgba(0,0,0,0.1);
        }

        .table-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
            color: #000000;
            padding-bottom: 8px;
            border-bottom: 2px solid #e0e0e0;
            letter-spacing: 0.5px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .data-table th {
            background-color: #e8e8e8;
            border: 1px solid #999999;
            padding: 12px 15px;
            text-align: left;
            font-weight: bold;
            color: #000000;
        }

        .data-table td {
            border: 1px solid #999999;
            padding: 12px 15px;
            color: #000000;
        }

        .data-table tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        .data-table tr:hover {
            background-color: #e8f4fd;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .date-input {
            width: 220px;
            padding: 10px 12px;
            border: 1px solid #999999;
            background-color: #ffffff;
            font-size: 15px;
            border-radius: 3px;
        }

        .date-input:focus {
            outline: 2px solid #4a6fa5;
            outline-offset: -1px;
        }
        
        .selected-row {
            background-color: #d4e6f7 !important;
            font-weight: bold;
        }
        
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            font-weight: bold;
        }
        
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .message.warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
    </style>
</head>
<body>
    <div class="window-frame">
        <div class="window-title">CADASTRO PRODUTO</div>
        
        <div class="content-area">
            <!-- Painel de Produto -->
            <div class="panel panel-produto">
                <div class="panel-title">PRODUTO</div>
                
                <form method="POST" action="index.php" id="produtoForm">
                    <input type="hidden" name="action" id="formAction" value="cadastrar">
                    <input type="hidden" name="codigo" id="codigo" value="">
                    
                    <div class="form-group">
                        <div class="form-row">
                            <span class="form-label">NOME:</span>
                            <input type="text" class="form-input" id="nome" name="nome" placeholder="Digite o nome do produto" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-row">
                            <span class="form-label">UNIDADE DE MEDIDA:</span>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="unidade" value="L" required> L
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="unidade" value="ml"> ml
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="unidade" value="Kg"> Kg
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="unidade" value="g"> g
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-row">
                            <span class="form-label">QUANTIDADE:</span>
                            <input type="number" step="0.01" class="form-input" id="quantidade" name="quantidade" placeholder="0" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-row">
                            <span class="form-label">PREÇO UNITÁRIO:</span>
                            <input type="number" step="0.01" class="form-input" id="preco" name="preco" placeholder="0.00" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-row">
                            <span class="form-label">DATA DE VALIDADE:</span>
                            <input type="date" class="date-input" id="dataValidade" name="dataValidade">
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Painel de Operações -->
            <div class="panel panel-operacoes">
                <div class="panel-title">OPERAÇÕES</div>
                
                <div class="button-group">
                    <button type="submit" form="produtoForm" class="button" onclick="setAction('cadastrar')">CADASTRAR</button>
                    <button type="button" class="button" onclick="location.reload()">LISTAR</button>
                    <button type="submit" form="produtoForm" class="button" onclick="setAction('editar')">EDITAR</button>
                    <button type="button" class="button" onclick="removerProdutoSelecionado()">REMOVER</button>
                    <button type="button" class="button" onclick="limparCampos()">LIMPAR</button>
                    <a href="vendedor_view.php" class="button btn-sair">SAIR</a>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <!-- Tabela de Produtos -->
            <div class="table-container">
                <div class="table-title">LISTA DE PRODUTOS</div>
                <table class="data-table" id="tabelaProdutos">
                    <thead>
                        <tr>
                            <th>CODIGO</th>
                            <th>NOME</th>
                            <th>UN.MEDIDA</th>
                            <th>QUANTIDADE</th>
                            <th>PRECO UNITARIO</th>
                            <th>DATA DE VALIDADE</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaCorpo">
                        <?php
                        $produtos = ProdutoController::listarProdutos();
                        
                        if (empty($produtos)) {
                            echo '<tr>
                                <td colspan="6" style="text-align: center; padding: 30px; color: #666666; font-style: italic;">
                                    Nenhum produto cadastrado.
                                </td>
                            </tr>';
                        } else {
                            foreach ($produtos as $produto) {
                                $dataFormatada = $produto->getDataValidade() ? date('d/m/Y', strtotime($produto->getDataValidade())) : '';
                                
                                echo '<tr onclick="selecionarProduto(this, ' . $produto->getCodigo() . ')" 
                                      id="row-' . $produto->getCodigo() . '">
                                    <td>' . $produto->getCodigo() . '</td>
                                    <td>' . htmlspecialchars($produto->getNome()) . '</td>
                                    <td>' . htmlspecialchars($produto->getUnidadeMedida()) . '</td>
                                    <td>' . number_format($produto->getQuantidade(), 2) . '</td>
                                    <td>' . number_format($produto->getPrecoUnitario(), 2) .  ' Mzn </td>
                                    <td>' . $dataFormatada . '</td>
                                </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        let produtoSelecionado = null;
        
        function setAction(acao) {
            document.getElementById('formAction').value = acao;
        }
        
        function selecionarProduto(row, codigo) {
            // Remove a seleção anterior
            document.querySelectorAll('.selected-row').forEach(r => {
                r.classList.remove('selected-row');
            });
            
            // Adiciona seleção à linha clicada
            row.classList.add('selected-row');
            produtoSelecionado = codigo;
            
            // Preenche os campos para edição
            carregarParaEdicao(codigo, {stopPropagation: function(){}});
        }
        
        function carregarParaEdicao(codigo, event) {
            if (event) event.stopPropagation();
            
            // Busca os dados do produto selecionado
            const row = document.getElementById('row-' + codigo);
            if (row) {
                const cells = row.cells;
                
                document.getElementById('codigo').value = cells[0].textContent;
                document.getElementById('nome').value = cells[1].textContent;
                document.getElementById('quantidade').value = cells[3].textContent.replace(',', '.');
                document.getElementById('preco').value = cells[4].textContent.replace(' Mzn ', '').replace(',', '.');
                
                // Converte data do formato dd/mm/aaaa para aaaa-mm-dd
                const dataStr = cells[5].textContent;
                if (dataStr) {
                    const parts = dataStr.split('/');
                    if (parts.length === 3) {
                        const dataFormatada = parts[2] + '-' + parts[1] + '-' + parts[0];
                        document.getElementById('dataValidade').value = dataFormatada;
                    }
                }
                
                // Seleciona a unidade de medida
                const unidade = cells[2].textContent;
                const radios = document.querySelectorAll('input[name="unidade"]');
                radios.forEach(radio => {
                    radio.checked = (radio.value === unidade);
                });
                
                // Seleciona a linha na tabela
                selecionarProduto(row, codigo);
            }
        }
        
        function removerProdutoSelecionado() {
            if (!produtoSelecionado) {
                alert('Selecione um produto na tabela para remover.');
                return;
            }
            
            if (confirm('Tem certeza que deseja remover o produto selecionado?')) {
                // Cria formulário para remover
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'index.php';
                
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'remover';
                form.appendChild(actionInput);
                
                const codigoInput = document.createElement('input');
                codigoInput.type = 'hidden';
                codigoInput.name = 'codigo';
                codigoInput.value = produtoSelecionado;
                form.appendChild(codigoInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        function limparCampos() {
            document.getElementById('codigo').value = '';
            document.getElementById('nome').value = '';
            document.getElementById('quantidade').value = '';
            document.getElementById('preco').value = '';
            document.getElementById('dataValidade').value = '';
            
            // Desmarcar radio buttons
            const radios = document.querySelectorAll('input[name="unidade"]');
            radios.forEach(radio => {
                radio.checked = false;
            });
            
            // Remover seleção da tabela
            document.querySelectorAll('.selected-row').forEach(row => {
                row.classList.remove('selected-row');
            });
            
            produtoSelecionado = null;
            document.getElementById('formAction').value = 'cadastrar';
        }
        
        // Previne envio duplo do formulário
        document.getElementById('produtoForm').addEventListener('submit', function(e) {
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Processando...';
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = submitBtn.getAttribute('data-original-text') || 'CADASTRAR';
                }, 3000);
            }
        });
        
        // Salva texto original dos botões
        document.querySelectorAll('button[type="submit"]').forEach(btn => {
            btn.setAttribute('data-original-text', btn.textContent);
        });
    </script>
</body>
</html>
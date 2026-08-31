<?php

session_start();

require 'conexao.php';
require 'limites.php';

$idTrem = (int) ($_GET['id_trem'] ?? 0);
$somenteFalhas = isset($_GET['falhas']) && $_GET['falhas'] === '1';

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

$trens = $conexao->query('SELECT id_trem, prefixo_trem FROM trens ORDER BY prefixo_trem');

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leituras dos Sensores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <head>
        <span class="marca">Frota Ferroviária</span>
    </head>

    <main>
        <div class="titulo">
            <h1>Leituras dos Sensores</h1>
        </div>

        <?php
            if ($mensagem !== ''):
        ?>
            <p class="aviso"><?= htmlspecialchars($mensagem) ?></p>
        <?php
            endif;
        ?>

        <form method="GET" class="formulario">
            <div class="linha">
                <div class="campo">
                <label for="id_trem">Filtrar por trem</label>
                <select name="id_trem" id="id_trem">
                        <option value="">Todos os trens</option>
                        <?php
                        $trens = $conexao->query('SELECT id_trem, prefixo_trem FROM trens ORDER BY prefixo_trem');
                        while ($trem = $trens->fetch_assoc()):
                            $selected = $trem['id_trem'] == $idTrem ? 'selected' : '';
                        ?>
                            <option value="<?= htmlspecialchars($trem['id_trem']) ?>" <?= $selected ?>><?= htmlspecialchars($trem['prefixo_trem']) ?></option>
                        <?php
                        endwhile;
                        ?>
                    </select>
                </div>

                <div class="campo">
                    <label for="somente_falha">Exibição</label>
                    <label for="opcao">
                        <input type="checkbox" name="falhas" id="falhas" value="1" <?= $somenteFalhas ? 'checked' : '' ?>>
                        <input type="checkbox" name="somente_falha" id="somente_falha" value="1" <?= $somenteFalha ? 'checked': '' ?>> mostrar somente leituras com falha
                    </label>
                </div>
            </div>

            <div class="acoes">
                <button type="submit" class="botao botao-primario">Filtrar</button>
                <a href="leituras.php" class="botao">Limpar</a>
            </div>
        </form>
    </main>
</body>
</html>
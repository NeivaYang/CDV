<?php
    $servername = "localhost";
    $database = "cdv2_db";
    $username = "root";
    $password = "";

    // Create connection
    $cnx = mysqli_connect($servername, $username, $password, $database);

    // Check connection
    if (!$cnx) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        $alter_table = "ALTER TABLE propostas 
        ADD COLUMN sistema_aspersor TINYINT(1) NULL DEFAULT 0 AFTER descricao,
        ADD COLUMN sistema_autopropelido TINYINT(1) NULL DEFAULT 0 AFTER sistema_aspersor,
        ADD COLUMN sistema_gotejador TINYINT(1) NULL DEFAULT 0 AFTER sistema_autopropelido,
        ADD COLUMN sistema_linear TINYINT(1) NULL DEFAULT 0 AFTER sistema_gotejador,
        ADD COLUMN sistema_microaspersor TINYINT(1) NULL DEFAULT 0 AFTER sistema_linear,
        ADD COLUMN sistema_pivocentral TINYINT(1) NULL DEFAULT 0 AFTER sistema_microaspersor";

        if ($cnx->query($alter_table) === TRUE)  {
            
            echo "Alteração da tabela <b>propostas</b> realizada com sucesso<br/><hr/>";
            $selecao = $cnx->query('select id, sistema_irrigacao from propostas');
            if ($selecao->num_rows > 0) {

                $cont100 = $selecao->num_rows;
                $conta = 0;

                // output data of each row
                while ($item = $selecao->fetch_assoc()) {
                    $aspersor = ($item['sistema_irrigacao'] == 'aspersor') ? 1 : 0;
                    $autopropelido = ($item['sistema_irrigacao'] == 'autopropelido') ? 1 : 0;
                    $gotejador = ($item['sistema_irrigacao'] == 'gotejador') ? 1 : 0;
                    $linear = ($item['sistema_irrigacao'] == 'linear') ? 1 : 0;
                    $microaspersor = ($item['sistema_irrigacao'] == 'microaspersor') ? 1 : 0;
                    $pivo_central = ($item['sistema_irrigacao'] == 'pivo central') ? 1 : 0; 
        
                    $sql_update = "UPDATE propostas 
                                    SET sistema_aspersor = {$aspersor}, sistema_autopropelido = {$autopropelido}, 
                                        sistema_gotejador = {$gotejador}, sistema_linear = {$linear},
                                        sistema_microaspersor = {$microaspersor}, sistema_pivocentral = {$pivo_central} 
                                    WHERE id = {$item['id']}";
                    
                    if ($cnx->query($sql_update) === TRUE) {
                        $conta += 1;
                        $percent = ($conta*100)/$cont100;
                        echo "____{$percent}<br/>";
                    } else {
                        echo "Error updating record: " . $cnx->error;
                        break;
                    }
                }

                $sql_drop_column = "ALTER TABLE propostas DROP COLUMN sistema_irrigacao";
                if ($cnx->query($sql_drop_column) === TRUE)  {
                    echo "Coluna <b>sistema_irrigacao</b> removida com sucesso.<br/>";
                } else {
                    echo "Erro ao remover a coluna <b>sistema_irrigacao</b>.<br/>";
                }

            } else {
                echo "Não há registros para a seleção principal.<br/>";
            }
        } else {
            echo "Erro na alteração na tabela.<br/>";
        }

        $alter_table2 = "ALTER TABLE cliente_cdc 
        ADD COLUMN cidade VARCHAR(50) NOT NULL AFTER fazenda,
        ADD COLUMN estado VARCHAR(5) NULL DEFAULT NULL AFTER cidade,
        ADD COLUMN latitude FLOAT(12,8) NULL DEFAULT NULL AFTER estado,
        ADD COLUMN longitude FLOAT(12,8) NULL DEFAULT NULL AFTER latitude";

        if ($cnx->query($alter_table2) === TRUE) {
            echo "Alteração da tabela <b>cliente_cdc</b></b> realizada com sucesso<br/><hr/>";            
        } else {
            echo "Erro na 2a. alteração na tabela.<br/>";
        }
    }

    mysqli_close($cnx);    

    die('Fim...');
?>
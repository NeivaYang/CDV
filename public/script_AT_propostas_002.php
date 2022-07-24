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
        $tables_clean = array('oportunidades', 
                              'oportunidades_encerradas', 
                              'propostas', 
                              'proposta_produtos', 
                              'proposta_servicos');

        foreach ($tables_clean as $table) {
            $selecao = "select * from {$table} where created_at < '2022-03-14' and (deleted_at is null)";

            echo "Alteração da tabela <b>{$table}</b> realizada com sucesso<br/>";
            $selecao = $cnx->query("select * from {$table} where created_at < '2022-03-14' and (deleted_at is null)");
            if ($selecao->num_rows > 0) {
                
                // output data of each row
                while ($item = $selecao->fetch_assoc()) {
                    $sql_update = "UPDATE {$table} SET deleted_at = current_timestamp() WHERE id = {$item['id']}";
                    if ($cnx->query($sql_update) === TRUE) {
                        echo "____Alteração {$table} OK<br/>";
                    } else {
                        echo "Error updating {$table}. " . $cnx->error . "<br/>";
                    }
                }
            } else {
                echo "Erro na alteração na tabela <b>{$table}</b>.<br/>";
            }
            echo "<br/>";
        }
    
        echo "<br/><hr/><br/>";

        // Criação dos itens
        $criacao_itens = array(
            "INSERT INTO itens_venda (id, nome, tipo, unidade, created_at, updated_at) VALUES (1, 'Manejo de Irrigação', 'servico', 'ha', current_timestamp(), current_timestamp())",
            "INSERT INTO itens_venda (id, nome, tipo, unidade, created_at, updated_at) VALUES (2, 'Aqua Trac', 'servico', 'un', current_timestamp(), current_timestamp())",
            "INSERT INTO itens_venda (id, nome, tipo, unidade, created_at, updated_at) VALUES (3, 'Estação', 'servico', 'un', current_timestamp(), current_timestamp())"
        );

        $conta = 1;
        foreach ($criacao_itens as $item_sql) {
            if ($cnx->query($item_sql) === TRUE) {
                echo "____Criação itens_venda no.{$conta} OK<br/>";
            } else {
                echo "Error updating itens_venda no.{$conta}.<br/>{$item_}<br/> " . $cnx->error . "<br/>";
            }
    
        }

        echo "<br/><hr/><br/>";

        $selecao = "select proposta_servicos.id_servico, propostas.* 
                        from proposta_servicos
                        inner join propostas on propostas.id =  proposta_servicos.id_proposta
                        where proposta_servicos.created_at >= '2022-03-14'";

        echo "Junção Para Proposta Geral<br/>";
        $selecao = $cnx->query($selecao);
        if ($selecao->num_rows > 0) {
            $id_proposta = 0;

            // output data of each row
            while ($item = $selecao->fetch_assoc()) {

                if ($id_proposta == 0 || $id_proposta != $item['id']) {

                    $sql_insert_pv = "INSERT INTO proposta_venda (id, id_oportunidade, data_proposta, created_at, updated_at) 
                        VALUES ({$item['id']}, {$item['id_oportunidade']}, '{$item['data_proposta']}', '{$item['created_at']}', '{$item['updated_at']}')";

                    if ($cnx->query($sql_insert_pv) === TRUE) {
                        echo "____Criação proposta {$item['id']} OK<br/>";
                    } else {
                        echo "Error creating proposta {$item['id']}. " . $cnx->error . "<br/>";
                    }

                    $id_proposta = $item['id'];
                }

                $sistemaIrrigacao = "pivocentral";

                $sql_itens_venda = $cnx->query("select * from itens_venda where id = {$item['id_servico']}");
                $item_itens_venda = $sql_itens_venda->fetch_assoc();

                $sql_insert_pvi = "INSERT INTO proposta_venda_itens (id_proposta_venda, id_item_venda, sistema_irrigacao, 
                quantidade_equipamento, unidade, quantidade, valor_unitario, desconto_concedido, created_at, updated_at)
                VALUES ({$item['id']}, {$item_itens_venda['id']}, '{$sistemaIrrigacao}', {$item['quantidade_equipamento']},
                '{$item_itens_venda['unidade']}', {$item['area_abrangida']}, {$item['valor_area']}, {$item['desconto_concedido']},
                '{$item['created_at']}', '{$item['updated_at']}')";

                if ($cnx->query($sql_insert_pvi) === TRUE) {
                    echo "____Criação proposta venda item {$item['id']} OK<br/>";
                } else {
                    echo "Error creating proposta venda item {$item['id']}. " . $cnx->error . "<br/>";
                }
            }
        } else {
            echo "Erro na alteração na tabela <b>{$table}</b>.<br/>";
        }
        echo "<br/>";
    }

    mysqli_close($cnx);    

    die('Fim...');
?>
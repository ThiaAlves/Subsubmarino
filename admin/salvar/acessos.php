<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    if ( $_POST ) {

    	//recuperar o id e o nome da cidade
    	$id 	   = trim ( $_POST['id'] ?? NULL );
    	$tipo_id    = trim ( $_POST['tipo_id'] ?? NULL );
        $tabela    = trim ( $_POST['tabela'] ?? NULL );
        $acesso    = trim ( $_POST['acesso'] ?? NULL );

        //verificar se este registro já está salvo no banco
        $sql = "select id from acesso 
            where tabela = :tabela AND tipo_id = :tipo_id 
            AND id <> :id 
            limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(':tabela', $tabela);
        $consulta->bindParam(':tipo_id', $tipo_id);
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //se vier preenchido já existe uma categoria com este nome
        if ( ! empty ( $dados->id ) ) {
            ?>
            <script>
                //mostrar a telinha animada - alert
                Swal.fire(
                  'Erro',
                  'Já existe um registro cadastrado com essa característica',
                  'error'
                ).then((result) => {
                    //retornar para a tela anterior
                    history.back();
                })
            </script>
            <?php

            exit;
        }

    	//se o id estiver em branco - insert
    	if ( empty ( $id ) ) {
    		$sql = "insert into acesso values(NULL, :tipo_id, :tabela, :acesso)";
    		$consulta = $pdo->prepare($sql);
            $consulta->bindParam(':tipo_id', $tipo_id);
    		$consulta->bindParam(':tabela', $tabela);
            $consulta->bindParam(':acesso', $acesso);

    	} else {
    		$sql = "update acesso set tipo_id = :tipo_id, tabela = :tabela, acesso = :acesso where id = :id limit 1";
    		$consulta = $pdo->prepare($sql);
    		$consulta->bindParam(':tipo_id', $tipo_id);
            $consulta->bindParam(':tabela', $tabela);
            $consulta->bindParam(':acesso', $acesso);
    		$consulta->bindParam(':id', $id);

    	}

    	//executar
    	if ( $consulta->execute() ) {
    		
            ?>
            <script>
                //mostrar a telinha animada - alert
                Swal.fire(
                  'Sucesso!',
                  'Registro salvo com sucesso!',
                  'success'
                ).then((result) => {
                    //retornar para a tela anterior
                    //history.back();
                    //mandar para tela de listagem
                    location.href='listar/acessos';
                })
            </script>
            <?php

    		exit;
    	}

    	//mostrar mensagem de erro do sql
    	//echo $consulta->errorInfo()[2];
    	?>
        <script>
            //mostrar a telinha animada - alert
            Swal.fire(
              'Erro',
              'Erro ao salvar registro',
              'error'
            ).then((result) => {
                //retornar para a tela anterior
                history.back();
            })
        </script>
        <?php

    	exit;
    }

    //se não foi enviado nada por POST
    //echo "<script>alert('Requisição inválida');history.back();</script>";

    ?>
    <script>
        //mostrar a telinha animada - alert
        Swal.fire(
          'Erro',
          'Requisição Inválida',
          'error'
        ).then((result) => {
            //retornar para a tela anterior
            history.back();
        })
    </script>
    <?php
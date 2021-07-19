<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    if ( $_POST ) {

    	//recuperar o id e o nome da cidade
    	$id 	   = trim ( $_POST['id'] ?? NULL );
    	$cidade    = trim ( $_POST['cidade'] ?? NULL );
        $estado    = trim ( $_POST['estado'] ?? NULL );

        //verificar se este registro já está salvo no banco
        $sql = "select id from cidade 
            where cidade = :cidade AND estado = :estado 
            AND id <> :id 
            limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(':cidade', $cidade);
        $consulta->bindParam(':estado', $estado);
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
    		$sql = "insert into cidade values(NULL, :cidade, :estado)";
    		$consulta = $pdo->prepare($sql);
            $consulta->bindParam(':cidade', $cidade);
    		$consulta->bindParam(':estado', $estado);

    	} else {
    		$sql = "update cidade set cidade = :cidade, estado = :estado where id = :id limit 1";
    		$consulta = $pdo->prepare($sql);
    		$consulta->bindParam(':cidade', $cidade);
            $consulta->bindParam(':estado', $estado);
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
                    location.href='listar/cidades';
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
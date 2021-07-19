<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    if ( $_POST ) {

    	//recuperar o id e o nome do menu
    	$id 	   = trim ( $_POST['id'] ?? NULL );
    	$nome      = trim ( $_POST['nome'] ?? NULL );
        $tabela    = trim ( $_POST['tabela'] ?? NULL );
        $url       = trim ( $_POST['url'] ?? NULL );
        $submenu   = trim ( $_POST['submenu'] ?? NULL );
        $icone     = trim ( $_POST['icone'] ?? NULL );

        //verificar se este registro já está salvo no banco
        $sql = "select id from menu 
            where tabela = :tabela AND submenu = :submenu 
            AND id <> :id 
            limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(':tabela', $tabela);
        $consulta->bindParam(':submenu', $submenu);
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
    		$sql = "insert into menu values(NULL, :nome, :icone, :url, :tabela, :submenu)";
    		$consulta = $pdo->prepare($sql);
    		$consulta->bindParam(':tabela', $tabela);
            $consulta->bindParam(':nome', $nome);
            $consulta->bindParam(':icone', $icone);
            $consulta->bindParam(':url', $url);
            $consulta->bindParam(':submenu', $submenu);

    	} else {
    		$sql = "update menu set tabela = :tabela, nome = :nome, icone = :icone, url = :url, submenu = :submenu where id = :id limit 1";
    		$consulta = $pdo->prepare($sql);

            $consulta->bindParam(':tabela', $tabela);
            $consulta->bindParam(':nome', $nome);
            $consulta->bindParam(':icone', $icone);
            $consulta->bindParam(':url', $url);
            $consulta->bindParam(':submenu', $submenu);

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
                    location.href='listar/menus';
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
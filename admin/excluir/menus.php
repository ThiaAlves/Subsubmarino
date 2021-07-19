<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    //verificar se esta sendo enviado um ID
    if ( empty ( $id ) ) {

    	?>
	    <script>
	        //mostrar a telinha animada - alert
	        Swal.fire(
	          'Erro',
	          'Requisição Inválida - ID inválido',
	          'error'
	        ).then((result) => {
	            //retornar para a tela anterior
	            history.back();
	        })
	    </script>
	    <?php

    	exit;
    }


    //excluir o menu
    $sql = "delete from menu where id = :id limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(':id', $id);

    //verificar se conseguiu excluir
    if ( $consulta->execute() ) {
    	?>
	    <script>
	        //mostrar a telinha animada - alert
	        Swal.fire(
	          'Sucesso',
	          'Registro excluído com sucesso',
	          'success'
	        ).then((result) => {
	            //retornar para a tela anterior
	            history.back();
	        })
	    </script>
	    <?php
    	exit;
    }

    ?>
    <script>
        //mostrar a telinha animada - alert
        Swal.fire(
          'Erro',
          'Erro ao excluir registro',
          'error'
        ).then((result) => {
            //retornar para a tela anterior
            history.back();
        })
    </script>
    <?php
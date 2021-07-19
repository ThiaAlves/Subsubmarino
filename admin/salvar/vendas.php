<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;


    if ( $_POST ) {

    	//transaction
    	$pdo->beginTransaction();

    	//recuperar os dados do form
    	foreach ($_POST as $key => $value) {
    		$$key = trim( $value );
    	}

    	//validar os dados
    	if ( empty ( $cliente_id ) ) {
    		mensagem("Erro", "Selecione um cliente", "error");
    		exit;
    	}

    	//pegar o usuário logado
		$usuario_id = $_SESSION['submarino']['id'];

    	//inserir ou atualizar
    	if ( empty ( $id ) ) {

    		$sql = "insert into venda values(NULL, :data, :status, :cliente_id, :usuario_id)"; 		
    		$consulta = $pdo->prepare($sql);
    		$consulta->bindParam(":data", $data);
    		$consulta->bindParam(":status", $status);
    		$consulta->bindParam(":cliente_id", $cliente_id);
    		$consulta->bindParam(":usuario_id", $usuario_id);

    	} else {

    		$sql = "update venda set data = :data, status = :status, cliente_id = :cliente_id, usuario_id = :usuario_id 
    			where id = :id limit 1";
    		$consulta = $pdo->prepare($sql);
    		$consulta->bindParam(":data", $data);
    		$consulta->bindParam(":status", $status);
    		$consulta->bindParam(":cliente_id", $cliente_id);
    		$consulta->bindParam(":usuario_id", $usuario_id);
    		$consulta->bindParam("id", $id);

    	}

    	//se der erro
    	if ( !$consulta->execute() ) {
    		echo $consulta->errorInfo()[2];
    		mensagem("Erro","Erro ao inserir","error");
    		exit;
    	}

    	//pegar ultimo ID inserido
    	if ( empty ( $id ) ) $id = $pdo->lastInsertId();

    	//echo "<p>ID: $id</p>";

    	//gravar
    	$pdo->commit();

    	//direcionar a página para a venda - para poder editar e adicionar produtos

    	echo "<script>location.href='cadastros/vendas/{$id}';</script>";
    	exit;
    } 

    $titulo = "Erro";
    $icone = "error";
    $mensagem = "Requisição inválida";

    mensagem($titulo, $mensagem, $icone);
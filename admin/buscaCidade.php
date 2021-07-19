<?php

	//recuperar nome da cidade e estado
	$cidade = trim ( $_GET["cidade"] ?? NULL );
	$estado = trim ( $_GET["estado"] ?? NULL );

	//se um dos dois estiver vazio - erro
	if ( (empty ( $cidade) ) or ( empty ( $estado ) ) ) {
		echo "erro";
		exit;
	}

	include "libs/conectar.php";

	$sql = "select id from cidade 
	where cidade = :cidade AND estado = :estado 
	limit 1";
	$consulta = $pdo->prepare($sql);
	$consulta->bindParam(':cidade', $cidade);
	$consulta->bindParam(':estado', $estado);
	$consulta->execute();

	//dados
	$dados = $consulta->fetch(PDO::FETCH_OBJ);

	//verificar se a cidade existe
	if ( !isset ( $dados->id ) ) {
		echo "erro";
		exit;
	}
	echo $dados->id;
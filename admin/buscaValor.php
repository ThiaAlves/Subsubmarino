<?php
	session_start();

	if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

	$produto = trim ( $_GET['produto'] ??  NULL );

	if ( !empty ( $produto ) ) {
		include "libs/conectar.php";

		$sql = "select valor, promo from produto where id = :produto limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(':produto', $produto);
		$consulta->execute();

		$dados = $consulta->fetch(PDO::FETCH_OBJ);

		//verificar se há valor promocional
		if ( ( isset ( $dados->promo ) ) and ( $dados->promo > 0 ) ) {
			echo number_format($dados->promo, 2, ",", ".");
			exit;
		}

		if ( !empty ( $dados->valor ) ) {
			echo number_format($dados->valor, 2, ",", ".");
			exit;
		}

		echo "erro";
	}
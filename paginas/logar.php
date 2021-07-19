<?php
	//verificar se a variável $pagina não existe
	if ( !isset ( $pagina ) ) exit;

	if ( $_POST ) {

		//recuperar o e-mail e a senha
		$email = trim ( $_POST["email"] ?? "" );
		$senha = trim ( $_POST["senha"] ?? "" );

		//validar se o e-mail não é válido !
		if ( !filter_var( $email, FILTER_VALIDATE_EMAIL) ) {
			//mensagem de erro em js
			echo "<script>alert('Digite um e-mail válido');history.back();</script>";
			exit;
		} else if ( strlen ( $senha ) < 4 ) {
			//mensagem de erro em js
			echo "<script>alert('Digite uma senha válida');history.back();</script>";
			exit;
		}

		$sql = "select id, nome, email, senha 
			from cliente 
			where email = '{$email}' limit 1";
		$resultado = mysqli_query( $con, $sql );
		$dados = mysqli_fetch_array( $resultado );

		//verificar se trouxe um id
		if ( empty ( $dados["id"] ) ) {
			//mensagem de erro em js
			echo "<script>alert('E-mail ou senha inválidos');history.back();</script>";
			exit;
		} else if ( password_verify($senha, $dados["senha"]) ) {
			//mensagem de erro em js
			echo "<script>alert('E-mail ou senha inválidos');history.back();</script>";
			exit;
		}

		//efetuar o login
		$_SESSION["cliente"] = array("id"=>$dados["id"],
			"nome"=>$dados["nome"],
			"email"=>$dados["email"]);
		//redirecionar
		echo "<script>location.href='index.php?pagina=carrinho';</script>";
		exit;

	}
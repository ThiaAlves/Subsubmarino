<?php
	//iniciar a sessao
	session_start();

	if ( $_POST ) {

		//recuperar os dados do formulário
		$login = trim ( $_POST['login'] ?? NULL );
		$senha = trim ( $_POST['senha'] ?? NULL );

		//verificar se os campos foram preenchidos
		if ( empty ( $login ) ) {
			echo "<script>alert('Digite um login');history.back();</script>";
			exit;
		} else if ( empty ( $senha ) ) {
			echo "<script>alert('Digite uma senha');history.back();</script>";
			exit;
		}

		//incluir o arquivo de conexao com o banco
		include "libs/conectar.php";

		//comando sql para selecione o login
		$sql = "select * from usuario where login = :login limit 1";
		//preparar o sql para execução
		$consulta = $pdo->prepare($sql);
		//passar o parametro
		$consulta->bindParam(':login', $login);
		//executo o sql
		$consulta->execute();

		//recuperar os resultados do sql
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

		if ( !isset ( $dados->nome ) ) {
			echo "<script>alert('Usuário inexistente');history.back();</script>";
			exit;
		} else if ( $dados->ativo == 'N' ) {
			echo "<script>alert('Usuário inativo');history.back();</script>";
			exit;
		} else if ( !password_verify($senha, $dados->senha) ) {
			echo "<script>alert('Usuário ou senha incorretos');history.back();</script>";
			exit;
		}

		//abrir uma variavel na sessao e gravar os dados
		$_SESSION["submarino"] = array("id"=>$dados->id,
								"nome"=>$dados->nome,
								"login"=>$dados->login, 
								"foto"=>$dados->foto,
								"tipo_id"=>$dados->tipo_id);
		//redirecionar para uma tela home
		header("Location: paginas/home");

		exit;

	} 

	echo "<script>alert('Requisição inválida, preencha os dados do formulário');history.back();</script>";

		
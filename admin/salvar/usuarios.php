<?php
	//verificar se está logado
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    //verificar se foi dado um post
    if ( $_POST ) {

    	//recuperar os dados
    	foreach ($_POST as $key => $value) {
    		$$key = trim ( $value );
    	}

    	//validar os campos
    	if ( empty ( $login ) ) {
    		mensagem("Erro","Preencha o login","error");
    		exit;
    	} else if ( $senha != $redigite ) {
    		mensagem("Erro","As senhas digitadas não são iguais","error");
    		exit;
    	}

    	//copiar o arquivo de foto, se existir
    	if ( !empty ( $_FILES["foto"]["name"] ) ) {

    		//copiar p o servidor
    		if ( !move_uploaded_file($_FILES["foto"]["tmp_name"], "../arquivos/".$_FILES["foto"]["name"] ) ) {

    			mensagem("Erro","Não foi possível copiar a foto","error");
    			exit;

    		}

    		//dar um novo nome ao arquivo
    		$foto = time()."_".$_SESSION["submarino"]["id"];

    		include "libs/imagem.php";

    		loadImg("../arquivos/".$_FILES["foto"]["name"], $foto, "../arquivos/");

    	}

    	//verificar se é insert ou update
    	if ( empty ( $id ) ) {
    		//insert
    		//criptografar a senha
    		$senha = password_hash($senha, PASSWORD_DEFAULT);
    		$sql = "insert into usuario values(NULL, :nome, :email, :login, :senha, :foto, :tipo_id, :ativo)";
    		$consulta = $pdo->prepare($sql);
    		$consulta->bindParam(":nome", $nome);
    		$consulta->bindParam(":email", $email);
    		$consulta->bindParam(":login", $login);
    		$consulta->bindParam(":senha", $senha);
    		$consulta->bindParam(":foto", $foto);
    		$consulta->bindParam(":tipo_id", $tipo_id);
    		$consulta->bindParam(":ativo", $ativo);
    	} else {

    		//s de senha com null
    		$f = $s = NULL;

    		//verificar se existe senha
    		if ( !empty ( $senha ) ) {
    			//criptografar a senha
    			$senha = password_hash($senha, PASSWORD_DEFAULT);
    			$s = ", senha = :senha ";
    		}
    		if ( !empty ( $foto ) ) {
    			$f = ", foto = :foto ";
    		}

    		$sql = "update usuario set 
    			nome = :nome, email = :email, 
    			tipo_id = :tipo_id, ativo = :ativo 
    			$f 
    			$s
    			where id = :id limit 1";
    		$consulta = $pdo->prepare($sql);
    		$consulta->bindParam(":nome", $nome);
    		$consulta->bindParam(":email", $email);
    		$consulta->bindParam(":tipo_id", $tipo_id);
    		$consulta->bindParam(":ativo", $ativo);
    		$consulta->bindParam(":id", $id);

    		if ( !empty( $s ) ) {
    			$consulta->bindParam(":senha", $senha);
    		}
    		if ( !empty( $f ) ) {
    			$consulta->bindParam(":foto", $foto);
    		}
    	}

    	//executar o insert ou update
    	if ( $consulta->execute() ) {
    		mensagem("Salvo","Registro salvo com sucesso","ok");
    		exit;
    	}

    	mensagem("Erro","Erro ao salvar","error");
    	exit;
    }

    //se tentar acessar sem passar pelo form
    mensagem("Erro","Requisição inválida","error");
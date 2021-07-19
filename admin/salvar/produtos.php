<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    if ( $_POST ) {

    	//print_r( $_POST );

    	//print_r( $_FILES );

    	//recuperar os dados dados

    	/*$id = "igor";

    	echo "<p>O valor de id é $id</p>";

    	$$id = "chimbinha";

    	echo "<p>O valor de igor é $igor $id</p>";

    	$$igor = "joelma";

    	echo "<p>O valor de chimbinha é $chimbinha</p>";*/


        include "libs/imagem.php";

    	foreach ($_POST as $key => $value) {
    		//echo "<p>{$key} - {$value}</p>";
    		$$key = trim ( $value );
    	}

    	if ( empty ( $produto ) ) {
    		$titulo = "Erro ao salvar";
    		$mensagem = "Preencha o campo produto";
    		$icone = "error";

    		mensagem($titulo, $mensagem, $icone);
    	} else if ( empty ( $descricao ) ) {
 
     		mensagem("Erro ao salvar", 
     			"Preencha o campo descrição", 
     			"error");
    	}

    	/*echo formatarValor($valor);

    	$v = "1.456,98";
    	echo "<br>".formatarValor($v);

    	echo "<br>".formatarValor('1.672,91');*/

    	$valor = formatarValor($valor);
    	$promo = formatarValor($promo);

        //programação para copiar uma imagem
        //no insert envio da foto é obrigatório
        //no update só se for selecionada uma nova imagem

        //print_r ( $_FILES );

        //se o id estiver em branco e o imagem tbém - erro
        if ( ( empty ( $id ) ) and ( empty ( $_FILES['imagem']['name'] ) ) ) {
            mensagem("Erro ao enviar imagem", 
                "Selecione um arquivo JPG válido", 
                "error");
        } 

        //se existir imagem - copia para o servidor
        if ( !empty ( $_FILES['imagem']['name'] ) ) {
            //calculo para saber quantos mb tem o arquivo
            $tamanho = $_FILES['imagem']['size'];
            $t = 8 * 1024 * 1024; //byte - kbyte - megabyte

            $imagem = time();
            $usuario = $_SESSION['submarino']['id'];

            //definir um nome para a imagem
            $imagem = "produto_{$imagem}_{$usuario}";

            //echo "<p>{$imagem}</p>"; exit;

            //validar se é jpg
            if ( $_FILES['imagem']['type'] != 'image/jpeg' ) {
                mensagem("Erro ao enviar imagem", 
                "O arquivo enviado não é um JPG válido, selecione um arquivo JPG", 
                "error");
            } else if ( $tamanho > $t ) {
                mensagem("Erro ao enviar imagem", 
                "O arquivo é muito grande e não pode ser enviado. Tente arquivos menores que 8 MB", 
                "error");
            } else if ( !copy ( $_FILES['imagem']['tmp_name'], '../produtos/'.$_FILES['imagem']['name'] ) ) {
                mensagem("Erro ao enviar imagem", 
                "Não foi possível copiar o arquivo para o servidor", 
                "error");
            }

            //redimensionar a imagem
            $pastaFotos = '../produtos/';
            loadImg($pastaFotos.$_FILES['imagem']['name'], 
                    $imagem, 
                    $pastaFotos);

        } //fim da verificação da foto

        //se vai dar insert ou update
        if ( empty ( $id ) ) {

            $sql = "insert into produto values( NULL, :produto, :descricao, :valor, :promo, :imagem, :ativo, :categoria_id )";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(':produto', $produto);
            $consulta->bindParam(':descricao', $descricao);
            $consulta->bindParam(':valor', $valor);
            $consulta->bindParam(':promo', $promo);
            $consulta->bindParam(':imagem', $imagem);
            $consulta->bindParam(':ativo', $ativo);
            $consulta->bindParam(':categoria_id', $categoria_id);

        } else if ( empty ( $imagem ) ) {

            $sql = "update produto set produto = :produto, descricao = :descricao, valor = :valor, promo = :promo, ativo = :ativo, categoria_id = :categoria_id where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(':produto', $produto);
            $consulta->bindParam(':descricao', $descricao);
            $consulta->bindParam(':valor', $valor);
            $consulta->bindParam(':promo', $promo);
            $consulta->bindParam(':ativo', $ativo);
            $consulta->bindParam(':categoria_id', $categoria_id);
            $consulta->bindParam(':id', $id);

        } else {

            $sql = "update produto set produto = :produto, descricao = :descricao, valor = :valor, promo = :promo, imagem = :imagem, ativo = :ativo, categoria_id = :categoria_id where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(':produto', $produto);
            $consulta->bindParam(':descricao', $descricao);
            $consulta->bindParam(':valor', $valor);
            $consulta->bindParam(':promo', $promo);
            $consulta->bindParam(':imagem', $imagem);
            $consulta->bindParam(':ativo', $ativo);
            $consulta->bindParam(':categoria_id', $categoria_id);
            $consulta->bindParam(':id', $id);

        }

        //executar e verificar se foi salvo de verdade
        if ( $consulta->execute() ) {
            mensagem("OK", 
                "Registro salvo/alterado com sucesso!", 
                "ok");
        } else {
            echo $erro = $consulta->errorInfo()[2];

            mensagem("Erro", 
                "Erro ao salvar ou alterar registro", 
                "error");
        }


    }
<?php

	/*
	    validaCPF - função para validar CPF
	    Como usar: 
	    $cpf = "123.123.123-34";
	    $msg = validaCPF($cpf);
	    if ( $msg != 1 ) echo $msg; //deu erro
	    retornando 1 o documento é inválido
	*/
	function validaCPF($cpf) {
	 
	    // Extrai somente os números
	    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
	     
	    // Verifica se foi informado todos os digitos corretamente
	    if (strlen($cpf) != 11) {
	        return "O CPF precisa ter ao menos 11 números";
	    }
	    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
	    if (preg_match('/(\d)\1{10}/', $cpf)) {
	        return "CPF inválido";
	    }
	    // Faz o calculo para validar o CPF
	    for ($t = 9; $t < 11; $t++) {
	        for ($d = 0, $c = 0; $c < $t; $c++) {

	            $d += $cpf[$c] * (($t + 1) - $c);
	        }
	        $d = ((10 * $d) % 11) % 10;

	        if ($cpf[$c] != $d) {
	            return "CPF inválido 2";
	        }
	    }
	    return true;
	}

	function validaCNPJ($cnpj) {
	    $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
	    // Valida tamanho
	    if (strlen($cnpj) != 14)
	        return "CNPJ precisa ter ao menos 14 números";
	    // Valida primeiro dígito verificador
	    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
	    {
	        $soma += $cnpj[$i] * $j;
	        $j = ($j == 2) ? 9 : $j - 1;
	    }
	    $resto = $soma % 11;
	    if ($cnpj."12" != ($resto < 2 ? 0 : 11 - $resto))
	        return "CNPJ inválido";
	    // Valida segundo dígito verificador
	    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
	    {
	        $soma += $cnpj[$i] * $j;
	        $j = ($j == 2) ? 9 : $j - 1;
	    }
	    $resto = $soma % 11;
	    return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
	}


	function validarSenha($senha) {
		if (!preg_match(("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$*&@#])[0-9a-zA-Z$*&@#]{8,}$/i"),$senha)) {
			return "A senha deve conter 8 caracteres, sendo um caracter especial e um número";
		}
		return;
	}

	/* **********************************
	* Função para mostrar a mensagem de erro
	* $titulo - titulo da janela
	* $mensagem - mensagem da janela
	* $icone - icone da janela (error, success, question)
	************************************* */

	function mensagem($titulo, $mensagem, $icone) {

		?>
        <script>
            //mostrar a telinha animada - alert
            Swal.fire(
              '<?=$titulo?>',
              '<?=$mensagem?>',
              '<?=$icone?>'
            ).then((result) => {
                //retornar para a tela anterior
                history.back();
            })
        </script>
        <?php

        exit;

	}

	/* *********************************
	* Função para formatar valores
	* $valor - valor em pt
	*********************************** */

	function formatarValor( $valor ) {

		//10.900,00 -> 10900.00
		$valor = str_replace(".", "", $valor);
		return str_replace(",", ".", $valor);

	}

	/*************************************
	* Função para formatar valor brasileiro
	* $valor - valor em usa
	************************************ */

	function formatarValorBR( $valor ) {
		return number_format($valor, 2, ",", ".");
		//$valor - casas decimais - separador de decimais - separador de milhares
	}


	/***************************************
	* Função para pesquisar o acesso
	* $pdo - conexão com o banco
	* $arquivo / tabela que irá verificar
	*************************************** */
	function acesso($pdo, $arquivo) {
		$tipo_id = $_SESSION["submarino"]["tipo_id"];

        $sql = "select acesso from acesso where tabela = :arquivo AND 
            tipo_id = :tipo_id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":arquivo", $arquivo);
        $consulta->bindParam(":tipo_id", $tipo_id);
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        return $acesso = $dados->acesso ?? "N";
	}


	/***************************************
	* Pegar o total da venda
	************************************** */
	function getTotal($pdo, $venda_id) {

		$sql = "select sum(valor * quantidade) total 
		from venda_produto
		where venda_id = :venda_id limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(":venda_id", $venda_id);
		$consulta->execute();

		$total = $consulta->fetch(PDO::FETCH_OBJ)->total;

		//$dados = $consulta->fetch(PDO::FETCH_OBJ);
		//$total = $dados->total;

		return number_format($total,2,",",".");
	} 
<?php
	
	//servidor do banco de dados
	$servidor = "localhost";
	//usuario de conexao com o banco
	$usuario  = "root";
	//senha de conexao com o banco
	$senha    = "2308";
	//nome do banco de dados
	$banco    = "sistemas";

	//$con - conexao(servidor, usuario, senha, banco)
	$con = mysqli_connect($servidor,$usuario,$senha,$banco) or die ("Erro ao conectar no banco. Erro: ".mysqli_connect_error());
	//configurando os caracteres da conexao
	mysqli_set_charset($con,"utf8");
	
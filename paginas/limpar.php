<?php
	//verificar se a variável $pagina não existe
	if ( !isset ( $pagina ) ) exit;

	//apagar o conteudo do carrinho
	unset ( $_SESSION['carrinho'] );

	//enviar a página para o carrinho
	echo "<script>location.href='index.php?pagina=carrinho';</script>";

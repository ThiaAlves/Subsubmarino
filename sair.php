<?php
	session_start();
	//apagar o cliente
	unset ( $_SESSION['cliente'] );
	//redirecionar para o carrinho
	echo "<script>location.href='index.php?pagina=carrinho'</script>";
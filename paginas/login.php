<?php
	//verificar se a variável $pagina não existe
	if ( !isset ( $pagina ) ) exit;
?>
<h1>Efetuar Login</h1>
<form name="formLogin" method="post" action="index.php?pagina=logar" data-parsley-validate="">
	<label for="email">E-mail:</label>
	<input type="email" name="email" class="form-control" required
	data-parsley-required-message="Digite um e-mail"
	data-parsley-type-message="Insira um e-mail válido">
	<br>
	<label for="senha">Senha:</label>
	<input type="password" name="senha" class="form-control" required 
	data-parsley-required-message="Digite sua senha">
	<br>
	<button type="submit" class="btn btn-success">
		<i class="fas fa-check"></i> Efetuar Login
	</button>
</form>
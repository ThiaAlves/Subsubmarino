<?php
	
	$senha = "casa";
	$senha = password_hash($senha, PASSWORD_DEFAULT);
	echo $senha;
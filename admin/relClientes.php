<?php
    session_start();
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de e-commerce SubSubMarino">
    <meta name="author" content="">

    <title>ADMIN - SubSubmarino</title>

    <base href="<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]; ?>">

   
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">


</head>

<body id="page-top">

	<div class="container">
		<h2 class="text-center">Relatório de Clientes</h2>
	</div>

	<?php

		$palavra = trim ( $_POST['palavra'] ?? NULL );
		$filtro = trim ( $_POST['filtro'] ?? NULL );

		$palavra = "%{$palavra}%";

		include "libs/conectar.php";

		if ( empty ( $filtro ) ) {

			
			$sql = "select c.*, i.cidade, i.estado, date_format(c.dataNascimento, '%d/%m/%Y') dataNascimento 
			from cliente c 
			inner join cidade i on (i.id = c.cidade_id)
			where c.nome like :palavra or c.cpf like :palavra or i.cidade like :palavra 
			order by c.nome";
			$consulta = $pdo->prepare($sql);

		} else if ( $filtro == "n" ) {

			$sql = "select c.*, i.cidade, i.estado, date_format(c.dataNascimento, '%d/%m/%Y') dataNascimento 
			from cliente c 
			inner join cidade i on (i.id = c.cidade_id)
			where c.nome like :palavra  
			order by c.nome";
			$consulta = $pdo->prepare($sql);

		} else if ( $filtro == "c" ) {

			$sql = "select c.*, i.cidade, i.estado, date_format(c.dataNascimento, '%d/%m/%Y') dataNascimento 
			from cliente c 
			inner join cidade i on (i.id = c.cidade_id)
			where c.cpf like :palavra  
			order by c.nome";
			$consulta = $pdo->prepare($sql);

		}

		$consulta->bindParam(':palavra', $palavra);
		$consulta->execute();

	?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<td>ID</td>
				<td>Nome do Cliente</td>
				<td>CPF</td>
				<td>Telefone</td>
				<td>Data de Nascimento</td>
			</tr>
		</thead>
		<?php

			while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

				echo "<tr>
					<td>{$dados->id}</td>
					<td>{$dados->nome}</td>
					<td>{$dados->cpf}</td>
					<td>{$dados->celular}</td>
					<td>{$dados->dataNascimento}</td>
				</tr>";

			}

		?>
	</table>
</body>
</html>
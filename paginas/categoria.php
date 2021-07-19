<?php
	//verificar se a variável $pagina não existe
	if ( !isset ( $pagina ) ) exit;
	$id = $_GET['id'] ?? '';

	$sql = "select categoria from categoria where id = ".(int)$id." limit 1";
	$result = mysqli_query($con, $sql);
	$dados = mysqli_fetch_array( $result );
?>
<h1>Categoria: <?=$dados['categoria']?></h1>

<div class="row">
	<?php
		//selecionar 6 produtos - rand -> sorteio - limit limitar o nr de resultado
		$sql = "select * from produto where categoria_id = ".(int)$id;
		//executar o sql
		$result = mysqli_query($con, $sql);

		//separar os dados por linha
		while ( $dados = mysqli_fetch_array( $result ) ) {
			//separar
			$id = $dados["id"];
			$produto = $dados["produto"];
			$imagem = $dados["imagem"];
			$valor = $dados["valor"];
			$promo = $dados["promo"];

			//se tiver promo - valor = valor da promo
			//senao valor = valor do produto

			//se a promo esta vazio - valor = valor do produto
			if ( empty ( $promo ) ) {
				//1499.99 -> 1.499,99
				$valor = "R$ " . number_format($valor, 2, ",", ".");
				$de = "";
			} else {
				//valor normal
				$de = "R$ " . number_format($valor, 2, ",", ".");
				//valor promocional
				$valor = "R$ " . number_format($promo, 2, ",", ".");
			}

			echo "<div class='col-12 col-md-4 text-center'>
				<img src='produtos/{$imagem}m.jpg' alt='{$produto}' class='w-100'>
				<h2>{$produto}</h2>
				<p class='de'>{$de}</p>
				<p class='valor'>{$valor}</p>
				<p>
					<a href='index.php?pagina=produto&id={$id}' class='btn btn-success btn-lg w-100'>
					Detalhes
					</a>
				</p>
			</div>";

		}
	?>
</div>
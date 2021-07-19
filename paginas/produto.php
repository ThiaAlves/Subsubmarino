<?php
	//verificar se a variável $pagina não existe
	if ( !isset ( $pagina ) ) exit;

	//print_r ( $_GET );

	//recuperacao do id
	//trim retira espaços em branco
	$id = trim( $_GET["id"] ?? "" );

	$id = (int)$id;

	//var_dump($id);
	//recuperar o produto com o id
	$sql    = "select * from produto where id = {$id} limit 1";
	$result = mysqli_query($con, $sql);
	$dados  = mysqli_fetch_array($result);

	//print_r ( $dados );

	//recuperar os dados do banco
	$id 	   = $dados["id"];
	$produto   = $dados["produto"];
	$valor     = $dados["valor"];
	$promo     = $dados["promo"];
	$descricao = $dados["descricao"];
	$imagem    = $dados["imagem"];

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
?>
<h1><?=$produto?></h1>
<div class="row">
	<div class="col-12 col-md-4">
		<a href="produtos/<?=$imagem?>g.jpg" data-lightbox="produto" title="<?=$produto?>">
			<img src="produtos/<?=$imagem?>m.jpg" alt="<?=$produto?>" class="w-100">
		</a>
	</div>
	<div class="col-12 col-md-8">
		

		<p class='de text-center'><?=$de;?></p>
		<p class='valor text-center'><?=$valor;?></p>

		<form name="formProduto" method="post" action="index.php?pagina=adicionar">
			<input type="hidden" name="id" value="<?=$id?>">
			<div class="input-group">
				<input type="number" name="quantidade" value="1" class="form-control form-control-lg" placeholder="Quantidade" required
				inputmode="numeric">
				<div class="input-group-append">
					<button type="submit" class="btn btn-success btn-lg">
						<i class="fas fa-check"></i> Adicionar ao Carrinho
					</button>
				</div>
			</div>
		</form>

		<br><br>

		<h2 class="text-center">Descrição do Produto:</h2>

		<?=nl2br($descricao);?>
	</div>
</div>

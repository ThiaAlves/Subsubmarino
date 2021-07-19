<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    $produto = $descricao = $valor = $promo = $imagem = $ativo = $categoria_id = NULL;


    //select para edição
    if ( ! empty ( $id ) ) {

        //sql para recuperar os dados daquele id
        $sql = "select * from produto where id = :id limit 1";
        //pdo - preparar
        $consulta = $pdo->prepare($sql);
        //passar um parametro - id
        $consulta->bindParam(':id', $id);
        //executar o sql
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //recuperar os dados
        $produto = $dados->produto;
        $descricao = $dados->descricao;
        $valor = formatarValorBR($dados->valor);
        $promo = formatarValorBR($dados->promo);
        $imagem = $dados->imagem;
        $ativo = $dados->ativo;
        $categoria_id =$dados->categoria_id;

    }

?>
<div class="card">
	<div class="card-header">
		<h3 class="float-left">Cadastro de Produtos</h3>
		<div class="float-right">
			<a href="cadastros/produtos" class="btn btn-info">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/produtos" class="btn btn-info">
        		<i class="fas fa-search"></i> Listar
        	</a>
		</div>
	</div>
	<div class="card-body">
		<form name="formCadastro" method="post" action="salvar/produtos" data-parsley-validate="" enctype="multipart/form-data">
			
			<div class="row">
				<div class="col-12 col-md-2">
					<label for="id">ID:</label>
					<input type="text" name="id" id="id"
					class="form-control" readonly
					value="<?=$id?>">
				</div>
				<div class="col-12 col-md-10">
					<label for="produto">Nome do Produto*:</label>
					<input type="text" name="produto"
					id="produto" class="form-control" required data-parsley-required-message="Digite o nome do produto"
					value="<?=$produto?>"  maxlength="200">
				</div>
				<div class="col-12 col-md-12">
					<label for="descricao">Descrição do Produto*:</label>
					<textarea name="descricao" id="descricao" class="form-control" required data-parsley-required-message="Digite a descrição do produto" rows="10"><?=$descricao?></textarea>
				</div>
				<div class="col-12 col-md-4">
					<label for="valor">Valor do Produto*:</label>
					<input type="text" name="valor" id="valor" class="form-control valor" required 
					data-parsley-required-message="Digite o valor do produto" inputmode="numeric" value="<?=$valor?>">
				</div>
				<div class="col-12 col-md-4">
					<label for="promo">Valor Promocional:</label>
					<input type="text" name="promo" id="promo" class="form-control valor" 
					inputmode="numeric" value="<?=$promo?>">
				</div>
				<div class="col-12 col-md-4">
					<?php

						$required = ' required data-parsley-required-message="Selecione um arquivo" ';
						$link = NULL;

						//verificar se a imagem não esta em branco
						if ( !empty ( $imagem ) ) {
							//caminho para a imagem
							$img = "../produtos/{$imagem}m.jpg";
							//criar um link para abrir a imagem
							$link = "<a href='{$img}' data-lightbox='foto' class='badge badge-success'>Abrir imagem</a>";
							$required = NULL;

						}

					?>
					<label for="imagem">Imagem (JPG)* <?=$link?>:</label>
					<input type="file" name="imagem" 
					id="imagem" class="form-control"
					<?=$required?> accept="image/jpeg">
				</div>
				<div class="col-12 col-md-8">
					<label for="categoria_id">Selecione uma Categoria*:</label>
					<select name="categoria_id" id="categoria_id" class="form-control" required data-parsley-required-message="Selecione uma categoria">
						<option value=""></option>
						<?php
						//selecionar todas as categoria
						$sql = "select id, categoria from categoria order by categoria";
						$consulta = $pdo->prepare($sql);
						$consulta->execute();

						while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

							echo "<option value='{$dados->id}'>{$dados->categoria}</option>";

						}

						?>
					</select>
				</div>
				<div class="col-12 col-md-4">
					<label for="ativo">Ativo:</label>
					<select name="ativo" id="ativo" class="form-control" required data-parsley-required-message="Selecione uma opção">
						<option value="">Selecione</option>
						<option value="S">Sim</option>
						<option value="N">Não</option>
					</select>
				</div>
			</div>

			<button type="submit" class="btn btn-success float-right">
				<i class="fas fa-check"></i> Salvar / Alterar
			</button>

			<br>
			<p>
				<small>* Obrigatório o preenchimento</small>
			</p>
		</form>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#descricao").summernote({
			height: '200px',
			lang: 'pt-BR',
			toolbar: [
	          ['style', ['style']],
	          ['font', ['bold', 'underline', 'clear']],
	          ['color', ['color']],
	          ['para', ['ul', 'ol', 'paragraph']],
	          ['table', ['table']],
	          ['insert', ['link', 'picture', 'video']],
	          ['view', ['codeview']]
	        ]
		});

		$(".valor").maskMoney({
			thousands: '.',
			decimal: ','
		});

		//selecionar a categoria
		$("#categoria_id").val(<?=$categoria_id?>);
		$("#ativo").val("<?=$ativo?>");
		
	})
</script>



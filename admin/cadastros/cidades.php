<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    $tabela = "cidades";

    $cidade = $estado = NULL;

    if ( !empty ( $id ) ) {

        //sql para recuperar os dados daquele id
        $sql = "select * from cidade where id = :id limit 1";
        //pdo - preparar
        $consulta = $pdo->prepare($sql);
        //passar um parametro - id
        $consulta->bindParam(':id', $id);
        //executar o sql
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //recuperar os dados
        $id = $dados->id;
        $cidade = $dados->cidade;
        $estado = $dados->estado;

    }
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Cadastro de Cidades</h3>

        <div class="float-right">
        	<a href="cadastros/<?=$tabela?>" class="btn btn-info">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/<?=$tabela?>" class="btn btn-info">
        		<i class="fas fa-search"></i> Listar
        	</a>
        </div>
    </div>
    <div class="card-body">
        <form name="formCadastro" method="post" action="salvar/<?=$tabela?>" data-parsley-validate="">
        	<div class="row">
        		<div class="col-12 col-md-2">
        			<label for="id">ID:</label>
        			<input type="text" name="id" id="id" class="form-control" readonly value="<?=$id?>">
        		</div>
        		<div class="col-12 col-md-8">
        			<label for="cidade">Cidade:</label>
        			<input type="text" name="cidade" id="cidade" class="form-control" required data-parsley-required-message="Preencha a cidade" value="<?=$cidade?>">
        		</div>
        		<div class="col-12 col-md-2">
        			<label for="estado">Estado:</label>
        			<select name="estado" id="estado" required data-parsley-required-message="Selecione um estado" class="form-control">
        				<option value=""></option>
        				<?php
        					//selecionar todos os estados
        					$sql = "select distinct(estado) from cidade
        						group by estado order by estado";

        					$sql = "select estado from cidade
        						group by estado order by estado";
        					$consulta = $pdo->prepare($sql);
        					$consulta->execute();

        					while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

        						echo "<option value='{$dados->estado}'>{$dados->estado}</option>";

        					}

        				?>
        			</select>
        		</div>
        	</div>

        	<button type="submit" class="btn btn-success float-right">
        		<i class="fas fa-check"></i> Salvar / Alterar
        	</button>
        </form>
    </div>
</div>
<script type="text/javascript">
    $("#estado").val("<?=$estado?>");
</script>
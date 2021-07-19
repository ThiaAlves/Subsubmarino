<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    $categoria = NULL;

    if ( ! empty ( $id ) ) {

        //sql para recuperar os dados daquele id
        $sql = "select * from categoria where id = :id limit 1";
        //pdo - preparar
        $consulta = $pdo->prepare($sql);
        //passar um parametro - id
        $consulta->bindParam(':id', $id);
        //executar o sql
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //recuperar os dados
        $id = $dados->id;
        $categoria = $dados->categoria;

    }

    //echo "<p>{$id} - {$categoria}</p>";
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Cadastro de Categorias</h3>

        <div class="float-right">
        	<a href="cadastros/categorias" class="btn btn-info">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/categorias" class="btn btn-info">
        		<i class="fas fa-search"></i> Listar
        	</a>
        </div>
    </div>
    <div class="card-body">
        <form name="formCadastro" method="post" action="salvar/categorias" data-parsley-validate="">
        	<div class="row">
        		<div class="col-12 col-md-2">
        			<label for="id">ID:</label>
        			<input type="text" name="id" id="id" class="form-control" readonly value="<?=$id?>">
        		</div>
        		<div class="col-12 col-md-10">
        			<label for="categoria">Categoria:</label>
        			<input type="text" name="categoria" id="categoria" class="form-control" required data-parsley-required-message="Preencha a categoria" value="<?=$categoria?>">
        		</div>
        	</div>

        	<button type="submit" class="btn btn-success float-right">
        		<i class="fas fa-check"></i> Salvar / Alterar
        	</button>
        </form>
    </div>
</div>
<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Relatório de Clientes</h3>

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

    	<form name="form1" method="post" action="relClientes.php" target="_blank">
    		<div class="row">
    			<div class="col-12 col-md-6">
    				<input type="text" name="palavra" class="form-control" placeholder="Digite uma palavra">
    			</div>
    			<div class="col-12 col-md-4">
    				<select name="filtro" class="form-control">
    					<option value="">Todos</option>
    					<option value="n">Nome</option>
    					<option value="c">CPF</option>
    				</select>
    			</div>
    			<div class="col-12 col-md-2">
    				<button type="submit" class="btn btn-info">Buscar</button>
    			</div>
    		</div>
    	</form>

   	</div>
</div>
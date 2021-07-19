<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Relatório de Logs</h3>
    </div>
    <div class="card-body">

    	<form name="form1" method="post" action="relLogs.php" target="_blank">
    		<div class="row">
    			<div class="col-12 col-md-6">
    				<input type="text" name="palavra" class="form-control" placeholder="Digite o login do usuário ou parte do nome">
    			</div>
    			<div class="col-12 col-md-2">
    				<input type="text" name="inicial" class="form-control" placeholder="Data Inicial"  data-inputmask="'mask': '99/99/9999'">
    			</div>
    			<div class="col-12 col-md-2">
    				<input type="text" name="final" class="form-control" placeholder="Data Final"  data-inputmask="'mask': '99/99/9999'">
    			</div>
    			<div class="col-12 col-md-2">
    				<button type="submit" class="btn btn-info">Buscar</button>
    			</div>
    		</div>
    	</form>

   	</div>
</div>
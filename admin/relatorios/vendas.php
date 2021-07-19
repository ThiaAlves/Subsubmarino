<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;
?>
<div class="card">
	<div class="card-header">
		<h2>Relatório de Vendas</h2>
	</div>
	<div class="card-body">
		<form name="formVendas" method="post" action="relVendas.php" target="vendas" data-parsley-validate="">
			<div class="row">
				<div class="col-12 col-md-3">
					<input type="date" name="dataInicial" class="form-control" placeholder="Data Inicial" required data-parsley-required-message="Selecione uma data">
				</div>
				<div class="col-12 col-md-3">
					<input type="date" name="dataFinal"
					class="form-control" placeholder="Data Final" required data-parsley-required-message="Selecione uma data">
				</div>
				<div class="col-12 col-md-3">
					<select name="filtro" class="form-control">
						<option value="">Todos</option>
						<option value="P">Pagos</option>
						<option value="A">Aguardando Pagamento</option>
						<option value="C">Cancelados</option>
					</select>
				</div>
				<div class="col-12 col-md-3">
					<button type="submit" class="btn btn-info">
						<i class="fas fa-search"></i> Mostrar
					</button>
				</div>
			</div>
		</form>

	</div>
</div>
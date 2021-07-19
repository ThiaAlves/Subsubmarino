<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    $tabela = "vendas";
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Listar Vendas</h3>

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

    	<table class="table table-hover table-bordered table-striped">
    		<thead>
    			<tr>
    				<td>ID</td>
    				<td>Cliente</td>
    				<td>Usuário</td>
    				<td>Data</td>
    				<td>Status</td>
    				<td>Total</td>
    				<td>Opções</td>
    			</tr>
    		</thead>
    		<tbody>
    			<?php
    				$sql = "select v.id, c.nome cliente, u.nome usuario,
    				date_format(v.data, '%d/%m/%Y') data, v.status
    				from venda v 
    				inner join cliente c on (c.id = v.cliente_id)
    				left join usuario u on (u.id = v.usuario_id)
    				order by v.data desc";
    			    $consulta = $pdo->prepare($sql);
    			    $consulta->execute();

    			    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

    			    	$status = "<span class='badge badge-success'>Pago</span>";

    			    	if ( $dados->status == "C" )
    			    		$status = "<span class='badge badge-danger'>Cancelado</span>";
    			    	else if ($dados->status == "A")
    			    		$status = "<span class='badge badge-info'>Aguardando<br> Pagamento</span>";
    			    	else if ($dados->status == "T")
    			    		$status = "<span class='badge badge-warning'>Troca</span>";
    			    	else if ($dados->status == "E")
    			    		$status = "<span class='badge badge-warning'>Extraviado</span>";
    			    	else if ($dados->status == "D")
    			    		$status = "<span class='badge badge-danger'>Devolvido</span>";

    			    	?>
    			    	<tr>
    			    		<td><?=$dados->id?></td>
    			    		<td><?=$dados->cliente?></td>
    			    		<td><?=$dados->usuario?></td>
    			    		<td><?=$dados->data?></td>
    			    		<td><?=$status?></td>
    			    		<td>Total</td>
    			    		<td>
    			    			<a href="cadastros/vendas/<?=$dados->id?>" class="btn btn-success">
    			    				<i class="fas fa-edit"></i>
    			    			</a>
    			    		</td>
    			    	</tr>
    			    	<?php
    			    }
    			?>
    		</tbody>
    	</table>


    </div> <!-- card-body -->
</div> <!-- card -->
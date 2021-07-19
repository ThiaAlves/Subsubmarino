<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Listagem de Produtos</h3>

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
        <p>Resultados:</p>

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <td width="10%">ID</td>
                    <td width="40%">Nome do Produto</td>
                    <td width="20%">Categoria</td>
                    <td width="10%">Valor</td>
                    <td width="10%">Imagem</td>
                    <td width="10%">Opções</td>
                </tr>      
            </thead>
            <tbody>
                <?php

                    $sql = "select p.id, p.produto, p.valor, p.imagem, c.categoria
                        from produto p
                        inner join categoria c on ( c.id = p.categoria_id ) 
                        order by p.produto";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

                        $valor  = number_format( $dados->valor,2, ',' , '.' );
                        
                        $imagem = "../produtos/{$dados->imagem}p.jpg"; 
                        $imagemg = "../produtos/{$dados->imagem}g.jpg";

                        ?>
                        <tr>
                            <td><?=$dados->id?></td>
                            <td><?=$dados->produto?></td>
                            <td><?=$dados->categoria?></td>
                            <td><?=$valor?></td>
                            <td>
                                <a href="<?=$imagemg?>" data-lightbox="foto" title="<?=$dados->produto?>">
                                    <img src="<?=$imagem?>" alt="<?=$dados->produto?>" width="100px">
                                </a>
                            </td>
                            <td>
                                <a href="cadastros/produtos/<?=$dados->id?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="javascript:excluir(<?=$dados->id?>)" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <?php

                    }
                ?>

            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    function excluir(id) {

        Swal.fire({
          title: 'Deseja realmente excluir este registro?',
          showCancelButton: true,
          confirmButtonText: `Sim`,
          cancelButtonText: `Não`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            //enviar para excluir
            location.href='excluir/produtos/'+id;
          } 
        })
    }
</script>
<script src="js/dataTable.js"></script>
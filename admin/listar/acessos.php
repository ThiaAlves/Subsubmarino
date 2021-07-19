<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Listagem de Acessos</h3>

        <div class="float-right">
        	<a href="cadastros/acessos" class="btn btn-info">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/acessos" class="btn btn-info">
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
                    <td width="60%">Tipo de Usuário</td>
                    <td width="10%">Tabela</td>
                    <td width="10%">Acesso</td>
                    <td width="10%">Opções</td>
                </tr>      
            </thead>
            <tbody>
                <?php
            
                    $sql = "select a.*, t.tipo 
                        from acesso a 
                        inner join tipo t on (t.id = a.tipo_id) 
                        order by a.tabela";
                    //pdo -> prepare
                    $consulta = $pdo->prepare($sql);
                    //executar o comando sql
                    $consulta->execute();

                    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ){

                        $acesso = "Sim";

                        if ( $dados->acesso == "N" ) $acesso = "Não";

                        ?>
                        <tr>
                            <td><?=$dados->id?></td>
                            <td><?=$dados->tipo?></td>
                            <td><?=$dados->tabela?></td>
                            <td><?=$acesso?></td>
                            <td>
                                <a href="cadastros/acessos/<?=$dados->id?>" class="btn btn-success btn-sm">
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
            location.href='excluir/acessos/'+id;
          } 
        })
    }
</script>
<script src="js/dataTable.js"></script>
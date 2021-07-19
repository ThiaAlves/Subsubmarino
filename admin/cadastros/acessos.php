<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    $tabela = "acessos";

    $tipo_id = $tab = $acesso = NULL;

    if ( !empty ( $id ) ) {

        //sql para recuperar os dados daquele id
        $sql = "select * from acesso where id = :id limit 1";
        //pdo - preparar
        $consulta = $pdo->prepare($sql);
        //passar um parametro - id
        $consulta->bindParam(':id', $id);
        //executar o sql
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //recuperar os dados
        $id = $dados->id;
        $tipo_id = $dados->tipo_id;
        $tab = $dados->tabela;
        $acesso = $dados->acesso;

    }
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Cadastro de Acessos</h3>

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

                <div class="col-12 col-md-3">
                    <label for="tipo_id">Tipo de Usuário:</label>
                    <select name="tipo_id" id="tipo_id" required data-parsley-required-message="Selecione um Tipo" class="form-control">
                        <option value=""></option>
                        <?php
                            //selecionar todos os estados
                            $sql = "select * from tipo order by tipo";

                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

                                echo "<option value='{$dados->id}'>{$dados->tipo}</option>";

                            }

                        ?>
                    </select>
                </div>

        		<div class="col-12 col-md-4">
        			<label for="tabela">Tabela:</label>
        			<input type="text" name="tabela" id="tabela" class="form-control" required data-parsley-required-message="Preencha a tabela" value="<?=$tab?>">
        		</div>

                <div class="col-12 col-md-3">
                    <label for="acesso">Acesso?</label>
                    <select name="acesso" id="acesso" required data-parsley-required-message="Selecione uma opção" class="form-control">
                        <option value=""></option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
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
    $("#tipo_id").val("<?=$tipo_id?>");
    $("#acesso").val("<?=$acesso?>");
</script>
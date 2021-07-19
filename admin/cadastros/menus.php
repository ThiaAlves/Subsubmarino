<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    $tabela = "menus";

    $nome = $icone = $url = $tab = $icone = $submenu = NULL;

    if ( !empty ( $id ) ) {

        //sql para recuperar os dados daquele id
        $sql = "select * from menu where id = :id limit 1";
        //pdo - preparar
        $consulta = $pdo->prepare($sql);
        //passar um parametro - id
        $consulta->bindParam(':id', $id);
        //executar o sql
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //recuperar os dados
        $id     = $dados->id;
        $nome   = $dados->nome;
        $tab    = $dados->tabela;
        $url    = $dados->url;
        $icone  = $dados->icone;
        $submenu = $dados->submenu;

    }
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Cadastro de Menus</h3>

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

                <div class="col-12 col-md-5">
                    <label for="nome">Nome do Menu:</label>
                    <input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Preencha o nome" value="<?=$nome?>">
                </div>

        
        		<div class="col-12 col-md-5">
        			<label for="tabela">Tabela:</label>
        			<input type="text" name="tabela" id="tabela" class="form-control" required data-parsley-required-message="Preencha a tabela" value="<?=$tab?>">
        		</div>

                <div class="col-12 col-md-6">
                    <label for="url">URL/Link:</label>
                    <input type="text" name="url" id="url" class="form-control" required data-parsley-required-message="Preencha a url" value="<?=$url?>">
                </div>

                <div class="col-12 col-md-3">
                    <label for="icone">Ícone (Fontawesome):</label>
                    <input type="text" name="icone" id="icone" class="form-control" required data-parsley-required-message="Preencha o icone" value="<?=$icone?>">
                </div>


                <div class="col-12 col-md-3">
                    <label for="submenu">Tipo de Menu?</label>
                    <select name="submenu" id="submenu" required data-parsley-required-message="Selecione uma opção" class="form-control">
                        <option value=""></option>
                        <option value="C">Cadastros</option>
                        <option value="P">Processos</option>
                        <option value="R">Relatórios</option>
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
    $("#submenu").val("<?=$submenu?>");
</script>
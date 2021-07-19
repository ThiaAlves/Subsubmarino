<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    $tabela = "vendas";

    $data = $status = $cliente_id = $usuario_id = 
    $cliente = NULL;
    //status A - Aguardando Pagamento
    //C - Cancelado
    //P - Pago
    //D - Devolvido
    //T - Troca
    //E - Extraviado

    if ( !empty ( $id ) ) {

        //sql para recuperar os dados daquele id
        $sql = "select v.*, date_format(v.data,'%Y-%m-%d') data,
            c.nome cliente, c.celular 
            from venda v 
            inner join cliente c on (c.id = v.cliente_id)
            where v.id = :id limit 1";
        //pdo - preparar
        $consulta = $pdo->prepare($sql);
        //passar um parametro - id
        $consulta->bindParam(':id', $id);
        //executar o sql
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //recuperar os dados
        $celular = $dados->celular;
        $cliente = $dados->cliente;
        $id = $dados->id;
        $status = $dados->status;
        $data = $dados->data;
        $cliente_id = $dados->cliente_id;
        $usuario_id = $dados->usuario_id;

        //formatar o nome do cliente
        $cliente = "{$cliente_id} - {$cliente} - {$celular}";
    }
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Efetuar Venda</h3>

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
                <div class="col-12 col-md-4">
                    <label for="data">Data:</label>
                    <input type="date" name="data"
                    id="data" class="form-control"
                    required data-parsley-required-message="Preencha a data"
                    value="<?=$data?>">
                </div>
                <div class="col-12 col-md-6">
                    <label for="status">Status:</label>
                    <select name="status" id="status"
                    class="form-control" required
                    data-parsley-required-message="Selecione um Status">
                        <option value=""></option>
                        <option value="A">Aguardando Pagamento</option>
                        <option value="P">Pago</option>
                        <option value="C">Cancelado</option>
                        <option value="E">Extraviado</option>
                        <option value="D">Devolvido</option>
                        <option value="T">Troca</option>
                    </select>

                    <script>
                        $("#status").val("<?=$status?>");
                    </script>
                </div>
                <div class="col-2">
                    <label for="cliente_id">Cliente:</label>
                    <input type="text" name="cliente_id" id="cliente_id"
                    class="form-control" required 
                    data-parsley-required-message="Selecione o cliente" readonly
                    value="<?=$cliente_id?>">
                </div>
                <div class="col-10">
                    <label for="cliente">Selecione o Cliente:</label>
                    <input type="text" name="cliente"
                    id="cliente" required
                    data-parsley-required-message="Selecione um cliente"
                    list="clientes"
                    class="form-control"
                    value="<?=$cliente?>">

                    <datalist id="clientes">
                        <?php
                            $sql = "select id, nome, celular from cliente
                                order by nome";
                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();
                            while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ){

                                echo "<option value='{$dados->id} - {$dados->nome} - {$dados->celular}'>";

                            }
                        ?>
                    </datalist>
                </div> <!-- col -->
            </div> <!-- row -->
            <button type="submit" class="btn btn-success float-right">
                Salvar/Alterar Dados
            </button>
        </form> <!-- form -->
    </div> <!-- card body -->
</div> <!-- card -->
<script type="text/javascript">
    $("#cliente").blur(function(){

        var cliente = $("#cliente").val();

        if ( cliente != "" ) {
            //separar a string pelo -
            cliente = cliente.split(" - ");
            //console.log(cliente);
            //jogar o id para o cliente_id
            $("#cliente_id").val(cliente[0]);
        }
    })
</script>

<?php
    //verificar se esta editando, e se estiver mostrar tela para adicionar produtos
    if ( !empty ( $id ) ) {

        $disabled = NULL;

        //verificar se o status é P
        if (( $status == "P" ) or ( $status == "C" ))
            $disabled = "disabled";

        ?>
        <br>
        <div class="card">
            <div class="card-header">
                <h2>Selecione um produto</h2>
            </div>
            <div class="card-body">
                <form name="formItens" id="formItens" method="post" action="itens.php" target="itens" data-parsley-validate="">
                    <input type="hidden" name="venda_id" value="<?=$id?>">
                    <div class="row">
                        <div class="col-12 col-md-2">
                            <input type="text" name="produto_id" id="produto_id" class="form-control" required data-parsley-required-message="Selecione o produto" readonly 
                            <?=$disabled?>>
                        </div>
                        <div class="col-12 col-md-4">
                            <input type="text" name="produto" id="produto"
                            class="form-control" required data-parsley-required-message="Selecione um produto" list="listProdutos" <?=$disabled?> >

                            <datalist id="listProdutos">
                            <?php
                            $sql = "select id, produto from produto where ativo = 'S' order by produto";
                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ( $d = $consulta->fetch(PDO::FETCH_OBJ) ){
                                echo "<option value='{$d->id} - {$d->produto}'>";
                            }
                            ?>
                            </datalist>
                        </div>
                        <div class="col-12 col-md-2">
                            <input type="text" name="valor" id="valor" class="form-control" required 
                            data-parsley-required-message="Preencha o valor" 
                            <?=$disabled?>>
                        </div>
                        <div class="col-12 col-md-2">
                            <input type="number" name="quantidade" id="quantidade"
                            class="form-control" required data-parsley-required-message="Preencha a quantidade" value="1" 
                            <?=$disabled?>>
                        </div>
                        <div class="col-12 col-md-2">
                            <button type="submit" class="btn btn-info" <?=$disabled?>>Inserir</button>
                        </div>
                    </div> <!-- row -->
                </form>

                <iframe src="itens.php?venda_id=<?=$id?>" width="100%"
                height="400px" name="itens"></iframe>
            </div>
        </div>

        <script type="text/javascript">
            $("#produto").blur(function(){
                //recuperar o valor do produto
                var produto = $("#produto").val();

                //verificar se não está em branco
                if ( produto != "" ) {
                    //jogar o id no produto_id
                    //1 - Nintendo Wii
                    p = produto.split(" - ");
                    //console.log(p);
                    produto = p[0];
                    $("#produto_id").val(produto);
                    //realizar a busca de valor no buscaValor.php
                    $.get("buscaValor.php",
                        {produto:produto},
                        function(dados){

                            if ( dados == "erro" ) {
                                //sweet alert
                            } else {
                                $("#valor").val(dados);
                            }
                    })

                }
            })
        </script>

        <?php
    }
?>
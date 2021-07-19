<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    $tabela = "clientes";

    $nome = $email = $cep = $logradouro = $numero = $complemento = $bairro = $cidade_id = $cpf = $dataNascimento = $celular = $cidade = $estado = NULL;
    //validação do require da senha
    $senha = " required data-parsley-required-message='Digite uma senha' ";

    if ( !empty ( $id ) ) {

    	$sql = "select c.*, 
    	date_format(c.dataNascimento, '%d/%m/%Y') dt, i.cidade, i.estado 
    	from cliente c 
    	inner join cidade i on (i.id = c.cidade_id)
    	where c.id = :id limit 1";

    	$consulta = $pdo->prepare($sql);
    	$consulta->bindParam(':id', $id);
    	$consulta->execute();

    	//recuperar os dados
    	$dados = $consulta->fetch(PDO::FETCH_OBJ);

        $id = "";

        if ( !empty( $dados->id ) ) { 
        	//separar os dados
            $id = $dados->id;
        	$nome  = $dados->nome;
        	$email = $dados->email;
        	$cep   = $dados->cep;
        	$logradouro = $dados->logradouro;
        	$numero     = $dados->numero;
        	$complemento = $dados->complemento;
        	$bairro    = $dados->bairro;
        	$cidade_id = $dados->cidade_id;
        	$cidade    = $dados->cidade;
        	$estado    = $dados->estado;
        	$cpf    = $dados->cpf;
        	$dataNascimento = $dados->dataNascimento;
        	$celular    = $dados->celular;
            //retirar a validação da senha
            $senha = NULL;
        }

    }
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Cadastro de Clientes</h3>

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
        		<div class="col-12 col-md-10">
        			<label for="nome">Nome do Cliente:</label>
        			<input type="text" name="nome" id="nome" class="form-control" required 
        			data-parsley-required-message="Digite seu nome" value="<?=$nome?>">
        		</div>
        		<div class="col-12">
        			<label for="email">E-mail:</label>
        			<input type="email" name="email" id="email"
        			class="form-control" required data-parsley-required-message="Digite seu e-mail" 
        			value="<?=$email?>">
        		</div>
        		<div class="col-12 col-md-6">
        			<label for="senha">Senha:</label>
        			<input type="password" name="senha" id="senha" class="form-control"
        			<?=$senha?> >
        		</div>
        		<div class="col-12 col-md-6">
        			<label for="redigite">Redigite a senha:</label>
        			<input type="password" name="redigite" id="redigite" class="form-control" <?=$senha?>
        			data-parsley-equalto="#senha"
        			data-parsley-equalto-message="As senhas devem ser iguais">
        		</div>
        		<div class="col-12 col-md-4">
        			<label for="cpf">CPF:</label>
        			<input type="text" name="cpf" id="cpf" class="form-control"
        			required data-parsley-required-message="Digite o CPF" inputmode="numeric" value="<?=$cpf?>"
        			data-inputmask="'mask':'999.999.999-99'">
        		</div>
        		<div class="col-12 col-md-4">
        			<label for="dataNascimento">Data de Nascimento:</label>
        			<input type="date" 
        			name="dataNascimento" 
        			id="dataNascimento" 
        			class="form-control"
        			required data-parsley-required-message="Digite a data de nascimento" inputmode="numeric" 
        			value="<?=$dataNascimento?>">
        		</div>
        		<div class="col-12 col-md-4">
        			<label for="celular">Celular:</label>
        			<input type="text" name="celular" id="celular" class="form-control" required data-parsley-required-message="Digite seu celular"
        			value="<?=$celular?>"
        			data-inputmask="'mask':'(99) 99999-9999'">
        		</div>

        		<div class="col-12 col-md-2">
        			<label for="cep">CEP:</label>
        			<input type="text" name="cep" 
        			id="cep" class="form-control"
        			required data-parsley-required-message="Digite o CEP"
        			value="<?=$cep?>"
        			data-inputmask="'mask':'99999-999'">
        		</div>
        		<div class="col-12 col-md-8">
        			<label for="logradouro">Logradouro:</label>
        			<input type="text" 
        			name="logradouro" 
        			id="logradouro" 
        			class="form-control"
        			required data-parsley-required-message="Digite o logradouro"
        			value="<?=$logradouro?>">
        		</div>
        		<div class="col-12 col-md-2">
        			<label for="numero">Número:</label>
        			<input type="text" 
        			name="numero" 
        			id="numero" 
        			class="form-control"
        			required data-parsley-required-message="Digite o número" 
        			inputmode="numeric"
        			value="<?=$numero?>">
        		</div>

        		<div class="col-12 col-md-6">
        			<label for="complemento">Complemento:</label>
        			<input type="text" 
        			name="complemento" 
        			id="complemento" 
        			class="form-control"
        			value="<?=$complemento?>">
        		</div>
        		<div class="col-12 col-md-6">
        			<label for="bairro">Bairro:</label>
        			<input type="text" 
        			name="bairro" 
        			id="bairro" 
        			class="form-control"
        			required
        			data-parsley-required-message="Digite o bairro"
        			value="<?=$bairro?>">
        		</div>

        		<div class="col-12 col-md-2">
        			<label for="cidade_id">Cidade ID:</label>
        			<input type="text" 
        			name="cidade_id" 
        			id="cidade_id" 
        			class="form-control"
        			required
        			data-parsley-required-message="Digite o CEP" readonly
        			value="<?=$cidade_id?>">
        		</div>
        		<div class="col-12 col-md-8">
        			<label for="cidade">Nome da Cidade:</label>
        			<input type="text" 
        			name="cidade" 
        			id="cidade" 
        			class="form-control"
        			required
        			data-parsley-required-message="Digite o CEP" readonly
        			value="<?=$cidade?>">
        		</div>
        		<div class="col-12 col-md-2">
        			<label for="estado">Estado:</label>
        			<input type="text" 
        			name="estado" 
        			id="estado" 
        			class="form-control"
        			required
        			data-parsley-required-message="Digite o CEP" readonly
        			value="<?=$estado?>">
        		</div>
        	</div> <!-- fechando o .row -->
        	<button type="submit" class="btn btn-success float-right">
        		Salvar/Atualizar
        	</button>
        </form>
    </div> <!-- card body -->
</div> <!-- card -->

<script>
//executar somente depois de carregar
$(document).ready(function(){
    //funcao para buscar o mesmo cpf
    $("#cpf").blur(function(){
        //recuperar o id e o cpf
        var id = $("#id").val();
        var cpf = $("#cpf").val();

        if ( cpf != "" ){
            //console.log(cpf);
            $.post("buscaCpf.php",
                {cpf:cpf,id:id},
                function(dados){
                    //console.log(dados);
                    if (dados != "") {
                        Swal.fire(
                          'Erro', //titulo
                          dados, //mensagem
                          'error' //icone
                        )
                        $("#cpf").val("");
                    }
                })
        }
    })

	//funcao para apagar os dados dos campos de endereco
	function limpar() {
		$("#logradouro").val("");
		$("#numero").val("");
		$("#complemento").val("");
		$("#bairro").val("");
		$("#cidade").val("");
		$("#cidade_id").val("");
		$("#estado").val("");
		$("#cep").val("");
	}

	//funcao para buscar o id da cidade
	function buscaCidade(cidade,estado) {
		$.get("buscaCidade.php",
			{cidade:cidade,estado:estado},
			function(dados){

				//verificar erro
				if (dados == "erro") {
					limpar();
					Swal.fire(
		              'Erro',
		              'Erro ao consultar',
		              'error'
		            )
				} else {
					$("#cidade_id").val(dados);
				}
		})
	}

	//funcao para buscar o cep
	$("#cep").blur(function(){
		//recuperar o cep digitado e deixar só digitos
		cep = $("#cep").val().replace(/\D/g, '');

		//console.log(cep);

		//verificar se o cep esta em branco
		if ( cep == "" ) {
			$("#cep").focus();
			Swal.fire(
              'Erro',
              'Preencha o CEP',
              'error'
            )
		} else {
			//funcao para limpar
			//limpar();

			//endereco da pesquisa
			url = "https://viacep.com.br/ws/"+ cep +"/json/?callback=?";

			//console.log(url);

			//jquery -> recupera dados de um json
			$.getJSON( url , function(dados){
				//verificar se tem erro
				if ( "erro" in dados ) {
					//limpar e avisar o usuário
					limpar();
					Swal.fire(
		              'Erro',
		              'CEP não encontrado',
		              'error'
		            )
				} else {
					console.log(dados);

					//popular o formulario com os dados retornados
					$("#logradouro").val(dados.logradouro);
					$("#numero").focus();
					$("#bairro").val(dados.bairro);
					//nome da cidade = localidade
					$("#cidade").val(dados.localidade);
					$("#estado").val(dados.uf);

					//executa funcao buscaCidade
					buscaCidade(dados.localidade,
						dados.uf);
				}
			})
		}

	})
});

</script>
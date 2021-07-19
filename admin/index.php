<?php
    //iniciar uma sessao
    session_start();

    ini_set( 'display_errors', '1' );
    ini_set( 'upload_max_filesize', '128M' );
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de e-commerce SubSubMarino">
    <meta name="author" content="">

    <title>ADMIN - SubSubmarino</title>

    <base href="<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]; ?>">

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>

    <script src="js/lightbox-plus-jquery.min.js"></script>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="vendor/summernote/summernote.min.js"></script>
    <script type="text/javascript" src="vendor/summernote/summernote-bs4.min.js"></script>
    <script src="vendor/summernote/lang/summernote-pt-BR.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    

    <!-- Outros Javascript -->
    <script src="js/parsley.min.js"></script>
    
    <script src="js/jquery.inputmask.min.js"></script>
    <script src="js/bindings/inputmask.binding.js"></script>
    <script src="js/jquery.maskMoney.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/sweetalert2.js"></script>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/lightbox.min.css">

    <link rel="stylesheet" type="text/css" href="vendor/summernote/summernote.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" type="text/css" href="css/sweetalert2.min.css">

</head>

<body id="page-top">
    <?php
    //verificar se o usuário está logado
    if ( !isset ( $_SESSION["submarino"]["id"] ) ) {
        //mostrar a tela de login
        include "paginas/login.php";
    } else {
        
        //incluir o arquivo de conexao com o banco
        include "libs/conectar.php";

        //incluir o header
        include "header.php";

        // conteudo da minha página

        $pagina = "paginas/home.php";

        //verificar se o parametro existe em $_GET
        if ( isset ( $_GET['param'] ) ) {

            //recuperar o parametro
            $param = trim ( $_GET['param'] );
            //explode
            $param = explode("/", $param);

            $pasta = $param[0];
            $arquivo = $param[1];
            $id = $param[2] ?? NULL;
            $pagina = "{$pasta}/{$arquivo}.php"; 

        }


        //verificar o arquivo (tabela)
        if ( !empty ( $arquivo ) ) {

            $ip = $_SERVER['REMOTE_ADDR'];
            $acao = $pasta; //listar, excluir, cadastros
            $tabela = $arquivo; //categorias, produtos
            $usuario = $_SESSION["submarino"]["id"]; //id do usuario
            $tabela_id = $id ?? NULL;


            //se o id não estiver em branco e a acção for diferente de excluir, a ação será editar
            if ( ( !empty ( $tabela_id ) ) and ( $acao != "excluir" ) )
                $acao = "editar";

            $sql = "insert into log values (NULL,
            :usuario, NOW(), :ip, :tabela, :acao, :tabela_id )";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(':usuario', $usuario);
            $consulta->bindParam(':ip', $ip);
            $consulta->bindParam(':tabela_id', $tabela_id);
            $consulta->bindParam(':tabela', $tabela);
            $consulta->bindParam(':acao', $acao);

            if ( !$consulta->execute() )
                echo $consulta->errorInfo()[2];

        }

        /*echo "<p>{$pasta} {$arquivo}</p>"; 
        
        echo $_SERVER['REMOTE_ADDR'];

        echo "<pre>";
        print_r ( $_SERVER );*/

        
        //verificar o acesso aquele arquivo

        //pegar o tipo de usuário
        $tipo_id = $_SESSION["submarino"]["tipo_id"];

        $sql = "select acesso from acesso where tabela = :arquivo AND 
            tipo_id = :tipo_id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":arquivo", $arquivo);
        $consulta->bindParam(":tipo_id", $tipo_id);
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        $acesso = $dados->acesso ?? "N";

        //echo $acesso;

        //verificar se o arquivo existe
        if ( $acesso == "N") include "paginas/acesso.php";
        else if ( file_exists( $pagina ) ) include $pagina;
        else include "paginas/erro.php";

        //incluir o footer
        include "footer.php";
    }

    ?>
</body>

</html>
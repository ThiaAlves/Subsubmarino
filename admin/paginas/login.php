<div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" method="post" action="verificar.php">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="login" required
                                                id="login" aria-describedby="Login"
                                                placeholder="Digite seu login">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="senha" required
                                                id="senha" placeholder="Digite sua senha">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-user btn-block">
                                            Efetuar Login
                                        </button>
                                        
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>
        $(document).ready(function(){
            //var nome = 'Robson Pereira Vieira Jr';
            //localStorage.setItem('nome', nome);
            //var texto = localStorage.getItem('nome');
            //alert(texto);

            $('#customCheck').click(function(){
                if ( $('#customCheck').is(':checked') ) {
                    
                    var login = $('#login').val();
                    if ( login == '' ) {
                        alert('Preencha o campo login');
                        $('#customCheck').prop("checked", false);
                    } else {
                        localStorage.setItem('loginAdm', login);
                    }

                } else {
                    localStorage.setItem('loginAdm', '');
                }
            })

            var loginAdm = localStorage.getItem('loginAdm');
            if ( loginAdm ) {
                $('#login').val(loginAdm);
                $('#customCheck').prop("checked", true);
            }
        })
    </script>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Temperatura</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="#page-top">Temperatura</a>
                <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">Sobre</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">
                <!-- Masthead Subheading-->
                <p class="masthead-subheading font-weight-light mb-0">
                    Vamos sugerir uma musicas que são famosas na sua região.
                </p>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-music"></i></div>
                    <div class="divider-custom-line"></div>

                </div>
                <div class="row">
                    <div class="col-sm-12" id="alert_result">

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-inline">
                            <div class="form-group mx-sm-6 mb-2">
                                <label for="inputPassword2" class="sr-only">Cidade</label>
                                <input type="text" class="form-control" id="inputCidade" placeholder="Digite aqui o nome da sua cidade">
                            </div>
                            <button type="button" onclick="buscar_cidade()" class="btn btn-primary mb-2" id="btn_enviar">Enviar</button>
                        </form>
                    </div>
                </div>
                <div class="row" id="div_resultado">

                </div>
            </div>
        </header>
        <!-- Footer-->
        <footer class="footer text-center" id="about">
            <div class="container">
                <div class="row">
                    <!-- Footer Social Icons-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="text-uppercase mb-4">Rede Sociais</h4>
                        <a class="btn btn-outline-light btn-social mx-1" href="https://www.linkedin.com/in/lucas-magalhaes-311649160"><i class="fab fa-fw fa-linkedin-in"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="https://github.com/magalhaes404"><i class="fab fa-fw fa-github"></i></a>
                    </div>
                    <!-- Footer About Text-->
                    <div class="col-lg-4">
                        <p class="lead mb-0">
                            Desenvolvido por Lucas Magalhães
                        </p>
                    </div>
                    <div class="col-lg-4">
                        <img style="width: 150px;height: 150px;" src="assets/img/avatar.png" alt="" />
                    </div>
                </div>
            </div>
        </footer>

        <script>
            function buscar_cidade()
            {
                var in_alert = '#alert_result';
                var nome_cidade = $('#inputCidade').val();
                if (nome_cidade.length > 6)
                {
                    $.ajax({
                        method: "POST",
                        url: "api/Buscar_Cidade",
                        data: {Cidade: nome_cidade},
                        type: 'text',
                        beforeSend: function (xhr) {
                            $('#btn_enviar').html(
                                    '<div class="spinner-border text-white" role="status">' +
                                    '<span class="visually-hidden"></span>' +
                                    '</div>');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $(alert).html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                                    + 'Erro ao processar'
                                    + '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                                    + '<span aria-hidden="true">&times;</span>'
                                    + '</button>'
                                    + '</div>');
                            $('#btn_enviar').html('Enviar');
                        },
                        success: function (data, textStatus, jqXHR) {
                            $('#btn_enviar').html('Enviar');
                            alert(data);
                            var objeto = JSON.parse(data);
                            if (objeto.Status == "ok")
                            {
                                resultado_ok(objeto.Lista);
                            }
                            else
                            {
                                resultado_falha();
                            }
                        }
                    });
                }
                else
                {
                    $(in_alert).html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            +'nome cidade curta'
                            + '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                            + '<span aria-hidden="true">&times;</span>'
                            + '</button>'
                            + '</div>');
                }
            }

            function resultado_falha()
            {
                $('#div_resultado').html(
                        '<div class="col-sm-12">' +
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
                        '<h2>Cidade não encontrada</h2>'+
                        '</div>' +
                        '</div>');
            }

            function resultado_ok(lista)
            {
                for (var i = 0; i < lista.length; i++)
                {
                    if (lista[i].Imagem.Caminho.length > 0)
                    {
                        var imagem = lista[i].Imagem.Caminho;
                    }
                    else
                    {
                        var imagem = "/assets/avatar.png";
                    }
                    $('#div_resultado').append(
                            '<div class="col-auto mb-3">' +
                            '<div class="card" style="width: 18rem;" >' +
                            '<img  src="' + imagem + '" class="card-img-top">' +
                            '<div class="card-body">' +
                            '<h5 class="card-title">' + lista[i].Nome + '</h5>' +
                            '<p class="card-subtitle mb-2 text-muted">' + lista[i].Genero.toString() + '</p>' +
                            '<a href="' + lista[i].Url_Musica + '" class="btn btn-primary">Ver Musica</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>');
                }
            }

        </script>
        <!-- Copyright Section-->
        <div class="copyright py-4 text-center text-white">
            <div class="container"><small>Copyright © Your Website 2021</small></div>
        </div>
        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
        <div class="scroll-to-top d-lg-none position-fixed">
            <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php /**PATH C:\wamp64\www\teste_temperatura\resources\views/pagina_principal.blade.php ENDPATH**/ ?>
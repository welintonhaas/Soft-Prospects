<?php

require_once('../../models/Usuario.php');
require_once('../../controllers/Prospect/ControllerProspect.php');
use models\Usuario;
use controller\ControllerProspect;

$cod_prospect = null;
session_start(); 

if (isset($_GET['cod_prospect'])){
    $cod_prospect=$_GET['cod_prospect'];
    $prospects = new ControllerProspect;
    $umProspect = $prospects->econtrarUmProspect($cod_prospect);
} 

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bem Vindo ao Sistema</title>
        <link rel="stylesheet" type="text/css" href="../libs/bootstrap/css/bootstrap.css">
        <meta charset="UTF-8">
    </head>
    <body>
        <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse" id="textoNavbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="../main.php">Home <span class="sr-only">(Página atual)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Prospects</a>
                    </li>
                </ul>
                <span class="navbar-text">
                        Bem vindo: 
                        <?php 
                            $usuario = unserialize($_SESSION['usuario']);
                            echo $usuario->nome; 
                        ?>
                </span>
            </div>
        </nav>
        </header>
        <div class="container">
            <?php if ($umProspect){ ?>
                <form class="form-signin" action="../../controllers/prospect/c_alterar_prospect.php" method="POST">
                    <div>
                        <h5 class="form-signin-heading">Cadastro de Usuários:</h5>
                    </div class="">
                    <div class="form-group">
                        <input name="cod_prospect"  type="hidden" value="<?=$umProspect['cod_prospect'] ?>" required/>
                        <label for="nome">Nome:</label>
                        <input name="nome" id="nome" type="text" placeholder="Digite seu nome" class="form-control" value="<?=$umProspect['nome'] ?>" required/>
                        <label for="email">E-mail:</label>
                        <input name="email" id="email" placeholder="Digite seu E-mail" class="form-control" value="<?=$umProspect['email'] ?>" required autofocus autocomplete="off"/>
                        <label for="celular">Celular:</label>
                        <input name="celular" id="celular" type="text" placeholder="Digite seu celular" value="<?=$umProspect['celular'] ?>" class="form-control" required/>
                        <label for="whatsapp">Whatsapp:</label>
                        <input name="whatsapp" id="whatsapp" type="text" placeholder="Digite seu whatsapp" value="<?=$umProspect['whatsapp'] ?>" class="form-control" required/>
                        <label for="facebook">Facebook:</label>
                        <input name="facebook" id="facebook" type="text" placeholder="Digite sua facebook" value="<?=$umProspect['facebook'] ?>" class="form-control" required/>
                    </div>
                    <button type="submit" class="btn btn-success">Alterar</button>
                    <a href="v_listar_prospect.php" class="btn btn-danger">Cancelar</a>
                </form>
            <?php }else{ ?>
                <h2>Prospect não encontrado!</h2>
            <?php } ?>
        </div>
    </body>
</html>

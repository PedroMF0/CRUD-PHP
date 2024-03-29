<?php
    session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Keyboard 
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20120915

-->
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="Templates/modelo.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Aula013 Cadastro, Busca, Excluir e Alterar</title>
<link href='http://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
<link href="../estilos/style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
	<div id="header-wrapper">
		<div id="header" class="container">
			<div id="logo">
				<h1><a href="#">Cadastro </a></h1>
			</div>
			<div id="menu">
				<ul>
				<li class="current_page_item"><a href="../index.php">Homepage</a></li>
					<li><a href="guicadusuario.php">cadastro</a></li>
					
				</ul>
			</div>
		</div>
		<div id="banner">
			<div class="content"><img src="../imagens/img02.jpg" width="1000" height="300" alt="" /></div>
		</div>
	</div>
	<!-- end #header -->
	
	<div id="page">
		<div id="content">
        
		  <div class="post">
				<!-- InstanceBeginEditable name="conteúdo" -->

				<h2 class="title">Consulta</h2>
<p>
    <?php
    if (isset($_SESSION['usuario'])) {
        // Instantiate an object $usu as a Usuario
        include_once '../modelo/usuario.class.php';
        $usu = array();
        $usu = unserialize($_SESSION['usuario']);
        ?>
        <table summary="Tabela de usuários" border="5">
            <caption>Usuários</caption>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Login</th>
                    <th>Senha</th>
                    <th>Tipo</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Código</th>
                    <th>Login</th>
                    <th>Senha</th>
                    <th>Tipo</th>
                </tr>
            </tfoot>

            <tbody>
                <?php
                foreach ($usu as $u) {
                    echo '<tr>';

                    echo "<td>
                    <a href='../controle/usuariocontrole.php?op=deletar&idUsuario'> $u->idUsuario </a> </td>";

                    echo '<td>' . $u->login . '</td>';
                    echo '<td>***********</td>'; // You may want to display password securely
                    echo '<td>' . $u->tipo . '</td>';

                    echo '</tr>';
                } // closes the foreach
                ?>
            </tbody>
        </table>
        <?php
    } else {
        echo 'Variavel usuarios não existe!';
    }
    ?>
</p>


				<!-- InstanceEndEditable -->

			</div>
		</div>
		<!-- end #content -->
		<div id="sidebar">
		<?php
				if(!isset($_SESSION['privateUser'])){
			?>
			<form name="login" id="login" method="post" action="../controle/usuariocontrole.php?op=logar">
					<input type="text" name="txtlogin" id="txtlogin" placeholder="login"><br>
					<input type="password" name="txtsenha" id="txtsenha" placeholder="senha"><br>

					<input type="submit" name="btnlogar" id="btnlogar" value="Logar">
			</form>
			<?php
				}else{
			?>
						<ul>
							<li>
								<h2>Links Privados</h2>
								<ul>
									<li><a href="../controle/usuariocontrole.php?op=consultar">Consultar</a></li>
									<li><a href="guidelusuario.php">Excluir</a></li>
									<li><a href="guibuscausuario.php">Busca Avançada</a></li>
									<li><a href="../controle/usuariocontrole.php?op=deslogar">Deslogar</a></li>
									<li><a href="guialterar.php">Alterar</a></li>
								</ul>
							</li>
						</ul>
					<?php
				}

				    ?>
		</div>
		<!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end #page --> 
</div>
<div id="footer">
	<p>Copyright (c) 2012 Sitename.com. All rights reserved. Design by <a href="http://www.freecsstemplates.org">FCT</a>. Photos by <a href="http://fotogrph.com/">Fotogrph</a>.</p>
</div>
<!-- end #footer -->
</body>
<!-- InstanceEnd --></html>

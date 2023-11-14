<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../estilos/menunav.css">
    <link rel="stylesheet" type="text/css" href="../estilos/index.css">
    <title>Barbearia - Adicionar Agendamento</title>
</head>
<header>
    <nav id="navMenu">
        <ul>
            <li><a href="../index.php">Página Inicial</a></li>
            <li><a href="guiagendamento.php">Marque seu Horário</a></li>
            <li><a href="guicadfuncionario.php">Funcionário</a></li>
        </ul>
    </nav>
</header>
<body>
    <h1>Adicionar Funcionário</h1>
    
    <form action="../controle/agendacontrole.php?op=cadastrar" method="post">
            <label for="nome">Nome:</label>
            <input type="text" name="txtlogin" id="txtlogin" required>
            
            <label for="senha">Senha:</label>
            <input type="text" name="txtsenha" id="txtsenha" required>

            <button type="submit">Cadastro</button>
            <button type="reset">Limpar</button>
    </form>

    <div id="sidebar">
		<?php
				if(!isset($_SESSION['privateUser']) ){
			?>
				<form name="login" id="login" method="post" action="../controle/agendacontrole.php?op=logar">
						<input type="text" name="txtlogin" id="txtlogin" placeholder="login">
						<br>
						<input type="password" name="txtsenha" id="txtsenha" placeholder="senha">
						<br>

						<input type="submit" name="btnlogar" id="btnlogar" value="Logar">
				</form>
			<?php
				}else{
			?>
						<ul>
							<li>
								<h2>Links Privado</h2>
								<ul>
									<li><a href="../controle/agendacontrole.php?op=consultarcliente">Consultar</a></li>
									<li><a href="../controle/agendacontrole.php?op=deletar">Excluir</a></li>
									<li><a href="guibuscliente.php">Busca Avançada</a></li>
									<li><a href="../controle/agendacontrole.php?op=deslogar">Deslogar</a></li>
									<li><a href="guialterarcliente.php">Alterar</a></li>
								</ul>
							</li>
						</ul>
			<?php
				}//fim do else
			?>
		</div>
     <footer>
        <p>&copy; Barbearia 2023 by Pedro Morales</p>
    </footer>
</body>
</html>
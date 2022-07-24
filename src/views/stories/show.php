
<?php

    #Importações

    use Capangas\Touchfic\models\Storie;
    use Capangas\Touchfic\models\User;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/3629/3629072.png">
    <script src="https://kit.fontawesome.com/f17bb9c677.js" crossorigin="anonymous"></script>
    <style><?php include __DIR__ . '../../css/style.css'; ?></style>
    <title>
        Todas as histórias
    </title>
</head>
<body>
<header>
    <div>
        <a href="/dashboard" class="logo"><img src="https://cdn-icons-png.flaticon.com/512/3629/3629072.png" alt="Touchfic">Touchfic</a>
    </div>
        <nav>
            <ul>
                <li><a href="/dashboard" class="nav-link">Página Inicial</a></li>
                <li><a href="/storie/mystories" class="nav-link">Minhas histórias</a></li>
                <li><a href="/storie/create" class="nav-link">Criar</a></li>
            </ul>
        </nav>
    </header>

    <h1 class="title">
        Lista de histórias
    </h1>

    <div class="container-stories">
        <div class="div-stories">
    <?php

        #Pega todas as histórias

        $storieQuery = Storie::getConnection()->prepare('SELECT * FROM tb_stories');
        $storieResult = $storieQuery->execute();

        #Exibe as histórias

        while ($stories = $storieResult->fetchArray()) {

            #Informações básicas

            echo '<h3>' . $stories['sto_title'] . '</h3>';
            echo '<p>' . $stories['sto_description'] . '</p>';
            echo '<br><strong>' . $stories['sto_agegroup'] . '</strong>';
            echo ' | Quantidade de palavras: ' . $stories['sto_numberofwords'] . '<br><br>';

            #Visualiza história

            echo '<form action="/storie/profile" method="get">';
            echo '<input type="hidden" name="title" value="' . $stories['sto_title'] . '">';
            echo '<input type="hidden" name="description" value="' . $stories['sto_description'] . '">';
            echo '<input type="hidden" name="agegroup" value="' . $stories['sto_agegroup'] . '">';
            echo '<input type="hidden" name="number_of_words" value="' . $stories['sto_numberofwords'] . '">';
            echo '<input type="hidden" name="storie_id" value="' . $stories['sto_id'] . '">';
            echo '<button style="background-color: #9c3587; color: white; font-size: 12pt; font-family: Franklin Gothic Medium; border-radius: 7px; border: none; padding: 5px; font-weight: bold; margin-bottom: 1%">Visualizar</button>';
            echo '</form>';
            
        } 
    ?>
    <form action="/storie/create" method="get">
        <button class="create-button">
            <i class="fa-solid fa-circle-plus"></i> Crie uma história
        </button>
    </form>

    </div>
    </div>

    <footer>
        <div>
        <p>Touchfic: crie e leia histórias com um só toque</p>
        <ul>
            <li><a href="/"><i class="fa-brands fa-instagram"></i></a></li>
            <li><a href="/"><i class="fa-brands fa-twitter"></i></a></li>
            <li><a href="/"><i class="fa-brands fa-facebook"></i></a></li>
            <li><a href="/"><i class="fa-brands fa-tiktok"></i></a></li>
            <li><a href="/"><i class="fa-brands fa-pinterest"></i></a></li>
        </ul>
        </div>

        <div>
            <ul>
                <li><a href="">Termos de Uso</a></li>
                <li><a href="">Política de Privacidade</a></li>
            </ul>
        </div>

        <div class="div-credits">
        <a href="https://www.flaticon.com/br/icones-gratis/tocha" title="tocha ícones">Tocha ícones criados por Freepik - Flaticon</a>
        </div>
    </footer>
    
</body>
</html>
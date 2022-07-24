
<!-- Importações e Verificação do formulário -->

<?php
    use Capangas\Touchfic\models\Gender;
    use Capangas\Touchfic\models\Storie;
    use Capangas\Touchfic\models\StorieOfUser;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['title'], $_POST['description'], $_POST['age_group'], $_POST['gender'], $_POST['number_of_words'])) { 

            # Salva a História
            $storie = new Storie($_POST['title'], $_POST['description'], $_POST['age_group'], $_POST['gender'], $_POST['number_of_words']);
            $storie->save();

            #Pega o último id da história
            $storieIdQuery = Storie::getConnection()->prepare('SELECT sto_id FROM tb_stories ORDER BY sto_id DESC;');
            $storieIdResult = $storieIdQuery->execute();
            $storieId = $storieIdResult->fetchArray();

            #Relaciona a história e o usuário salvando na tabela dessa combinação
            $storieOfUser = new StorieOfUser(
                $_SESSION['user_id'], $storieId['sto_id']
            );
            $storieOfUser->save();

            header('Location: /storie/show', 302);
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/3629/3629072.png">
    <script src="https://kit.fontawesome.com/f17bb9c677.js" crossorigin="anonymous"></script>
    <style>
    <?php include __DIR__ . '../../css/style.css'; ?>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@300&family=Poppins:ital,wght@0,300;0,400;1,300&display=swap');
    </style>
    <title>
        Criar uma história
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
        Criar uma história
    </h1>

    <div class="container-create">
    <div clas="div-create"> 
    <form action="/storie/create" method="post">
        <label for="title" class="label-tag">
            Título
        </label>
        <input type="text" name="title" class="input-title" placeholder="Título da história" autofocus>
        
        <label for="description" class="label-tag">Descrição</label>
        
        <textarea name="description" cols="90" rows="15" class="desc-textarea" placeholder="Escreva uma sinopse para sua história"></textarea>
        
        <label for="age_group" class="label-tag">Faixa etária</label>
        <select name="age_group">
            <option value="L">Livre</option>
            <option value="10">10</option>
            <option value="12">12</option>
            <option value="14">14</option>
            <option value="16">16</option>
            <option value="18">18</option>
        </select>
        <label for="gender" class="label-tag">Gênero</label>
        <select name="gender">
            <?php
                $genderQuery = Gender::getConnection()->prepare('SELECT * FROM tb_genders');
                $genderResult = $genderQuery->execute();
                while ($genders = $genderResult->fetchArray()) {
                    echo '<option value="' . $genders['gen_id'] . '">' . $genders['gen_gender'] . '</option>';
                }
            ?>
        </select>
        <input type="hidden" name="number_of_words" value="0">

        <div class="container-submit">
            <div class="submit-story-button">
                <button>
                    Enviar
                </button>
            </div>
        </div>

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
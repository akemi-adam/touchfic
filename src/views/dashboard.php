<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/3629/3629072.png">
    <script src="https://kit.fontawesome.com/f17bb9c677.js" crossorigin="anonymous"></script>
    <style>
    <?php include __DIR__ . '/css/style.css'; ?>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@300&family=Poppins:ital,wght@0,300;0,400;1,300&display=swap');
    </style>
    <title>
        Dashboard
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

    <div class="container-title">
        <h1 class="title">
            <mark>Olá, <?php echo $_SESSION['user'];?> </mark>
        </h1>
        <h2 class="subtitle">
            Boas-vindas! Selecione a opção de sua preferência
        </h2>
    </div>

    <div class="container-faq">
        <div class="div-faq">
            <p><i class="fa-solid fa-book"></i><strong> Não tem ideia do que ler? Consulte a lista das histórias mais recentes!</strong></p>
            <a href="/storie/show">Visualizar histórias <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="div-faq">
            <p><i class="fa-solid fa-circle-plus"></i><strong> Crie sua história e mostre sua criatividade ao mundo!</strong></p>
            <a href="/storie/create">Criar uma história <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="div-faq">
            <p><i class="fa-solid fa-book-open-reader"></i><strong> Vizualize e gerencie as histórias que você criou!</strong></p>
            <a href="/storie/mystories">Minhas histórias <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="div-faq">
            <p><i class="fa-solid fa-message"></i><strong> Fique por dentro das postagens mais recentes da plataforma!</strong></p>
            <a href="/posts/show">Ver todas as postagens <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="div-faq">
            <p><i class="fa-solid fa-share-from-square"></i><strong> Compartilhe uma postagem sobre você ou sobre uma história que te empolga!</strong></p>
            <a href="/posts/register">Publicar uma postagem <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="div-faq">
            <p><i class="fa-solid fa-gear"></i><strong> Opções de administrador (Restrito)</strong></p>
            <a href="/admin">Acesso do administrador <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        
    </div>

    <div class="container-logout">
        <form action="/logout" method="post">
            <button class="logout-button">
                <i class="fa-solid fa-right-from-bracket"></i> Sair
            </button>
        </form>
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
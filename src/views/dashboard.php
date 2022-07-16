<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Dashboard
    </title>
</head>
<body>
    <h1>
        Dashboard da aplicação
    </h1>
    <p>
        Olá, <?php echo $_SESSION['user'] . " | " . $_SESSION['user_id'];?>
    </p>
    <p>
        Links:
    </p>
    <ul>
        <li>
            <a href="/posts/register">Fazer uma postagem</a>
        </li>
        <li>
            <a href="/posts/show">Postagens</a>
        </li>
        <li>
            <a href="/storie/create">Criar uma história</a>
        </li>
        <li>
            <a href="/storie/show">Histórias</a>
        </li>
        <li>
            <a href="/admin">Opções de administrador</a>
        </li>
        <li>
            <a href="/storie/mystories">Minhas histórias</a>
        </li>
    </ul>
    <hr>
    <form action="/logout" method="post">
        <button>
            Sair
        </button>
    </form>
</body>
</html>
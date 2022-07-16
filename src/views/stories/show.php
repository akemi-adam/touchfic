
<?php

    #Importações

    use Capangas\Touchfic\models\Storie;
    use Capangas\Touchfic\models\User;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Histórias
    </title>
</head>
<body>
    <h1>
        Lista de histórias
    </h1>
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
            echo '<button>Visualizar</button>';
            echo '</form>';
            
        } 
    ?>
    <form action="/storie/create" method="get">
        <button>
            Crie uma história +
        </button>
    </form>
</body>
</html>
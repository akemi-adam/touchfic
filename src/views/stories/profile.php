<?php

    #Importações

    use Capangas\Touchfic\models\StorieOfUser;
    use Capangas\Touchfic\models\Chapter;
    use Capangas\Touchfic\models\Storie;
    use Capangas\Touchfic\models\User;

    #Deleta o capítulo

    $subtracted = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['deleted_chapter'])) {
            Storie::uptade('tb_stories', 'sto_numberofwords', $_POST['number_of_words'] - $_POST['chapterWords'], 'sto_id', $_POST['storie_id']);
            $subtracted = true;
            $newWordsNumber = $_POST['number_of_words'] - $_POST['chapterWords'];
            Chapter::delete("tb_chapters", "cha_id", $_POST['deleted_chapter']);
        }
    }

    $storieId = ($_SERVER['REQUEST_METHOD'] === 'GET') ? $_GET['storie_id'] : $_POST['storie_id'];

    $storieOfUserQuery = StorieOfUser::getConnection()->prepare('SELECT sus_use_id FROM tb_storiesofusers WHERE sus_sto_id = :storieId AND sus_use_id = :userId');
    $storieOfUserQuery->bindValue(
        ':storieId', $storieId, SQLITE3_INTEGER
    );
    $storieOfUserQuery->bindValue(
        ':userId', $_SESSION['user_id'], SQLITE3_INTEGER
    );
    $storieOfUserResult = $storieOfUserQuery->execute();
    $storieOfUser = $storieOfUserResult->fetchArray();

    $writer = false;

    if (isset($storieOfUser['sus_use_id'])) {
        $writer = true;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            echo '<title>' . $_GET['title'] . '</title>';
        }
        elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
            echo '<title>' . $_POST['title'] . '</title>';
        }
    ?>

    <!-- Função auxiliar para deletar um capítulo -->
    <script>
        var buttonsDelete = document.getElementsByClassName("input_delete");
        function remove(id) {
            for (let index = 0; index < buttonsDelete.length; index++) {
                if (buttonsDelete[index].value == id) {
                    buttonsDelete[index].setAttribute("name", "deleted_chapter")
                }
            }
        }
    </script>
</head>
<body>
    <?php

        #Informações sobre a história

        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            echo '<h1>' . $_GET['title'] . '</h1>';
            echo '<p>' . $_GET['description'] . '</p>';
            echo '<hr>';
            echo '<p>Classificação etária:' . $_GET['agegroup'] . '</p>';
            if (!$subtracted) {
                echo '<p>Número de palavras: ' . $_GET['number_of_words'] . '</p>';
            } else {
                echo '<p>Número de palavras: ' . $newWordsNumber . '</p>';
            }
            
        }
        elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
            echo '<h1>' . $_POST['title'] . '</h1>';
            echo '<p>' . $_POST['description'] . '</p>';
            echo '<hr>';
            echo '<p>Classificação etária:' . $_POST['agegroup'] . '</p>';
            if (!$subtracted) {
                echo '<p>Número de palavras: ' . $_POST['number_of_words'] . '</p>';
            } else {
                echo '<p>Número de palavras: ' . $newWordsNumber . '</p>';
            }
            
        }
        if ($writer) {
            echo '<form action="/storie/chapter/create" method="get">';
            echo '<input type="hidden" name="id" value="' . $storieId . '">';
            echo '<button>Criar capítulo</button>';
            echo '</form>';
        }
    ?>
    <h3>
        Capítulos:
    </h3>
    <ul>
        <?php

            #Recupera os capítulos da história no banco

            $chapterQuery = Chapter::getConnection()->prepare('SELECT cha_title, cha_publicationdate, cha_numberofwords, cha_id FROM tb_chapters WHERE cha_sto_id = :sto_id');
            if ($_SERVER['REQUEST_METHOD'] === "GET") {
                $chapterQuery->bindValue(
                    ':sto_id', $_GET['storie_id'], SQLITE3_INTEGER
                );
            }
            elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
                $chapterQuery->bindValue(
                    ':sto_id', $_POST['storie_id'], SQLITE3_INTEGER
                );
            }
            $chapterResult = $chapterQuery->execute();

            while ($chapters = $chapterResult->fetchArray()) {

                #Listagem de informações sobre o capítulo

                echo '<li><strong>' . $chapters['cha_title'] . '</strong><span> | Número de palavras: ' . $chapters['cha_numberofwords'] . ' | Data: ' . $chapters['cha_publicationdate'] . '</span></li>';

                #Visualiza o capítulo

                echo '<form action="/storie/chapter/show-aux" method="post">';
                echo '<input type="hidden" name="chapterId" value="' . $chapters['cha_id'] . '"><input type="hidden" name="storieId" value="' . $storieId . '">';
                echo '<button>Visualizar</button>';
                echo'</form>';

                if ($writer) {

                    #Reenviar as informações da página caso delete algum capítulo

                    echo '<form action="/storie/profile" method="post">';

                    if ($_SERVER['REQUEST_METHOD'] === "GET") {
                        echo '<input type="hidden" name="title" value="' . $_GET['title'] . '">';
                        echo '<input type="hidden" name="description" value="' . $_GET['description'] . '">';
                        echo '<input type="hidden" name="agegroup" value="' . $_GET['agegroup'] . '">';
                        echo '<input type="hidden" name="number_of_words" value="' . $_GET['number_of_words'] . '">';
                        echo '<input type="hidden" name="storie_id" value="' . $_GET['storie_id'] . '">';
                        echo '<input type="hidden" name="chapterWords" value="' . $chapters['cha_numberofwords'] . '">';
                    }
                    elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
                        echo '<input type="hidden" name="title" value="' . $_POST['title'] . '">';
                        echo '<input type="hidden" name="description" value="' . $_POST['description'] . '">';
                        echo '<input type="hidden" name="agegroup" value="' . $_POST['agegroup'] . '">';
                        echo '<input type="hidden" name="number_of_words" value="' . $_POST['number_of_words'] . '">';
                        echo '<input type="hidden" name="storie_id" value="' . $_POST['storie_id'] . '">';
                        echo '<input type="hidden" name="chapterWords" value="' . $chapters['cha_numberofwords'] . '">';
                    }

                    #Deleta o capítulo respectivo
                
                    echo '<input class="input_delete" type="hidden" value="' . $chapters['cha_id'] . '">';
                    echo '<button style="background-color: red;" onclick="remove(' . $chapters['cha_id'] . ')">Excluir</button>';

                    echo '</form>';
                }

            }

        ?>
    </ul>
    
</body>
</html>
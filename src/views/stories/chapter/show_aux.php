<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Location: /dashboard', 302);
    exit;
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['chapter_id'] = $_POST['chapterId'];
    $_SESSION['storie_id'] = $_POST['storieId'];
    header('Location: /storie/chapter/show', 302);
}
<?php

use Capangas\Touchfic\models\Model;

Model::createConnection(
    new SQLITE3(__DIR__ . '/database/db_touchfic.db')
);

/**
 * Criação das tabelas do banco; respectivamente:
 * 
 *  - tb_users
 *  - tb_posts
 *  - tb_chapters
 *  - tb_stories
 *  - tb_tags
 *  - tb_genders
 *  - tb_storiesofusers
 * 
 **/

Model::createModel(
    'CREATE TABLE IF NOT EXISTS tb_users (use_id INTEGER PRIMARY KEY AUTOINCREMENT, use_username TEXT, use_email TEXT, use_password TEXT);'
);
Model::createModel(
    'CREATE TABLE IF NOT EXISTS tb_posts (pos_id INTEGER PRIMARY KEY AUTOINCREMENT, pos_content VARCHAR(45) NOT NULL, pos_publicationdate TEXT NOT NULL, pos_use_id INTEGER, FOREIGN KEY (pos_use_id) REFERENCES tb_users (use_id));'
);
Model::createModel(
    'CREATE TABLE IF NOT EXISTS tb_chapters (cha_id INTEGER PRIMARY KEY AUTOINCREMENT, cha_title VARCHAR(50) NOT NULL, cha_authornotes VARCHAR(45), cha_content VARCHAR(45) NOT NULL, cha_numberofwords VARCHAR(45) NOT NULL, cha_publicationdate TEXT NOT NULL, cha_sto_id INTEGER, FOREIGN KEY (cha_sto_id) REFERENCES tb_stories (sto_id));'
);
Model::createModel(
    'CREATE TABLE IF NOT EXISTS tb_stories (sto_id INTEGER PRIMARY KEY AUTOINCREMENT, sto_title VARCHAR(50) NOT NULL, sto_description VARCHAR(100) NOT NULL, sto_agegroup VARCHAR(3) NOT NULL, sto_numberofwords VARCHAR(45), sto_gen_id INTEGER, FOREIGN KEY (sto_gen_id) REFERENCES tb_genders (gen_id));'
);
Model::createModel(
    'CREATE TABLE IF NOT EXISTS tb_genders (gen_id INTEGER PRIMARY KEY AUTOINCREMENT, gen_gender VARCHAR(45) NOT NULL);'
);
Model::createModel(
    'CREATE TABLE IF NOT EXISTS tb_storiesofusers(sus_use_id INTEGER, sus_sto_id INTEGER, FOREIGN KEY (sus_use_id) REFERENCES tb_users (use_id), FOREIGN KEY (sus_sto_id) REFERENCES tb_stories (sto_id), PRIMARY KEY (sus_use_id, sus_sto_id));'
);
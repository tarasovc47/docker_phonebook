<?php

use system\core\Db;

class SiteController
{
    public function actionIndex()
    {
        echo 'Вызван SiteController и actionIndex';
        $db1 = Db::getConnection();
        $query = $db1->query('SELECT * FROM test');
        while ($row = $query->fetch())
        {
            echo $row['name'] . "\n";
        }
        return true;
    }
    public function actionNews()
    {
        echo 'Вызван SiteController и actionNews';
        return true;
    }
}
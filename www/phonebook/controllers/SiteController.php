<?php

class SiteController
{
    public function actionIndex()
    {
        echo 'Вызван SiteController и actionIndex';
        return true;
    }
    public function actionNews()
    {
        echo 'Вызван SiteController и actionNews';
        return true;
    }
}
<?php

use system\core\Controller;

class PhonebookController extends Controller
{
    public function actionIndex()
    {
        return $this->render("phonebook/index");
    }
    public function actionView($data)
    {
        return $this->render('phonebook/view', [
            'data' => $data,
        ]);
    }
}
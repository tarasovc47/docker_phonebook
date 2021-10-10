<?php

use system\core\Controller;
use models\Phonebook;

class PhonebookController extends Controller
{
    public function actionIndex()
    {
        $contact = new Phonebook();
        return $this->render('phonebook/index', $contact->getContact());
    }

    public function actionView($data)
    {
        $contact = new Phonebook();
        return $this->render('phonebook/view', $contact->getContactById($data));
    }
}
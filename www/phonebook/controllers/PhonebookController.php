<?php

use system\core\Controller;
use system\core\Db;

class PhonebookController extends Controller
{
    public function actionIndex()
    {
        $contact = array();
        $contact = PhonebookController::getContact();
        echo '<pre>';
        var_dump($contact);
        #return $this->render("phonebook/index");
        return true;
    }

    public function actionView($data)
    {
        $contact = array();
        $contact = PhonebookController::getContactById($data);
        /*return $this->render('phonebook/view', [
            'data' => $data,
        ]);*/
        var_dump($contact);
        return true;
    }

    public static function getContact()
    {
        $connect = Db::getConnection();
        $result = $connect->query('SELECT * FROM users');
        $i=0;
        while ($row = $result->fetch())
        {
            $contact[$i]['id'] = $row['id'];
            $contact[$i]['name'] = $row['name'];
            $contact[$i]['surname'] = $row['surname'];
            $contact[$i]['phone'] = $row['phone'];
            $contact[$i]['email'] = $row['email'];
            $contact[$i]['photo'] = $row['photo'];
            $i++;
        }
        return $contact;
    }
    public static function getContactById($id)
    {
        if ($id)
        {
            $connect = Db::getConnection();
            $result = $connect->query('SELECT * FROM users WHERE id = ' . $id);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            if ($result != null)
            {
                return $result->fetch();
            }
            else
            {
                return "ID не найден";
            }
        }
    }
}
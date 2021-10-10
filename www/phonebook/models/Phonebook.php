<?php

namespace models;

use PDO;
use system\core\Db;

class Phonebook
{
    public function getContact()
    {
        $connect = Db::getConnection();
        $query = $connect->query('SELECT * FROM users');
        $i=0;
        while ($row = $query->fetch())
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
    public function getContactById($id)
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
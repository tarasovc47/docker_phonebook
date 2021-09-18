<?php

namespace models;

class User
{
    public function getTable()
    {
        return 'users';
    }
    function primaryKey()
    {
        return 'ID';
    }
    public function fields()
    {
        return [
            'ID',
            'NAME',
            'LOGIN',
            'PASSWORD'
        ];
    }
}
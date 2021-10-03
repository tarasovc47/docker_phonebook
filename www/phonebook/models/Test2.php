<?php

namespace models;

class Test2
{
    public function getTable()
    {
        return 'test2';
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
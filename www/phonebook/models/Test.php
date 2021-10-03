<?php

namespace models;

class Test
{
    public function getTable()
    {
        return 'test';
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
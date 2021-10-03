<?php

class AuthController extends \system\core\Controller
{
    public function actionSignin()
    {
        $this->render('auth/signin');
        return true;
    }
    public function actionSignup()
    {
        $this->render('auth/signup');
        return true;
    }
}
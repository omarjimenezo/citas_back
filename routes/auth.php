<?php
$router->post('academia/RecoverPassword','Auth\RecoverPassController@ValidateData');
$router->put('academia/UpdateUserPassword','Auth\RecoverPassController@UpdateUserPassword');
$router->post('autenticar','Auth\AuthController@fnAuthenticate');

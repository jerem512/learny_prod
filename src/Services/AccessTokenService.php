<?php

namespace App\Services;

class AccessTokenService
{

    public function accessToken($user){

        $postData = [
            'client_secret'=> $user->getClientSecretGoogle(),
            'grant_type'=>'refresh_token',
            'refresh_token'=> $user->getRefreshTokenGoogle(),
            'client_id'=> $user->getClientIdGoogle()
        ];
    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//need this otherwise you get an ssl error
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tokenReturn = curl_exec($ch);
        $token = json_decode($tokenReturn);

        $accessToken = $token->access_token;

        return $accessToken;
    }
}
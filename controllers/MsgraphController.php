<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use yii\web\HeaderCollection;

header('Access-Control-Allow-Origin: http://localhost/');
header('Origin: http://localhost/');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: X-Requested-With');

class MsgraphController extends Controller {

    public $accessToken;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

//    public function actionIndex() {

//        return $this->render('/msgraph/index');
//    }

    public function actionLogin() {
        $tenantId = 'eb901229-08a7-476f-9c32-8733aea1cc35';
        $clientId = 'd7fb1bf7-5967-44db-9a78-e59a50f7eaf2';
        $clientId2 = 'c89d429a-f009-4fd7-bf29-fb8773c53b57';
        $clientSecret = 'bk18Q~Nyf3wDUS~UhoGXtLxGiPa1lng73-jNlaTe';
        $clientSecret2 = 'zjG8Q~3wBcf27G5gBzY7oIPMpj4LUbCTbvAv.dsn';

       $guzzle = new \GuzzleHttp\Client();
       $url = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/v2.0/token';
       $token = json_decode($guzzle->post($url, [
                   'form_params' => [
                       'client_id' => $clientId,
                       'client_secret' => $clientSecret,
                       'scope' => 'https://graph.microsoft.com/.default',
                       'grant_type' => 'client_credentials',
                   ],
               ])->getBody()->getContents());
       //print_r($token);die;
       $graph = new Graph();
       $graph->setAccessToken($token->access_token);
       
       $user = $graph->createRequest("GET", "/users")
                     //->setReturnType(Model\User::class)
                     ->execute();
       print_r($user);die;
       
}
}
<?php

namespace App\Http\Controllers;

use App\authenticationCode;
use App\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class getAuthenticationController extends Controller
{
    public function index()
    {
        $user = User::orderby('id','DESC')->get();
        return view('welcome')->with('user',$user);
    }
    public function getAuthentication(Request $request)
    {
        $client = new Client();
        $res = $client->request('POST', 'https://accounts.google.com/o/oauth2/auth', [
            'form_params' => [
                'client_id' =>'124712444776-6fqv88m54sdmed5v8s1d274kedj2ppt6.apps.googleusercontent.com' ,
                'response_type' => 'code',
                'scope'=>'https://www.googleapis.com/auth/adwords',
                'redirect_uri'=>'http://localhost/oauth2callback'
            ]
        ]);
        echo $res->getStatusCode();
        echo $res->getBody();
    }
    public function Auth_save(Request $request)
    {
        $authCode = new authenticationCode();
        $authCode->Code = $_GET['code'];
        $authCode->user_id = Session::get('id');

        $client = new Client();
        $res1 = $client->request('POST','https://accounts.google.com/o/oauth2/token',[
            'form_params' => [
                'code'=> $authCode->Code = $_GET['code'],
                'client_id'=>'124712444776-6fqv88m54sdmed5v8s1d274kedj2ppt6.apps.googleusercontent.com',
                'client_secret'=>'kL8gH8RttNg6ojcG9qGEXPsj',
                'redirect_uri'=>'http://localhost/oauth2callback',
                'grant_type'=>'authorization_code'
            ]
        ]);
        $res1->getStatusCode();
        $json = $res1->getBody();

        $obj = json_decode($json);
        $accessToken = $obj->{'access_token'};
//        $res = $client->request('GET','https://googleads.googleapis.com/v5/customers/5542577145/campaigns/11141359121',[
//            'headers' => [
//                'Content-Type'=>'application/json',
//                'Authorization' =>'Bearer '.$accessToken,
//                'developer-token'=>'BrtDh-R9uWJUYzJx1d_EoA'
//            ]
        $res = $client->request('POST','https://googleads.googleapis.com/v5/customers/5542577145/googleAds:searchStream',[
            'headers' => [
                'User-Agent'=>'curl  HTTP/1.1',
                'Content-Type'=>'application/json',
                'Accept'=> 'application/json',
                'Authorization' =>'Bearer '.$accessToken,
                'developer-token'=>'BrtDh-R9uWJUYzJx1d_EoA'
            ],
             'form_params'=>[
                 "query" => "SELECT campaign.name, campaign.status, segments.device,
                    metrics.impressions, metrics.clicks, metrics.ctr,
                    metrics.average_cpc, metrics.cost_micros
            FROM campaign
            WHERE segments.date DURING LAST_30_DAYS"
             ]
        ]);
        echo $res->getStatusCode();
        echo $res->getBody();
    }
}

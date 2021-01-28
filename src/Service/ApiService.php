<?php


namespace App\Service;

use App\Entity\Blog;
use App\Entity\Project;
use App\Entity\Skill;
use App\Generic\Constants;
use App\Entity\User;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiService{

    private $client;
    private $endpoint;
    private $serializer;


    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->endpoint = getenv(Constants::APIENDPOINT);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer =  new Serializer($normalizers, $encoders);
    }

    public function get($entity, $id){
        try {
            $response = $this->client->request(
                'GET',
                Constants::APIENDPOINT.$entity."/".$id
            );

            $statusCode = $response->getStatusCode();
            // $statusCode = 200
            $contentType = $response->getHeaders()['content-type'][0];
            // $contentType = 'application/json'
            $content = $response->getContent();
            // $content = '{"id":521583, "name":"symfony-docs", ...}'
            $content = $response->toArray();
            // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        } catch (\Throwable $th) {
            throw $th;
        }
        return $content;
    }
    public function post($entity, $obj){

        try {
            $response = $this->client->request(
                'POST',
                Constants::APIENDPOINT.$entity,[
                    'json' => $obj->toJson(),]
            );

            $statusCode = $response->getStatusCode();
            // $statusCode = 200
            $contentType = $response->getHeaders()['content-type'][0];
            // $contentType = 'application/json'
            $content = $response->getContent();
            // $content = '{"id":521583, "name":"symfony-docs", ...}'

            $array = $response->toArray();
        } catch (\Throwable $th) {
            echo $th;
        }

    }
    public function delete($entity, $id){
        try {
            $response = $this->client->request(
                'DELETE',
                Constants::APIENDPOINT.$entity."/". $id
            );

            $statusCode = $response->getStatusCode();
            // $statusCode = 200
            $contentType = $response->getHeaders()['content-type'][0];
            // $contentType = 'application/json'
            $content = $response->getContent();
            // $content = '{"id":521583, "name":"symfony-docs", ...}'

            $array = $response->toArray();
        } catch (\Throwable $th) {
            return false;
        }
        return true;

    }
    public function getAll($entity){
        $content = [];
        try {
            $response = $this->client->request(
                'GET',
                Constants::APIENDPOINT. $entity
            );

            $statusCode = $response->getStatusCode();
            // $statusCode = 200
            $contentType = $response->getHeaders()['content-type'][0];
            // $contentType = 'application/json'
            $content = $response->getContent();
            // $content = '{"id":521583, "name":"symfony-docs", ...}'
            $content = $response->toArray();
            // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        } catch (\Throwable $th) {
            throw $th;
        }
        return $content;
    }
    public function patch($entity, $obj){
        try {
            $response = $this->client->request(
                'PATCH',
                Constants::APIENDPOINT.$entity,[
                    'json' => $obj->toJsonId(),]
            );

            $statusCode = $response->getStatusCode();
            // $statusCode = 200
            $contentType = $response->getHeaders()['content-type'][0];
            // $contentType = 'application/json'
            $content = $response->getContent();
            // $content = '{"id":521583, "name":"symfony-docs", ...}'

            $array = $response->toArray();
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }


    public function getUserByUsername($user)
    {
        try {
            $response = $this->client->request(
                'POST',
                "http://127.0.0.1:5000/getuser",[
                'json' => ['username' => $user->getLogin(), 'password' => $user->getPassword() ]]
            );

            $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
       
        $array = $response->toArray();


        } catch (\Throwable $th) {
           $res =  "Could not connect to the server";
           return $res;
        }


        if(empty($array)){
            $res = false;
        }
        else{
            $res = true;
        }
        return $res;
    }




    
}
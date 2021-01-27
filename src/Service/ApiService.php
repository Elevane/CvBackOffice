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


    public function getProject(int $id){
        $content = [];
        try {
            $response = $this->client->request(
                'GET',
                "http://127.0.0.1:5000/project/" . $id
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

        }
        return $content;
    }
    public function getSkill(int $id){
        $content = [];
        try {
            $response = $this->client->request(
                'GET',
                "http://127.0.0.1:5000/skill/" . $id
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

        }
        return $content;
    }
    public function getSkills():array
    {
       
        $content = [];
        try {
            $response = $this->client->request(
                'GET',
                "http://127.0.0.1:5000/skill"
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
          
        }
        

        

        return $content;
    }
    public function getProjects():array
    {
       
        $content = [];
        try {
            $response = $this->client->request(
                'GET',
                "http://127.0.0.1:5000/project"
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
           
        }
        

        

        return $content;
    }
    public function getBlogs():array
    {
       
        $content = [];
        try {
            $response = $this->client->request(
                'GET',
                "http://127.0.0.1:5000/blog"
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
           
        }
        

        

        return $content;
    }
    public function getUserByUsername($username, $password)
    {
       

        try {
            $response = $this->client->request(
                'POST',
                "http://127.0.0.1:5000/getuser",[
                'json' => ['username' => $username, 'password' => $password ]]
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
    public function newSkill(Skill $skill){
        try {
            $response = $this->client->request(
                'POST',
                "http://127.0.0.1:5000/skill",[
                    'json' => $skill->toJson(),]
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
    public function editSkill(Skill $skill){
        try {
            $response = $this->client->request(
                'PATCH',
                "http://127.0.0.1:5000/skill",[
                    'json' => $skill->toJsonId(),]
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
    public function deleteSkill(int $id){
        try {
            $response = $this->client->request(
                'DELETE',
                "http://127.0.0.1:5000/skill/". $id
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

    public function editBlog(Blog $blog){
        try {
            $response = $this->client->request(
                'PATCH',
                "http://127.0.0.1:5000/blog",[
                    'json' => $blog->toJsonId(),]
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

    public function editProject(Project $project){

        try {
            $response = $this->client->request(
                'PATCH',
                "http://127.0.0.1:5000/project",[
                    'json' => $project->toJsonId(),]
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
    public function deleteBlog(int $id){
        try {
            $response = $this->client->request(
                'DELETE',
                "http://127.0.0.1:5000/blog/". $id
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

    public function deleteProject(int $id){
        try {
            $response = $this->client->request(
                'DELETE',
                "http://127.0.0.1:5000/project/". $id
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





    public function newBlog(Blog $blog){

        try {
            $response = $this->client->request(
                'POST',
                "http://127.0.0.1:5000/blog",[
                    'json' => $blog->toJson(),]
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

    public function newProject(Project $project){

        try {
            $response = $this->client->request(
                'POST',
                "http://127.0.0.1:5000/project",[
                    'json' => $project->toJson(),]
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

    public function getBlog(int $id){
        $content = [];
        try {
            $response = $this->client->request(
                'GET',
                "http://127.0.0.1:5000/blog/" . $id
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

        }
        return $content;
    }
    
}
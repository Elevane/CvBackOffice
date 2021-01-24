<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    private $service;
    public function __construct(ApiService $service){
        $this->service = $service;
    }
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $skills = $this->service->getSkills();
        $projets = $this->service->getProjets();
        $blogs = $this->service->getBlogs();

        return $this->render('front/index.html.twig', [
            'blogs'=>$blogs,
            'skills' => $skills,
            'projects'=> $projets,
        ]);
    }



}

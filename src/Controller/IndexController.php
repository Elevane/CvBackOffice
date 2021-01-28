<?php

namespace App\Controller;

use App\Service\ApiService;
use App\Service\BlogService;
use App\Service\ProjectService;
use App\Service\SkillService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    private $service;
    private $skillsService;
    private $projectService;
    private $blogService;

    public function __construct(ApiService $service, SkillService $skillService, ProjectService $projectService, BlogService $blogService){
        $this->service = $service;
        $this->skillsService = $skillService;
        $this->projectService = $projectService;
        $this->blogService = $blogService;
    }
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $skills = $this->skillsService->getSkills();
        $projects = $this->projectService->getProjects();
        $blogs = $this->blogService->getBlogs();

        return $this->render('front/index.html.twig', [
            'blogs'=>$blogs,
            'skills' => $skills,
            'projects'=> $projects,
        ]);
    }



}

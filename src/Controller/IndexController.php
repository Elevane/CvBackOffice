<?php

namespace App\Controller;

use App\Form\MessageType;
use App\Service\ApiService;
use App\Service\BlogService;
use App\Service\MessageService;
use App\Service\ProjectService;
use App\Service\SkillService;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    private $service;
    private $skillsService;
    private $projectService;
    private $blogService;
    private $messageService;

    public function __construct(ApiService $service, SkillService $skillService, ProjectService $projectService, BlogService $blogService, MessageService $messageService){
        $this->service = $service;
        $this->skillsService = $skillService;
        $this->projectService = $projectService;
        $this->blogService = $blogService;
        $this->messageService = $messageService;
    }

    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $skills = $this->skillsService->getSkills();
        $projects = $this->projectService->getProjects();
        $blogs = $this->blogService->getBlogs();

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->messageService->newMessage($message);
            return $this->redirectToRoute("index");
        }

        return $this->render('front/index.html.twig', [
            'blogs'=>$blogs,
            'skills' => $skills,
            'projects'=> $projects,
            'message_form' =>$form->createView()
        ]);
    }





}

<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Service\ApiService;
use App\Service\BlogService;
use App\Service\MessageService;
use App\Service\ProjectService;
use App\Service\SkillService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\BaseBackOfficeController;

class BackOfficeController extends BaseBackOfficeController
{


    public function __construct(ApiService $service, SecurityController $security,SkillService $skillService, ProjectService $projectService, BlogService $blogService, MessageService $messageService)
    {
        parent::__construct($service, $security, $skillService,$projectService, $blogService, $messageService);

    }

    /**
     * @Route("/backoffice", name="backoffice_index")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request): Response
    {

        $status = true;
        $skills = $this->skillservice->getSkills();
        $projects = $this->projectService->getProjects();
        $blogs = $this->blogService->getBlogs();
        $messages = $this->messageService->getMessages();

        if (count($blogs) < 1 && count($projects) < 1 && count($skills) < 1) {
            $status = false;
        }
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->skillservice->newSkill($skill);
            return $this->redirectToRoute("backoffice_index");
        }
        return $this->render('backoffice/index.html.twig', [
            'blogs' => $blogs,
            'skills' => $skills,
            'projects' => $projects,
            'api_status' => $status,
            'messages'=> $messages,
            'form' => $form->createView(),

        ]);

    }

}

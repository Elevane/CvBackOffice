<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\BaseBackOfficeController;

class BackOfficeController extends BaseBackOfficeController
{

    public function __construct(ApiService $service, SecurityController $security)
    {
        parent::__construct($service, $security);
    }

    /**
     * @Route("/backoffice", name="backoffice_index")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        $status = true;
        $skills = $this->service->getSkills();
        $projects = $this->service->getProjects();
        $blogs = $this->service->getBlogs();
        if (count($blogs) < 1 && count($projects) < 1 && count($skills) < 1) {
            $status = false;
        }
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->service->newSkill($skill);
            return $this->redirectToRoute("backoffice_index");
        }
        return $this->render('backoffice/index.html.twig', [
            'blogs' => $blogs,
            'skills' => $skills,
            'projects' => $projects,
            'api_status' => $status,
            'form' => $form->createView(),

        ]);

    }

}

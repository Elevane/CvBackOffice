<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Skill;
use App\Form\ProjectType;
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
     * @Route("/admin", name="admin_index")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
            $status = true;
            $skills = $this->service->getSkills();
            $projets = $this->service->getProjets();
            $blogs = $this->service->getBlogs();
            if(count($blogs) < 1 && count($projets) <1 && count($skills) <1){
                $status = false;
            }
            $skill = new Skill();
            $form = $this->createForm(SkillType::class, $skill);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){

                $this->service->newSkill($skill);
                return $this->redirectToRoute("admin_index");
            }
            return $this->render('backoffice/index.html.twig', [
                'blogs'=>$blogs,
                'skills' => $skills,
                'projects'=> $projets,
                'api_status' => $status,
                'form' => $form->createView(),

            ]);

    }

    /**
     * @Route("/project/edit/{id}", name="admin_project_edit")
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, int $id){

        $projet = new Projet();
        $api_projet = $this->service->getProjet($id);
        if($api_projet){

            $projet->setId($api_projet['id']);
            $projet->setImage($api_projet['img']);
            $projet->setNom($api_projet['name']);
            $projet->setTechnos($api_projet['technos']);
            $form =$this->createForm(ProjectType::class, $projet);


            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $data = $form->getData();
                $projet->setImage($data['image']);
                $projet->setTechnos($data['technos']);
                $projet->setNom($data['nom']);

            }
            return $this->render('backoffice/projet/edit.html.twig', ['editform' => $form->createView(),
                'projet' => $api_projet,
                'title' => 'Modification du Projet : '. $projet->getNom(),
            ]);
        }


        return $this->redirectToRoute('admin_index');
    }


   
}

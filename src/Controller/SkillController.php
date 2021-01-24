<?php


namespace App\Controller;


use App\Entity\Skill;
use App\Form\ProjectType;
use App\Form\SkillType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class SkillController
 * @package App\Controller
 */
class SkillController extends BaseBackOfficeController
{


    /**
     * @Route("/admin/skill/edit/{id}", name="admin_skill_edit")
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, int $id){

        $skill = new Skill();
        $api_skill = $this->service->getSkill($id);
        if($api_skill){
            $skill->setId($api_skill['id']);
            $skill->setActive($api_skill['active']);
            $skill->setName($api_skill['name']);
            $skill->setRatio($api_skill['ratio']);



            $form =$this->createForm(SkillType::class, $skill);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){

                $data = $form->getData();
                $this->service->editSkill($skill);
                return $this->redirectToRoute('admin_index');
            }
            return $this->render('backoffice/skill/edit.html.twig', ['editform' => $form->createView(),
                'skill' => $api_skill,
                'title' => 'Modification du Skill : '. $skill->getName(),
            ]);
        }


        return $this->redirectToRoute('admin_index');
    }




    /**
     * @Route("/admin/skill/delete/{id}", name="admin_skill_delete")
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteAction(int $id): RedirectResponse
    {
        $skill = $this->service->getSkill($id);
        if($skill){
            $this->service->deleteSkill($id);
            return $this->redirectToRoute('admin_index');
        }
        return $this->redirectToRoute('admin_index');
    }
}
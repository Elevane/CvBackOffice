<?php


namespace App\Controller;


use App\Entity\Project;
use App\Entity\Skill;
use App\Form\BlogType;
use App\Form\ProjectType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProjectController extends BaseBackOfficeController{

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/project/new", name="admin_project_new")
     */
    public function newAction(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $skills = $this->service->getSkills();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            $filename = $file->getClientOriginalName();
            $path = "image/project/";
            $pathFileName = $path . $filename;

            $project->setImage($pathFileName);
            $this->service->newProject($project);
            $file->move($path, $filename );

            return $this->redirectToRoute('admin_index');
        }
        return $this->render('/backoffice/project/new_or_edit.html.twig',[
            "form" => $form->createView(),
            'skills' => $skills,
            "title" => "Creation d'un  project",
        ]);
    }

    /**
     * @Route("/admin/project/edit/{id}", name="admin_project_edit")
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, int $id){

    $project = new Project();
    $api_project = $this->service->getProject($id);
    $skills = $this->service->getSkills();
    if($api_project){



        $project ->setId($api_project['id']);
        $project ->setImage(new File($api_project['image']));
        $project ->setName($api_project['name']);
        $project ->setSkills($api_project['skills']);

        $form =$this->createForm(ProjectType::class, $project );
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = $form['image']->getData();
            if($file != null){
                $filename = $file->getClientOriginalName();
                $path = "image/project/";
                $pathFileName = $path . $filename;
                $project->setImage($pathFileName);
                $file->move($path, $filename );
            }
            else{
                $project->setImage($api_project['image']);
            }

            $this->service->editProject($project) ;
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('backoffice/project/new_or_edit.html.twig', [
            'project' => $api_project,
            "skills" => $skills,
            'form' => $form->createView(),
            'title' => 'Modification du Project : '.$project ->getName(),
        ]);
    }
    return $this->redirectToRoute('admin_index');
}




    /**
     * @Route("/admin/project/delete/{id}", name="admin_project_delete")
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteAction(int $id): RedirectResponse
{
    $project = $this->service->getProject($id);
    if($project) {

        $this->service->deleteProject($project['id']);
        return $this->redirectToRoute('admin_index');
    }
    return $this->redirectToRoute('admin_index');
}
}
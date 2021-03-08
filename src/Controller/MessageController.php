<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Project;
use App\Entity\Skill;
use App\Form\BlogType;
use App\Form\ProjectType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends BaseBackOfficeController
{

    /**
     * @Route("/backoffice/message/delete/{id}", name="backoffice_message_delete")
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteAction(int $id): RedirectResponse
    {
        $blog = $this->messageService->getMessage($id);
        if($blog) {
            $this->messageService->deleteMessage($id);
            return $this->redirectToRoute('backoffice_index');
        }
        return $this->redirectToRoute('backoffice_index');
    }

}
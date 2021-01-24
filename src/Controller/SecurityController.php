<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    private $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session){
        $this->session = $session;
    }


    /**
     * @Route("/login", name="admin_login")
     * @param Request $request
     * @return Response
     */
    public function login(Request $request): Response
    {
        if($this->isLogged()){
            return $this->redirectToRoute('admin_index');
        }
        else{

            $error = '';
            $user = new User();
            $form = $this->createForm(LoginType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                if ($this->checkCredentials()) {
                    $this->AddUserTosession($user);
                    return $this->redirectToRoute('admin_index');

                } else {

                    $error = 'User doesnt exist';
                }
            }

            return $this->render('security/login.html.twig', ['form' => $form->createView(), 'errors' => $error]);
        }
    }

    /**
     * @Route("/logout", name="admin_logout")
     */
    public function logout(): Response
    {
        $this->session->clear();
        return $this->redirectToRoute('admin_login');
    }



    public function AddUserToSession(User $user)
    {
        if($user){
            $this->session->set('user', $user);
        }
    }

    public function checkCredentials()
    {
        return true;
        //TODO check if user exist
    }


    public function isLogged(){

        if ($this->session->get('user') == null) {
            if($this->checkCredentials()){
                return false;
            }
            return true;
        }
        else{
            return true;
        }
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    private $session;
    private $service;
    private $error = "";

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session, ApiService $service){
        $this->session = $session;
        $this->service = $service;
    }


    /**
     * @Route("/login", name="admin_login")
     * @param Request $request
     * @return Response
     */
    public function login(Request $request): Response
    {
            $user = new User();
            $form = $this->createForm(LoginType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                if ($this->checkCredentials($user)) {
                    $this->AddUserTosession($user);
                    return $this->redirectToRoute('admin_index');

                }
            }

            return $this->render('backoffice/security/login.html.twig', [
                'form' => $form->createView(),
                'error' => $this->error,
                'title' => "Se Connecter"
            ]);

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

    public function checkCredentials($user)
    {
        if($user != null &&  $this->session->get('user') == null){

            $log = $this->service->getUserByUsername( $user->getLogin(),  $user->getPassword());

            if($log === true){

                return true;
            }else{
                if(is_bool($log)){
                    $this->error = "l'utilisateur n'existe pas";
                }
                else{
                    $this->error = $log;
                }

                return false;
            }
        }else{
            $this->error = "Erreur d'authentification";
        }
        return false;

        //TODO check if user exist
    }


    public function isLogged(){

        if ($this->session->get('user')!= null) {

            return true;
        }
        else{
            return false;
        }
    }
}

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
     * @param ApiService $service
     */
    public function __construct(SessionInterface $session, ApiService $service){
        $this->session = $session;
        $this->service = $service;
    }


    /**
     * @Route("/login", name="backoffice_login")
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
                    return $this->redirectToRoute('backoffice_index');

                }
            }

            return $this->render('backoffice/security/login.html.twig', [
                'form' => $form->createView(),
                'error' => $this->error,
                'title' => "Se Connecter"
            ]);

    }

    /**
     * @Route("/logout", name="backoffice_logout")
     */
    public function logout(): Response
    {
        $this->session->clear();

        return $this->redirectToRoute('backoffice_login');
    }



    public function AddUserToSession(User $user)
    {
        if($user){
            $this->session->set('user', $user);
        }
    }

    /**
     * @param $user
     * @return bool
     * Vérifie sur l'utilsiateur présent en session est le bon et existe. Sinon vérifie les données données du formulaire.
     */
    public function checkCredentials($user): bool
    {
        if($user != null &&  $this->session->get('user') == null){

            $log = $this->service->getUserByUsername($user);

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
            if($this->session->get('user')){
                $log = $this->service->getUserByUsername( $this->session->get('user'));
               if($log === true){
                   return true;
               }
               $this->error = "L'utilisateur n'éxiste pas";
                return false;
            }
            $this->error = "Erreur d'authentification";
        }
        return false;


    }


    public function isLogged(): bool
    {

        if ($this->session->get('user')!= null) {

            return true;
        }
        else{
            return false;
        }
    }
}

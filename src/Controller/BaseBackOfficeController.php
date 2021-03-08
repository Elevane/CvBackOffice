<?php


namespace App\Controller;


use App\Service\ApiService;
use App\Service\BlogService;
use App\Service\MessageService;
use App\Service\ProjectService;
use App\Service\SkillService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BaseBackOfficeController
 * @package App\Controller
 */
class BaseBackOfficeController extends AbstractController
{
    protected $service;
    private $security;
    protected $skillservice;
    protected $projectService;
    protected $blogService;
    protected  $messageService;

    public function __construct(ApiService $service, SecurityController  $security, SkillService $skillService, ProjectService $projectService, BlogService $blogService, MessageService $messageService){
        $this->security = $security;
        $this->service = $service;
        $this->skillservice = $skillService;
        $this->projectService = $projectService;
        $this->blogService = $blogService;
        $this->messageService = $messageService;

        if ($this->security->isLogged()) {
            return $this->security->redirectToRoute('backoffice_login');
        }
    }
}
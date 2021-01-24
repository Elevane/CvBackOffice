<?php


namespace App\Controller;


use App\Service\ApiService;
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

    public function __construct(ApiService $service, SecurityController  $security){
        $this->security = $security;
        $this->service = $service;
        if (!$this->security->isLogged()) {
            return $this->redirectToRoute('admin_login');
        }
    }
}
<?php

namespace App\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    #[Route('/', name: 'main_home')]
    public function home(){
        return $this->render('main/home.html.twig');
    }

    #[Route('/aboutUs', name: 'main_aboutUs')]
    public function aboutUs(){
        $lorem = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

        return $this->render('main/about_us.html.twig',[
            'lorem' => $lorem
        ]);
    }

}
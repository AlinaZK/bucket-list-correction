<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\SerieType;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/wish/', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('list', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy(['isPublished'=>true], ['dateCreated'=>'DESC']);


        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes
        ]);
    }

    #[Route('detail/{id}', name: 'detail')]
    public function detail(int $id, WishRepository $wishRepository): Response
    {

        $wish = $wishRepository->find($id);

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish
        ]);
    }
    #[Route('chose', name: 'chose')]
    public function chose(Request $request,EntityManagerInterface $entityManager): Response{

        $chose = new Wish();

        $choseForm = $this->createForm (WishType::class, $chose);

        dump($chose);// pour affiche la defirance

        // hydrade l'instance $chose avec donnes de la request
        $choseForm->handleRequest($request);
        dump($chose);


        // test si le formulaire a ete soumis
        if($choseForm->isSubmitted() && $choseForm->isValid()){

            $chose->setDateCreated(new \DateTime());
            $chose->setIsPublished(true);

            // entresitre le souit en BDD
            $entityManager->persist($chose);
            $entityManager->flush();

// messge flash odnamomentnie odnorazovie
            $this->addFlash('success', 'Idea successfully added!');//  attention bien mettre (type) !!!!

            return $this ->redirectToRoute('wish_detail', ['id'=> $chose->getId()]);
        }

        dump($request);


        return $this ->render('/wish/chose.html.twig', [

            'choseForm'=>$choseForm
        ]);


    }


    #[Route('demo', name: 'demo')]
    public function demo(EntityManagerInterface $entityManager){

        $wish = new Wish();
        $wish->setTitle('Faire le tour du monde');
        $wish->setAuthor('moi');
        $wish->setDescription('en bateau');
        $wish->setDateCreated(new \DateTime());
        $wish->setIsPublished(true);

        $entityManager->persist($wish);
        $entityManager->flush();

        return $this->render('wish/list.html.twig');

    }



}

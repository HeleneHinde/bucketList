<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(): Response
    {
        return $this->render('wish/list.html.twig');
    }

    #[Route('/{id}', name: 'show', requirements: ["id"=>"\d+"])]
    public function show($id): Response
    {
        dump($id);
        return $this->render('wish/show.html.twig');
    }

}

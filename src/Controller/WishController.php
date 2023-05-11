<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->findBy(['isPublished'=>true], ['dateCreated'=>'ASC'], 48);

        return $this->render('wish/list.html.twig', ['wish'=>$wish]);
    }

    #[Route('/{id}', name: 'show', requirements: ["id"=>"\d+"])]
    public function show(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);
        return $this->render('wish/show.html.twig',['wish'=>$wish]);
    }

}

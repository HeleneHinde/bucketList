<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Entity\Wish;
use App\Form\SerieType;
use App\Form\WishType;
use App\Repository\SerieRepository;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->findBy(['isPublished' => true], ['dateCreated' => 'ASC'], 48);

        return $this->render('wish/list.html.twig', ['wish' => $wish]);
    }

    #[Route('/{id}', name: 'show', requirements: ["id" => "\d+"])]
    public function show(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);
        return $this->render('wish/show.html.twig', ['wish' => $wish]);
    }


    #[Route('/add', name: 'add')]
    public function add(Request $request, WishRepository $wishRepository): Response
    {

        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);

        //Permet d'extraire les données de la requête
        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            //traitement de la donnée

            //new DateTime renvoi la date du jour
            $wish->setDateCreated(new \DateTime());

            $wish->setIsPublished(true);

            //ajoute la série en BDD
            $wishRepository->save($wish, true);

            //après ajout, redirige vers la page de détail
            $this->addFlash('success', 'Wish successfully added !');
            return $this->redirectToRoute('wish_show', ['id' => $wish->getId()]);
        }

        return $this->render('serie/add.html.twig', ['wishForm' => $wishForm->createView()]);
    }
}
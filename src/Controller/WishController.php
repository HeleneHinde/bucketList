<?php

namespace App\Controller;


use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\CategoryRepository;
use App\Repository\WishRepository;
use App\Tools\Censurator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
        $wish = $wishRepository->findBy(['isPublished' => true], ['category' => 'ASC'], 48);


        return $this->render('wish/list.html.twig', ['wish' => $wish]);
    }

    #[Route('/{id}', name: 'show', requirements: ["id" => "\d+"])]
    public function show(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);


        return $this->render('wish/show.html.twig', ['wish' => $wish, 'category' => $wish->getCategory()]);
    }


    #[IsGranted("ROLE_USER")]
    #[Route('/add', name: 'add')]
    public function add(Request $request, WishRepository $wishRepository, Censurator $censurator): Response
    {

        $wish = new Wish();
        //récupérer l'user de la session
        $user=$this->getUser();
        $wish->setAuthor($user->getPseudo());

        $wishForm = $this->createForm(WishType::class, $wish);

        //Permet d'extraire les données de la requête
        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            //traitement de la donnée

            //new DateTime renvoi la date du jour
            $wish->setDateCreated(new \DateTime());

            $wish->setIsPublished(true);

            $wish->setTitle($censurator->purify($wish->getTitle()));
            $wish->setDescription($censurator->purify($wish->getDescription()));

            //ajoute la série en BDD
            $wishRepository->save($wish, true);

            //après ajout, redirige vers la page de détail
            $this->addFlash('success', 'Wish successfully added !');
            return $this->redirectToRoute('wish_show', ['id' => $wish->getId()]);
        }

        return $this->render('wish/add.html.twig', ['wishForm' => $wishForm->createView()]);
    }
}
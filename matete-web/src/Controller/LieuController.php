<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use App\Repository\LieuRepository;
use App\Repository\ProducteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panel/lieu')]
class LieuController extends AbstractController
{
    #[Route('/', name: 'lieu_index', methods: ['GET'])]
    public function index(LieuRepository $lieuRepository): Response
    {
        return $this->render('lieu/index.html.twig', [
            'lieus' => $lieuRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'lieu_new', methods: ['GET','POST'])]    
    /**
     * new
     *  Ajouter un lieu
     * @param  mixed $request
     * @param  mixed $producteurRepository
     * @return Response
     */
    public function new(Request $request, ProducteurRepository $producteurRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $lieu = new Lieu();

        if ($request->request->get('sendLieu') != NULL ) {
            $producteur = $producteurRepository->find($this->getUser());
            $coordoneeX = $request->request->get('CooX');
            $coordoneeY = $request->request->get('CooY');
            
            $lieu->setCooX($coordoneeX);
            $lieu->setCooY($coordoneeY);
            $lieu->setNom($request->request->get('Nomlieu'));
            $lieu->setDescLieu($request->request->get('Desclieu'));
            $lieu->addProducteur($producteur);

            $entityManager->persist($lieu);
            $entityManager->flush();

            return $this->redirectToRoute('main_page');
        }

        return $this->render('lieu/new.html.twig');
        
    }

    #[Route('/{id}', name: 'lieu_show', methods: ['GET'])]    
    /**
     * show
     *  Afficher un lieu
     * @param  mixed $lieu
     * @return Response
     */
    public function show(Lieu $lieu): Response
    {
        return $this->render('lieu/show.html.twig', [
            'lieu' => $lieu,
        ]);
    }

    #[Route('/{id}/edit', name: 'lieu_edit', methods: ['GET','POST'])]    
    /**
     * edit
     *  Modifier un lieu
     * @param  mixed $request
     * @param  mixed $lieu
     * @return Response
     */
    public function edit(Request $request, Lieu $lieu): Response
    {
        $form = $this->createForm(LieuType::class, $lieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lieu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lieu/edit.html.twig', [
            'lieu' => $lieu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'lieu_delete', methods: ['POST'])]    
    /**
     * delete
     *  Supprimer un lieu
     * @param  mixed $request
     * @param  mixed $lieu
     * @return Response
     */
    public function delete(Request $request, Lieu $lieu): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lieu->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lieu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lieu_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Lieu;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use App\Repository\LieuRepository;
use App\Repository\ProducteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie as HttpFoundationCookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_page')]    
    /**
     * index
     * Affichage de la main Page,
     * Initialisation des marker pour la carte,
     * Initialisation des filtres
     * @param  mixed $request
     * @param  mixed $annonceRepository
     * @param  mixed $lieuRepository
     * @param  mixed $producteurRepository
     * @param  mixed $categorieRepository
     * @return Response
     */
    public function index(Request $request, AnnonceRepository $annonceRepository, LieuRepository $lieuRepository, ProducteurRepository $producteurRepository, CategorieRepository $categorieRepository): Response
    {
        $session = new Session();
        $session->start();

        $response = new Response();
        $cookie = new HttpFoundationCookie('visite', 'true' ,time() + (365 * 24 * 60 * 60));
        $response->headers->setCookie($cookie);
        $response->sendHeaders();
        $cookie = $request->cookies->get('visite');

        $user = $this->getUser();
        $lieux = $lieuRepository->findAll();
        $annonceFiltre = $annonceRepository->findAll();

        // MAPS
        $listeLieux = [];
        foreach ($lieux as $lieu) {
            $name = $lieu->getNom();
            $cooX = $lieu->getCooX();
            $cooY = $lieu->getCooY();
            
            $annonceListe = [];
            foreach ($lieu->getAnnonce() as $annonce) {
                $libelle = $annonce->getLibelleProduit();
                $id = $annonce->getId();

                if ($session->get('filtre') != null) {
                    foreach ($session->get('filtre') as $filtre) {
                        if ($filtre == $libelle) {
                            $annonceListe[] = array(
                                'libelle' => $libelle,
                                'id' => $id,
                            );
                        }
                    }
                } else {
                    $annonceListe[] = array(
                        'libelle' => $libelle,
                        'id' => $id,
                    );
                }

                
            }
            
            $listeLieux[] = array(
                'name' => $name,
                'cooX'=> $cooX,
                'cooY' => $cooY,
                'annonce' => $annonceListe,
            );
                
        }


        if ($user != NULL) {
            $producteur = $producteurRepository->find($this->getUser());
                // Afficher le tableau des annonces
            $listeDesAnnonces = [];
            foreach ($producteur->getAnnonce() as $annonce) {
                $libelle = $annonce->getLibelleProduit();
                $creneauxDebut = $annonce->getCreneauxDebut();
                $creneauxFin = $annonce->getCreneauxFin();
                $prixUnitaire = $annonce->getPrixUnitaire();
                $quantite = $annonce->getQuantite();
                $status = $annonce->getStatus();
                $dateMiseEnLigne = $annonce->getDateMiseEnLigne();
                $id = $annonce->getId();
                $categorie = $annonce->getCategorie();
                    
                    $listeDesAnnonces[] = array(
                        'id' => $id,
                        'libelle' => $libelle,
                        'cDebut' => $creneauxDebut,
                        'cFin' => $creneauxFin,
                        'status' => $status,
                        'date' => $dateMiseEnLigne,
                        'quantite' => $quantite,
                        'prix' => $prixUnitaire,
                        'categorie' => $categorie
                    );
            }
        }
        // Liste filtre
        $ListeFiltre=[];
        foreach($annonceFiltre as $uneAnnonce){
            $id = $uneAnnonce->getId();
            $libelle = $uneAnnonce->getLibelleProduit();
            $ListeFiltre[] = array(
                'id' => $id,
                'libelle'=> $libelle,
            );
        }


        if($user == null){
            return $this->render('main/index.html.twig', [
                'listeLieux' => $listeLieux,
                'cookies' => $cookie,
                'ListeFiltre' => $ListeFiltre,
                'sessionFiltre' => $session->get('filtre'),
            ]);
        }else{
            return $this->render('panel_prod/index.html.twig', [
                'listeLieux' => $listeLieux,
                'cookies' => $cookie,
                'tableauAnnonce' => $listeDesAnnonces,
                'ListeFiltre' => $ListeFiltre,
                'sessionFiltre' => $session->get('filtre'),
            ]);
        }
    }

    #[Route('/ajout/{id}', name: 'panierAjout')]    
    /**
     * ajoutPanier
     *  Ajout des annonces au panier
     * @param  mixed $annonceRepository
     * @param  mixed $annonce
     * @param  mixed $lieuRepository
     * @return Response
     */
    public function ajoutPanier(AnnonceRepository $annonceRepository, Annonce $annonce, LieuRepository $lieuRepository): Response
    {
        $annon = $annonce;
        $idLieu = $annon->getLieu()->getId();
        $lieu = $lieuRepository->findById($idLieu);
        $session = new Session();
        $session->start();

        $panier = [];
        if ($session->get('panier') != NULL) {
            foreach ($session->get('panier') as $p) {
                array_push($panier, $p);
            }
        }
        array_push($panier, [
            'annonce' => $annon,
            'lieu' => $lieu[0],
        ]);
        
        $session->set('panier', $panier);
        
        $this->addFlash(
            'alert',
            "Item ajouter"
        );
        
        return $this->redirectToRoute('main_page');
    }

    #[Route('/panier', name: 'panier_show')]    
    /**
     * showPanier
     *  Affichage du panier
     * @param  mixed $annonceRepository
     * @return Response
     */
    public function showPanier(AnnonceRepository $annonceRepository): Response
    {
        $session = new Session();
        $session->start();

       return $this->render('main/panier.html.twig', [
           'panier' => $session->get('panier'),
       ]);
    }

    #[Route('/panier/clear', name: 'clearPanier')]    
    /**
     * clearPanier
     *  Suppression du panier
     * @return Response
     */
    public function clearPanier(): Response
    {
        $session = new Session();
        $session->start();

        $session->clear();

       return $this->redirectToRoute('main_page');
    }

    #[Route('/filtre', name: 'appliqueFiltre')]    
    /**
     * appliqueFiltre
     *  Appliquer les filtres sélectionnée
     * @param  mixed $request
     * @return Response
     */
    public function appliqueFiltre(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $session = new Session();

        $filtre = $request->request->get('check');
        $session->set('filtre', $filtre);

        

        return $this->redirectToRoute('main_page'); 
    }
}

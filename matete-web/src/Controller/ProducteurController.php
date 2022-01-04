<?php

namespace App\Controller;

use App\Entity\Producteur;
use App\Repository\ProducteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('/panel/producteur')]
class ProducteurController extends AbstractController
{
    #[Route('/', name: 'producteur_index', methods: ['GET'])]
    public function index(ProducteurRepository $producteurRepository): Response
    {
        return $this->render('producteur/index.html.twig', [
            'producteurs' => $producteurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'producteur_new', methods: ['GET','POST'])]    
    /**
     * new
     *  Creation d'un utilisateur Producteur 
     * @param  mixed $request
     * @param  mixed $userPass
     * @param  mixed $producteurRepository
     * @return Response
     */
    public function new(Request $request,UserPasswordEncoderInterface $userPass, ProducteurRepository $producteurRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $producteur = new Producteur();
        $userProd = $producteurRepository->findOneByMail($request->request->get('mail'));

        if (!$userProd) {
            if ($request->request->get('pass') == $request->request->get('passConf')) {
                $passHash = ($userPass->encodePassword($producteur, $request->request->get('pass')));
                $producteur->setMdp($passHash);

                $producteur->setNom($request->request->get('nom'));
                $producteur->setPrenom($request->request->get('prenom'));
                $producteur->setTel($request->request->get('tel'));
                $producteur->setMail($request->request->get('mail'));

                $entityManager->persist($producteur);
                $entityManager->flush();
                
                return $this->redirectToRoute("login_security");
            } else {
                $this->addFlash(
                    'alert',
                    "Vos mots de passe ne sont pas identique !"
                );

                return $this->redirectToRoute("register_security");

            }
        }  else {
            $this->addFlash(
                'alert',
                "L'adresse mail est déja utilisé !"
            );
            return $this->redirectToRoute("register_security");

        }
    }

    #[Route('/{id}', name: 'producteur_show', methods: ['GET'])]    
    /**
     * show
     * Afficher l'utilisateur
     * @param  mixed $producteur
     * @return Response
     */
    public function show(Producteur $producteur): Response
    {
        return $this->render('producteur/show.html.twig', [
            'producteur' => $producteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'producteur_edit', methods: ['GET','POST'])]    
    /**
     * edit
     *  Modifier info utilisateur
     * @param  mixed $request
     * @param  mixed $producteur
     * @param  mixed $userPass
     * @return Response
     */
    public function edit(Request $request, Producteur $producteur, UserPasswordEncoderInterface $userPass): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        //Edition Nom
        if ($request->request->get('nom') != null) {
            $producteur->setNom($request->request->get('nom'));
        }

        //Edition Prenom
        if ($request->request->get('prenom') != null) {
            $producteur->setPrenom($request->request->get('prenom'));
        }

        //Edition Telephone
        if ($request->request->get('tel') != null) {
            $producteur->setTel($request->request->get('tel'));
        }

        //Edition Email
        if ($request->request->get('mail') != null) {
            $producteur->setMail($request->request->get('mail'));
        }

        //Verification mot de passe
        if ($request->request->get('passAnc') != null) {
            $oldPassword = $request->request->get('passAnc');
            $newPass = $request->request->get('pass');
            $newPassConf = $request->request->get('passConf');
            if ($userPass->isPasswordValid($producteur,$oldPassword)){
                if ($newPass != null){
                    if ($newPass == $newPassConf){
                        if ($newPass != $oldPassword ){
                            $passHash = ($userPass->encodePassword($producteur, $newPass)); 
                            $producteur->setMdp($passHash);
                        }else{
                            $this->addFlash(
                                'alert',
                                'Votre nouveau mot de passe ne peut pas être identique a votre mot de passe actuel'
                            );
                        }
                    }else{
                        $this->addFlash(
                            'alert',
                            'Veuillez entrez deux mot de passe identique'
                        );
                    }
                }else{
                    $this->addFlash(
                        'alert',
                        'Veuillez rentrer le nouveau mot de passe'
                    );
                }
            }
        }
        //$request->request->get('passAnc')
        
        $entityManager->persist($producteur);
        $entityManager->flush();

        return $this->redirectToRoute("main_page");
    }

    #[Route('/{id}/delete', name: 'producteur_delete')]    
    /**
     * delete
     *  Supprimer son utilisateur
     * @param  mixed $request
     * @param  mixed $producteur
     * @param  mixed $manager
     * @return Response
     */
    public function delete(Request $request, Producteur $producteur, EntityManagerInterface $manager): Response
    {   
        $manager->remove($producteur);
        $manager->flush();

        $session = new Session();
        $session->invalidate();

        $this->addFlash(
            'msg',
            "Utilisateur supprimé !!");

        return $this->redirectToRoute("main_page");

    }

    #[Route('/confirmationSupression/{id}', name: 'producteur_confDelete', methods: ['GET'])]    
    /**
     * confirmationDelete
     *  Confirmation de suppression de l'utilisateur
     * @param  mixed $producteur
     * @return Response
     */
    public function confirmationDelete(Producteur $producteur): Response
    {
        return $this->render('producteur/_confDelete_form.html.twig', [
            'producteur' => $producteur,
        ]);
    }

}

<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Lieu;
use App\Repository\AnnonceRepository;
use App\Repository\LieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProducteurRepository;

class PanelProdController extends AbstractController
{
    #[Route('/panel/prod/panier', name: 'panel_prod_panier')]
    public function index(): Response
    {
    }
}

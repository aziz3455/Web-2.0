<?php
namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/manual')]
class ManualController extends AbstractController
{
    #[Route('/list', name: 'manual_hello')]
    public function hello(): Response
    {
        return new Response("Hello everybody!!!!");
    }

    #[Route('/count-romance', name: 'manual_count_romance')]
    public function countRomance(LivreRepository $livreRepository): Response
    {
        $nombre = $livreRepository->countRomanceBooks();
        $livres = $livreRepository->findBooksBetweenDates(
            new \DateTime('2014-01-01'),
            new \DateTime('2018-12-31')
        );

        // Just a simple output, you can also render Twig
        return new Response(
            "Nombre de livres Romance: $nombre <br> Livres entre 2014 et 2018: " . count($livres)
        );
    }
}

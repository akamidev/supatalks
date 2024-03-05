<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\SpeakerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        EventRepository $eventRepository,
        SpeakerRepository $speakerRepository
    ): Response
    {
        return $this->render('home/index.html.twig', [
            'title' => 'Supatalks',
            'events' => $eventRepository->findAll(),
            'speakers' => $speakerRepository->findAll(),
        ]);
    }
}
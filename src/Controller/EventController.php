<?php
// src/Controller/EventController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EventFilterType;
use App\Entity\Event;

class EventController extends AbstractController
{
    /**
     * @Route("/event/filter", name="event_filter")
     */
    public function filter(Request $request): Response
    {
        $form = $this->createForm(EventFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventName = $form->get('eventName')->getData();

            $events = $this->getDoctrine()
                ->getRepository(Event::class)
                ->findBy(['name' => $eventName]);

            return $this->render('event/list.html.twig', [
                'events' => $events,
            ]);
        }

        return $this->render('event/filter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
?>
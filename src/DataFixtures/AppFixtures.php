<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Event;
use App\Entity\Speaker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR'); // initialisation de faker
        $events = [
            'Frontend Masters',
            'Backend Masters',
            'Truth about PHP',
            'Symfony 7, what\'s new ?',
            'React, framework or library ?',
            'Vue.js, the new challenger ?',
            'Angular, the old one ?',
            'Web components, the future ?',
            'WebAssembly, how to use it ?',
            'GPDR, how to be compliant ?',
            'Docker, the new way to deploy ?',
            'Kubernetes, scale like a boss ?',
            'AWS, the cloud leader ?',
            'Wordpress, still alive ?',
            'PHP 8.3, what\'s new ?',
            'UI/UX, for frontend developers',
            'API, the essential for frontend',
            'GraphQL vs REST, which is better ?',
            'Web security, how to protect ?',
            'Web performance, how to optimize ?',
        ];
        // Les speakers
       // Création de 40 speakers
       $speakerArray = [];
       for ($i=1; $i < 41; $i++) { 
           $speaker = new Speaker();
           $speaker->setFirstname($faker->firstName)
               ->setLastname($faker->lastName)
               ->setJob($faker->jobTitle)
               ->setCompany($faker->company)
               ->setExperience($faker->numberBetween(1, 20))
               ->setImage('https://randomuser.me/api/portraits/men/'. $i .'.jpg')
               ;
               array_push($speakerArray, $speaker);
               $manager->persist($speaker);
       }
        // Boucle pour créer 20 événements
        for ($i=0; $i < count($events); $i++) { 
            
            $event = new Event();
            $event->setName($events[$i])
                ->setTheme('Web development')
                ->setDate($faker->dateTimeBetween('-6 months', '+6 months'))
                ->setLocation($faker->city)
                ->setAttendee($faker->numberBetween(10, 100))
                ->setPrice($faker->numberBetween(0, 250))
                ->addSpeaker($speakerArray[$i])
                ;
            $manager->persist($event);
        }
        

         

        $manager->flush();
    }
}

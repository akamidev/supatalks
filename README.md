# Supatalks

## Création du projet Symfony

La commande suivante permet de créer un projet Symfony :

```bash
symfony new supatalks --webapp
```

## Lancez le serveur web

```bash
symfony server:start
```

autre option pour lancer le serveur sans les logs dans le terminal :

```bash
symfony server:start -d
```

## Création d'une page d'accueil

```bash
symfony console make:controller Home
```

On met à jour le fichier `src/Controller/HomeController.php` pour ajouter une méthode `index` :

```php
#[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'title' => 'Supatalks',
        ]);
    }
```

## Personalisation de la page d'accueil

Tout d'abord nous avons mis en place le framework css Bootstrap. En  important les fichiers CSS et JS dans le dossier "assets" afin de les configurer dans le système d'AssetMapper de Symfony.

```bash
assets/
├── css/
│   ├── bootstrap.min.css
│   └── bootstrap.min.css.map
└── js/
│   ├── bootstrap.bundle.min.js
    └── bootstrap.bundle.min.js.map
```

Dans le fichier `app.js` :
    
```javascript
    import './js/bootstrap.bundle.min.js';
    import './styles/bootstrap.min.css';
```

Concernant l'ajout des police d'écriture ou de librairie d'icônes, nous avons ajouté le tout dans le fichier `base.html.twig` :

```html
    <head>
        //...
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Unbounded:wght@200..900&display=swap" rel="stylesheet">
        //...
    </head>
```

## Préparation de l'architecture des entités

On se rend sur une app comme `https://dbdiagram.io/d/Supatalks-65e6dd07cd45b569fb8c90f0` pour créer un schéma de base de données.

On se retrouve pour le moment avec 2 entités : `Event` et `Speaker`.

## Création des entités

Pour créer les entité et les mettre en place dans la base de données, on utilise les commandes suivantes :

```bash
symfony console make:entity Event
symfony console make:entity Speaker
```

On suit les instructions pour créer les propriétés des entités.

Point important concernant la relation entre les entités `Event` et `Speaker` : un événement peut avoir plusieurs speakers et un speaker peut participer à plusieurs événements non simultanés. On se retrouve donc avec une relation `OneToMany` entre les deux entités. De préférence à du `ManyToMany` qui ne nous convient pas dans ce cas précis.

## Création de la base de données

Premièrement, nous avons besoin de configurer la base de données dans le fichier `.env`. Dans notre on a utilisé une base de données SQLite :

```env
DATABASE_URL="sqlite:///%kernel.project_dir%/var/supatalks.db"
```

On créé la base de données avec la commande suivante `symfony console doctrine:database:create`. Ce qui nous permet de créer la base de données `supatalks.db` dans le dossier `var`.

## Migration des entités

Pour faire une migration, cela se passe en deux étapes :

1. Création de la migration :

```bash
symfony console make:migration
```

2. Exécution de la migration :

```bash
symfony console doctrine:migrations:migrate
```

Note importante : dès lors que l'on modifie ou ajoute une propriété à une entité, il faut refaire une migration pour mettre à jour la base de données. Car le shéma de la base de données est généré à partir des entités et que Doctrine ne pourra pas faire son travail d'ORM correctement.


## Création des fixtures

Pour les fixtures en dtail rdv ici : [SymGuide](https://docs.symguide.com/fixtures)

Le contenu de notre fichier `src/DataFixtures/AppFixtures.php` :

```php
<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Event;
use App\Entity\Speaker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR'); // Initialisation de Faker

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

        // Tableau de 20 événements
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

        // Boucle pour créer 20 événements
        foreach ($events as $item) {
            $event = new Event();
            $event->setName($item)
                ->setTheme('Web development')
                ->setDate($faker->dateTimeBetween('-6 months', '+6 months'))
                ->setLocation($faker->city)
                ->setAttendee($faker->numberBetween(10, 100))
                ->setPrice($faker->numberBetween(0, 250))
                ->addSpeaker($speakerArray[$faker->numberBetween(0, 39)])
                ;
            $manager->persist($event);
        }
        
        $manager->flush();
    }
}
```

Avec cette fixture, on crée 40 speakers et 20 événements. On utilise Faker pour générer des données aléatoires. Afin de charger les fixtures dans la base de données, on utilise la commande suivante :

```bash
symfony console doctrine:fixtures:load
```
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class PortfolioController extends AbstractController
{
    /**
     * Récupère tous les projets avec URLs générées
     */
    private function getProjects(): array
    {
        $projects = [
            [
                'slug' => 'perline-cookies',
                'index' => '01',
                'category' => 'E-commerce',
                'title' => 'Perline Cookies',
                'description' => "Une boutique de cookies artisanaux, du choix du produit jusqu'au paiement Stripe. Côté gérant, un dashboard pour suivre les commandes et ne jamais tomber en rupture de stock.",
                'description_en' => "An artisan cookie shop, from choosing a product all the way to Stripe payment. On the owner's side, a dashboard to track orders and never run out of stock.",
                'tags' => ['Symfony 7', 'MySQL', 'Stripe', 'Docker Compose'],
                'images' => [
                    'Capture d’écran (315).png',
                    'Capture d’écran (316).png',
                    'Capture d’écran (317).png',
                    'Capture d’écran (318).png',
                    'Capture d’écran (319).png',
                    'Capture d’écran (321).png',
                ],
                'accent' => 'sky',
                'primaryCta' => 'Visiter le site',
                'primaryCta_en' => 'Visit the site',
                'url' => 'https://perlinecookies.com/',
                'githubUrl' => 'https://github.com/Danydany140294/perline-cookies',
                'context' => "Une artisane pâtissière vendait ses cookies en direct et voulait passer à la vente en ligne. Le besoin : que les clients composent leur box et paient depuis leur téléphone en quelques minutes, et qu'elle puisse suivre ses commandes et ses stocks d'un coup d'œil. Le tout sans perdre l'univers chaleureux de sa marque.",
                'context_en' => "An artisan pastry chef was selling her cookies in person and wanted to start selling online. The need: let customers build their box and pay from their phone in a few minutes, while she can follow her orders and stock at a glance. All without losing the warm world of her brand.",
                'role' => 'Développeur full-stack, seul sur le projet : conception, back-end Symfony, paiement Stripe et mise en production',
                'role_en' => 'Full-stack developer, solo on the project: design, Symfony back-end, Stripe payment and production deployment',
                'duree' => '6 semaines',
                'duree_en' => '6 weeks',
                'objectifs' => [
    "Donner envie dès la première image : de grandes photos, une palette crème et rose fidèle à la marque",
    "Commander vite : choix d'une box de 6, 12 ou 24 cookies, puis paiement en trois étapes",
    "Penser mobile d'abord, puisque la majorité des clients commandent depuis leur téléphone",
    "Ne valider une commande qu'une fois le paiement confirmé par Stripe",
    "Donner à la gérante une vue claire de ce qu'il reste à préparer",
],
                'objectifs_en' => [
    "Make people want it from the first image: large photos, a cream and pink palette true to the brand",
    "Order quickly: choose a box of 6, 12 or 24 cookies, then pay in three steps",
    "Think mobile first, since most customers order from their phone",
    "Only validate an order once payment is confirmed by Stripe",
    "Give the owner a clear view of what is left to prepare",
],
                'demarche' => [
    ['titre' => 'Direction artistique', 'titre_en' => 'Art direction', 'texte' => "J'ai démarré avec Tailwind, puis je suis passé à du CSS écrit à la main en BEM pour garder la main sur chaque détail de la palette crème et rose.", 'texte_en' => "I started with Tailwind, then switched to hand-written BEM CSS to keep control over every detail of the cream and pink palette."],
    ['titre' => 'Modélisation des données', 'titre_en' => 'Data modeling', 'texte' => "Produits, box, commandes, adresses et utilisateurs avec Doctrine. Les box de 6, 12 ou 24 cookies ont chacune leur prix, ce qui a demandé de bien penser les relations entre entités.", 'texte_en' => "Products, boxes, orders, addresses and users with Doctrine. The boxes of 6, 12 or 24 cookies each have their own price, which required careful thinking about the relationships between entities."],
    ['titre' => "Parcours d'achat", 'titre_en' => 'Purchase journey', 'texte' => "Panier en session, connexion obligatoire avant le paiement, choix de l'adresse. J'ai corrigé plusieurs bugs de panier (quantités, suppression) pour que le parcours ne casse jamais.", 'texte_en' => "Session-based cart, mandatory login before payment, address selection. I fixed several cart bugs (quantities, removal) so the journey never breaks."],
    ['titre' => 'Paiement Stripe', 'titre_en' => 'Stripe payment', 'texte' => "Une commande n'est validée qu'une fois le paiement confirmé par un webhook signé. Un contrôle bloque les doublons si Stripe envoie deux fois la même notification.", 'texte_en' => "An order is only validated once payment is confirmed by a signed webhook. A check blocks duplicates if Stripe sends the same notification twice."],
    ['titre' => 'Sécurité et emails', 'titre_en' => 'Security and emails', 'texte' => "Connexion limitée à 5 tentatives par quart d'heure. Emails de confirmation via Symfony Mailer, après avoir réglé un conflit avec la file d'attente Messenger.", 'texte_en' => "Login limited to 5 attempts per fifteen minutes. Confirmation emails via Symfony Mailer, after resolving a conflict with the Messenger queue."],
    ['titre' => 'Mise en production', 'titre_en' => 'Going live', 'texte' => "Quatre conteneurs Docker sur un VPS Hetzner, certificat SSL renouvelé automatiquement. Je gère le serveur de bout en bout.", 'texte_en' => "Four Docker containers on a Hetzner VPS, SSL certificate renewed automatically. I manage the server end to end."],
],
                'resultats' => [
                    ['valeur' => '3 étapes', 'label' => 'jusqu\'à la commande'],
                    ['valeur' => '100 %', 'label' => 'responsive dès 360 px'],
                    ['valeur' => 'En ligne', 'label' => 'depuis 2026'],
                ],
                'apprentissages' => [
                    'Structurer une base de données e-commerce avec Doctrine',
                    'Intégrer un paiement tiers sécurisé (Stripe)',
                    'Gérer les stocks et les commandes en temps réel',
                    'Concevoir une expérience mobile efficace',
                ],
            ],
            [
                'slug' => 'dp-services',
                'index' => '02',
                'category' => 'SaaS',
                'title' => 'DP Services',
                'description' => "Application de gestion pour une activité de ménage et de conciergerie — réservations, planning d'équipe et suivi des missions.",
                'description_en' => "Management application for a cleaning and concierge business — bookings, team schedule and mission tracking.",
                'tags' => ['Symfony 7', 'MySQL', 'FullCalendar', 'Google Calendar API', 'Docker Compose'],
                'images' => [
                    'Capture d’écran (311).png',
                    'Capture d’écran (312).png',
                    'Capture d’écran (313).png',
                    'Capture d’écran (314).png',
                    'Capture d’écran (367).png',
                    'Capture d’écran (369).png',
                ],
                'accent' => 'violet',
                'primaryCta' => 'Voir le projet',
                'primaryCta_en' => 'View the project',
                'url' => 'https://dpservicessud.fr/',
                'githubUrl' => 'https://github.com/Danydany140294/DpServices',
                'context' => "Gérer une activité de ménage et de conciergerie, c'est jongler entre les appels, les messages, les tableurs et les agendas. Il fallait un seul outil pour centraliser les réservations, répartir les missions entre les salariées, suivre les interventions et tenir les propriétaires informés.",
                'context_en' => "Running a cleaning and concierge business means juggling calls, messages, spreadsheets and calendars. What was needed was a single tool to centralize bookings, assign missions to employees, track jobs and keep owners informed.",
                'role' => "Développeur full-stack et utilisateur du métier : conception, 3 espaces (admin, propriétaire, femme de ménage), Symfony 7 et FullCalendar",
                'role_en' => "Full-stack developer and industry insider: design, 3 spaces (admin, owner, cleaner), Symfony 7 and FullCalendar",
                'duree' => '12 semaines (V1 + V2 + V3)',
                'duree_en' => '12 weeks (V1 + V2 + V3)',
                'objectifs' => [
    "Remplacer les messages, les tableurs et les agendas papier par un seul outil",
    "Envoyer chaque salarié sur les missions de son secteur, sans casse-tête de planning",
    "Déplacer une mission d'un glisser-déposer, et la retrouver aussitôt dans Google Calendar",
    "Tenir salariés et propriétaires informés sans passer d'appels",
    "Voir d'un coup d'œil l'activité et le chiffre d'affaires du mois",
    "Trouver de nouveaux propriétaires à démarcher, puis suivre chaque prospect jusqu'à la signature",
],
                'objectifs_en' => [
    "Replace messages, spreadsheets and paper calendars with a single tool",
    "Send each employee to the missions in their area, without scheduling headaches",
    "Move a mission with drag and drop, and see it instantly in Google Calendar",
    "Keep employees and owners informed without making phone calls",
    "See the month's activity and revenue at a glance",
    "Find new owners to approach, then follow each prospect through to signature",
],
                'demarche' => [
    ['titre' => 'Partir du terrain', 'titre_en' => 'Starting from the field', 'texte' => "Je connais le métier de l'intérieur. J'ai listé ce qui me faisait perdre du temps au quotidien, et c'est devenu la liste des écrans prioritaires.", 'texte_en' => "I know the trade from the inside. I listed what wasted my time day to day, and that became the list of priority screens."],
    ['titre' => 'Trois espaces, trois rôles', 'titre_en' => 'Three spaces, three roles', 'texte' => "Admin, propriétaire et femme de ménage n'ont ni les mêmes besoins ni les mêmes droits. Chacun a son tableau de bord, et l'espace femme de ménage est pensé pour le téléphone, avec une navigation en bas d'écran.", 'texte_en' => "Admin, owner and cleaner have neither the same needs nor the same rights. Each has their own dashboard, and the cleaner space is designed for the phone, with navigation at the bottom of the screen."],
    ['titre' => 'Le socle', 'titre_en' => 'The foundation', 'texte' => "Authentification, utilisateurs, logements, missions, puis le planning FullCalendar où une mission se déplace au glisser-déposer.", 'texte_en' => "Authentication, users, properties, missions, then the FullCalendar schedule where a mission moves with drag and drop."],
    ['titre' => 'Le module commercial', 'titre_en' => 'The sales module', 'texte' => "Un espace réservé à l'admin pour trouver des propriétaires à démarcher, suivre chaque prospect, générer des devis et estimer le chiffre d'affaires à venir.", 'texte_en' => "A space reserved for the admin to find owners to approach, track each prospect, generate quotes and estimate upcoming revenue."],
    ['titre' => 'Google Calendar et mobile', 'titre_en' => 'Google Calendar and mobile', 'texte' => "Chaque déplacement de mission part dans Google Calendar, et une commande récupère les changements faits côté Google. L'appli s'installe sur téléphone comme une vraie application (PWA).", 'texte_en' => "Every mission move is sent to Google Calendar, and a command pulls in the changes made on the Google side. The app installs on a phone like a real application (PWA)."],
    ['titre' => 'Mise en production', 'titre_en' => 'Going live', 'texte' => "Déployée sur mon VPS Hetzner avec SSL et des tâches cron qui tournent seules. Le développement a suivi un rythme quotidien, un commit par jour de travail.", 'texte_en' => "Deployed on my Hetzner VPS with SSL and cron jobs that run on their own. Development followed a daily rhythm, one commit per working day."],
],
                'resultats' => [
                    ['valeur' => '14 entités', 'label' => 'Doctrine modélisées'],
                    ['valeur' => '3 rôles', 'label' => 'avec interfaces dédiées'],
                    ['valeur' => '200+ jours', 'label' => 'de développement itéré'],
                ],
                'apprentissages' => [
                    'Concevoir une architecture multi-tenants et multi-rôles sécurisée',
                    'Intégrer des APIs externes (Google Places, Google Calendar, Brevo)',
                    'Gérer un calendrier collaboratif complexe avec synchronisation',
                    'Mettre en production une application critique avec monitoring',
                    'Piloter un projet long avec itérations et retours utilisateurs',
                ],
                'demoAccounts' => [
    ['role' => 'Admin', 'role_en' => 'Admin', 'label' => "Le compte le plus complet : planning, équipe et module commercial", 'email' => 'admin@dpservices.fr', 'password' => 'Demo1234!'],
    ['role' => 'Propriétaire', 'role_en' => 'Owner', 'label' => "Ce que voit un client qui confie ses logements", 'email' => 'proprietaire1@dpservices.fr', 'password' => 'Demo1234!'],
    ['role' => 'Femme de ménage', 'role_en' => 'Cleaner', 'label' => "L'appli côté terrain, à ouvrir sur téléphone", 'email' => 'menage1@dpservices.fr', 'password' => 'Demo1234!'],
],
            ],
        ];

        // Ajouter les URLs générées à chaque projet
        foreach ($projects as &$project) {
            $project['projectUrl'] = '/projets/' . $project['slug'];
        }

        return $projects;
    }

    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('home/index.html.twig', [
            'projects' => $this->getProjects(),
            'parcours' => [
                [
                    'periode' => 'Septembre 2023 — Juillet 2024',
                    'periode_en' => 'September 2023 — July 2024',
                    'titre' => 'Titre Professionnel Développeur Web & Mobile',
                    'titre_en' => 'Professional Title: Web & Mobile Developer',
                    'sous' => 'Niveau 5 (Bac+2) · Ecole Beweb, Montpellier',
                    'sous_en' => 'Level 5 (2-year degree) · Beweb School, Montpellier',
                    'texte' => 'Formation intensive en développement front-end et back-end, gestion de projets agiles, bonnes pratiques et sécurité web.',
                    'texte_en' => 'Intensive training in front-end and back-end development, agile project management, best practices and web security.',
                ],
                [
                    'periode' => 'Juillet — Octobre 2024',
                    'periode_en' => 'July — October 2024',
                    'titre' => 'Recherche d\'une première opportunité en développement',
                    'titre_en' => 'Looking for a first opportunity in development',
                    'sous' => 'Phase de transition professionnelle',
                    'sous_en' => 'Career transition phase',
                    'texte' => 'Période de recherche active pour débuter une carrière en développement web.',
                    'texte_en' => 'Active search period to start a career in web development.',
                ],
                [
                    'periode' => 'Novembre 2024 — Aujourd\'hui',
                    'periode_en' => 'November 2024 — Today',
                    'titre' => 'Chargé de coordination des visites médicales et auditeur',
                    'titre_en' => 'Medical visit coordinator and auditor',
                    'sous' => 'OFII · Montpellier',
                    'texte' => "Chargé de coordination à l'OFII : planning, suivi de dossiers et relation avec le public. En parallèle, développement de 2 projets complets le soir et les week-ends : Perline Cookies et DP Services Sud.",
                    'texte_en' => "Coordination officer at OFII: scheduling, case follow-up and public relations. In parallel, development of 2 complete projects in the evenings and on weekends: Perline Cookies and DP Services Sud.",
                ],
                [
                    'periode' => 'Aujourd\'hui',
                    'periode_en' => 'Today',
                    'titre' => 'À la recherche d\'une opportunité en développement web',
                    'titre_en' => 'Looking for a web development opportunity',
                    'sous' => 'CDI, CDD ou freelance · À distance ou Montpellier',
                    'sous_en' => 'Permanent, fixed-term or freelance · Remote or Montpellier',
'texte' => "Ouvert à un poste en CDI ou CDD, ou à des missions freelance. Deux projets en production, présentés ci-dessus.",
                    'texte_en' => "Open to a permanent or fixed-term position, or to freelance assignments. Two projects in production, presented above.",
                ],
            ],
            'skills' => [
                [
                    'categorie' => 'Back-end',
                    'accent' => 'violet',
                    'items' => [
                        ['nom' => 'PHP 8', 'note' => "Mon langage principal, utilisé sur tous mes projets en programmation orientée objet.", 'note_en' => "My main language, used on all my projects with object-oriented programming."],
['nom' => 'Symfony 7', 'note' => "Le framework de Perline Cookies et DP Services : Doctrine, formulaires, sécurité, rôles et événements.", 'note_en' => "The framework behind Perline Cookies and DP Services: Doctrine, forms, security, roles and events."],
['nom' => 'MySQL', 'note' => "Des bases pensées pour de vrais usages : commandes, stocks, réservations, plannings.", 'note_en' => "Databases designed for real-world use: orders, stock, bookings, schedules."],
['nom' => 'Redis', 'note' => "Cache et sessions pour garder l'application rapide.", 'note_en' => "Cache and sessions to keep the application fast."],
['nom' => 'Docker Compose', 'note' => "Le même environnement en local et en production, sans surprise au déploiement.", 'note_en' => "The same environment locally and in production, with no surprises at deployment."],
                    ]
                ],
                [
                    'categorie' => 'Front-end',
                    'accent' => 'sky',
                    'items' => [
                       ['nom' => 'HTML5', 'note' => "Des pages bien structurées, lisibles par tous, y compris les lecteurs d'écran.", 'note_en' => "Well-structured pages, readable by everyone, including screen readers."],
['nom' => 'CSS3', 'note' => "Des interfaces pensées mobile d'abord, avec Flexbox, Grid et quelques animations bien placées.", 'note_en' => "Mobile-first interfaces, with Flexbox, Grid and a few well-placed animations."],
['nom' => 'JavaScript (ES6+)', 'note' => "Ce qu'il faut pour rendre l'interface vivante : DOM, fetch, carrousels et thème clair/sombre.", 'note_en' => "What it takes to bring the interface to life: DOM, fetch, carousels and light/dark theme."],
['nom' => 'Twig', 'note' => "Des templates découpés en blocs réutilisables, pour ne jamais écrire deux fois la même chose.", 'note_en' => "Templates split into reusable blocks, so I never write the same thing twice."],
['nom' => 'FullCalendar', 'note' => "Le planning de DP Services : les missions se déplacent au glisser-déposer.", 'note_en' => "The DP Services schedule: missions move with drag and drop."],
                    ]
                ],
                [
                    'categorie' => 'APIs & Services',
                    'accent' => 'coral',
                    'items' => [
                        ['nom' => 'Stripe', 'note' => "Le paiement de Perline Cookies, avec un webhook qui valide la commande seulement une fois l'argent reçu.", 'note_en' => "Perline Cookies payment, with a webhook that validates the order only once the money is received."],
['nom' => 'Google Places API', 'note' => "Des adresses saisies en quelques lettres, sans fautes, pour que les salariés trouvent le bon endroit.", 'note_en' => "Addresses entered in a few letters, without typos, so employees find the right place."],
['nom' => 'Google Calendar API', 'note' => "Les missions de DP Services arrivent directement dans l'agenda de chacun.", 'note_en' => "DP Services missions arrive directly in everyone's calendar."],
['nom' => 'Brevo', 'note' => "Tous les emails automatiques de mes projets : confirmations, notifications et formulaire de contact.", 'note_en' => "All the automatic emails of my projects: confirmations, notifications and contact form."],
['nom' => 'Claude API (Anthropic)', 'note' => "Au cœur de DANY AI, mon projet en cours d'aide à la recherche d'emploi.", 'note_en' => "At the heart of DANY AI, my ongoing job-search assistance project."],
                    ]
                ],
                [
                    'categorie' => 'Outils & Workflows',
                    'categorie_en' => 'Tools & Workflows',
                    'accent' => 'sky',
                    'items' => [
                        ['nom' => 'Git & GitHub', 'note' => "Tous mes projets sont versionnés, du premier commit à la mise en production.", 'note_en' => "All my projects are versioned, from the first commit to production."],
['nom' => 'Figma', 'note' => "Je dessine les écrans avant de les coder, pour savoir où je vais.", 'note_en' => "I design the screens before coding them, so I know where I'm going."],
['nom' => 'Hébergement Hetzner', 'note' => "Mes sites tournent sur mon propre VPS : déploiement, SSL, crons et mises à jour, je gère tout.", 'note_en' => "My sites run on my own VPS: deployment, SSL, crons and updates, I handle everything."],
]
                ],
            ],
            'methode' => [
                [
                    'num' => '01',
                    'titre' => 'Comprendre le besoin',
                    'texte' => 'Écouter sans juger, reformuler, explorer avant d\'écrire la première ligne de code.',
                ],
                [
                    'num' => '02',
                    'titre' => 'Concevoir avec des wireframes',
                    'texte' => 'Maquetter vite pour valider les parcours, le vocabulaire métier et les interactions clés.',
                ],
                [
                    'num' => '03',
                    'titre' => 'Développer une solution fiable',
                    'texte' => 'Code lisible, structuré et testable. Pensé pour durer et facile à maintenir.',
                ],
                [
                    'num' => '04',
                    'titre' => 'Tester et itérer',
                    'texte' => 'Mesurer les résultats, recueillir les retours utilisateurs et améliorer les détails progressivement.',
                ],
            ],
        ]);
    }

    #[Route('/projets/{slug}', name: 'project_show', methods: ['GET'])]
    public function projectShow(string $slug): Response
    {
        $allProjects = $this->getProjects();
        
        // Chercher le projet
        $project = null;
        foreach ($allProjects as $p) {
            if ($p['slug'] === $slug) {
                $project = $p;
                break;
            }
        }

        if (!$project) {
            throw $this->createNotFoundException('Projet introuvable.');
        }

        // Chercher le projet suivant
        $projectSlugs = array_column($allProjects, 'slug');
        $currentIndex = array_search($slug, $projectSlugs, true);
        $nextSlug = $projectSlugs[$currentIndex + 1] ?? null;

        $other = null;
        if ($nextSlug !== null) {
            foreach ($allProjects as $p) {
                if ($p['slug'] === $nextSlug) {
                    $other = $p;
                    break;
                }
            }
        }

        return $this->render('project/show.html.twig', [
            'project' => $project,
            'other' => $other,
        ]);
    }

    #[Route('/contact', name: 'app_contact', methods: ['POST'])]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        if (!$this->isCsrfTokenValid('contact', (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Session expirée, merci de réessayer.');
            return $this->redirectToRoute('app_home', ['_fragment' => 'contact']);
        }

        $nom = trim((string) $request->request->get('nom'));
        $emailVisiteur = trim((string) $request->request->get('email'));
        $sujet = trim((string) $request->request->get('sujet'));
        $message = trim((string) $request->request->get('message'));

        if ($nom === '' || $sujet === '' || $message === '' || !filter_var($emailVisiteur, FILTER_VALIDATE_EMAIL)) {
            $this->addFlash('error', 'Merci de remplir correctement tous les champs.');
            return $this->redirectToRoute('app_home', ['_fragment' => 'contact']);
        }

        $email = (new Email())
            ->from('dany140294@hotmail.com')
            ->to('dany140294@hotmail.com')
            ->replyTo($emailVisiteur)
            ->subject('[Portfolio] ' . $sujet)
            ->text("De : $nom ($emailVisiteur)\n\n$message");

        $mailer->send($email);
        $this->addFlash('success', 'Message envoyé, merci ! Je reviens vers vous rapidement.');

        return $this->redirectToRoute('app_home', ['_fragment' => 'contact']);
    }
}
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
                'url' => 'https://perlinecookies.com/',
                'githubUrl' => 'https://github.com/Danydany140294/Creaself',
                'context' => "Une artisane pâtissière vendait ses cookies en direct et voulait passer à la vente en ligne. Le besoin : que les clients composent leur box et paient depuis leur téléphone en quelques minutes, et qu'elle puisse suivre ses commandes et ses stocks d'un coup d'œil. Le tout sans perdre l'univers chaleureux de sa marque.",
                'role' => 'Développeur full-stack, seul sur le projet : conception, back-end Symfony, paiement Stripe et mise en production',
                'duree' => '6 semaines',
                'objectifs' => [
    "Donner envie dès la première image : de grandes photos, une palette crème et rose fidèle à la marque",
    "Commander vite : choix d'une box de 6, 12 ou 24 cookies, puis paiement en trois étapes",
    "Penser mobile d'abord, puisque la majorité des clients commandent depuis leur téléphone",
    "Ne valider une commande qu'une fois le paiement confirmé par Stripe",
    "Donner à la gérante une vue claire de ce qu'il reste à préparer",
],
                'demarche' => [
    ['titre' => 'Direction artistique', 'texte' => "J'ai démarré avec Tailwind, puis je suis passé à du CSS écrit à la main en BEM pour garder la main sur chaque détail de la palette crème et rose."],
    ['titre' => 'Modélisation des données', 'texte' => "Produits, box, commandes, adresses et utilisateurs avec Doctrine. Les box de 6, 12 ou 24 cookies ont chacune leur prix, ce qui a demandé de bien penser les relations entre entités."],
    ['titre' => "Parcours d'achat", 'texte' => "Panier en session, connexion obligatoire avant le paiement, choix de l'adresse. J'ai corrigé plusieurs bugs de panier (quantités, suppression) pour que le parcours ne casse jamais."],
    ['titre' => 'Paiement Stripe', 'texte' => "Une commande n'est validée qu'une fois le paiement confirmé par un webhook signé. Un contrôle bloque les doublons si Stripe envoie deux fois la même notification."],
    ['titre' => 'Sécurité et emails', 'texte' => "Connexion limitée à 5 tentatives par quart d'heure. Emails de confirmation via Symfony Mailer, après avoir réglé un conflit avec la file d'attente Messenger."],
    ['titre' => 'Mise en production', 'texte' => "Quatre conteneurs Docker sur un VPS Hetzner, certificat SSL renouvelé automatiquement. Je gère le serveur de bout en bout."],
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
                'description' => "Application de gestion pour une activité de ménage et de conciergerie  réservations, planning d'équipe et suivi des missions.",
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
                'url' => 'https://dpservicessud.fr/',
                'githubUrl' => 'https://github.com/Danydany140294/DpServices',
                'context' => "Gérer une activité de ménage et de conciergerie, c'est jongler entre les appels, les messages, les tableurs et les agendas. Il fallait un seul outil pour centraliser les réservations, répartir les missions entre les salariées, suivre les interventions et tenir les propriétaires informés.",
                'role' => "Développeur full-stack et utilisateur du métier : conception, 3 espaces (admin, propriétaire, femme de ménage), Symfony 7 et FullCalendar",
                'duree' => '12 semaines (V1 + V2 + V3)',
                'objectifs' => [
    "Remplacer les messages, les tableurs et les agendas papier par un seul outil",
    "Envoyer chaque salarié sur les missions de son secteur, sans casse-tête de planning",
    "Déplacer une mission d'un glisser-déposer, et la retrouver aussitôt dans Google Calendar",
    "Tenir salariés et propriétaires informés sans passer d'appels",
    "Voir d'un coup d'œil l'activité et le chiffre d'affaires du mois",
    "Trouver de nouveaux propriétaires à démarcher, puis suivre chaque prospect jusqu'à la signature",
],
                'demarche' => [
    ['titre' => 'Partir du terrain', 'texte' => "Je connais le métier de l'intérieur. J'ai listé ce qui me faisait perdre du temps au quotidien, et c'est devenu la liste des écrans prioritaires."],
    ['titre' => 'Trois espaces, trois rôles', 'texte' => "Admin, propriétaire et femme de ménage n'ont ni les mêmes besoins ni les mêmes droits. Chacun a son tableau de bord, et l'espace femme de ménage est pensé pour le téléphone, avec une navigation en bas d'écran."],
    ['titre' => 'Le socle', 'texte' => "Authentification, utilisateurs, logements, missions, puis le planning FullCalendar où une mission se déplace au glisser-déposer."],
    ['titre' => 'Le module commercial', 'texte' => "Un espace réservé à l'admin pour trouver des propriétaires à démarcher, suivre chaque prospect, générer des devis et estimer le chiffre d'affaires à venir."],
    ['titre' => 'Google Calendar et mobile', 'texte' => "Chaque déplacement de mission part dans Google Calendar, et une commande récupère les changements faits côté Google. L'appli s'installe sur téléphone comme une vraie application (PWA)."],
    ['titre' => 'Mise en production', 'texte' => "Déployée sur mon VPS Hetzner avec SSL et des tâches cron qui tournent seules. Le développement a suivi un rythme quotidien, un commit par jour de travail."],
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
    ['role' => 'Admin', 'label' => "Le compte le plus complet : planning, équipe et module commercial", 'email' => 'admin@dpservices.fr', 'password' => 'Demo1234!'],
    ['role' => 'Propriétaire', 'label' => "Ce que voit un client qui confie ses logements", 'email' => 'proprietaire1@dpservices.fr', 'password' => 'Demo1234!'],
    ['role' => 'Femme de ménage', 'label' => "L'appli côté terrain, à ouvrir sur téléphone", 'email' => 'menage1@dpservices.fr', 'password' => 'Demo1234!'],
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
                    'titre' => 'Titre Professionnel Développeur Web & Mobile',
                    'sous' => 'Niveau 5 (Bac+2) · Ecole Beweb, Montpellier',
                    'texte' => 'Formation intensive en développement front-end et back-end, gestion de projets agiles, bonnes pratiques et sécurité web.',
                ],
                [
                    'periode' => 'Juillet — Octobre 2024',
                    'titre' => 'Recherche d\'une première opportunité en développement',
                    'sous' => 'Phase de transition professionnelle',
                    'texte' => 'Période de recherche active pour débuter une carrière en développement web.',
                ],
                [
                    'periode' => 'Novembre 2024 — Aujourd\'hui',
                    'titre' => 'Chargé de coordination des visites médicales et auditeur ',
                    'sous' => 'OFII · Montpellier',
                    'texte' => "Chargé de coordination à l'OFII : planning, suivi de dossiers et relation avec le public. En parallèle, développement de 2 projets complets le soir et les week-ends : Perline Cookies et DP Services Sud.",
                ],
                [
                    'periode' => 'Aujourd\'hui',
                    'titre' => 'À la recherche d\'une opportunité en développement web',
                    'sous' => 'CDI, CDD ou freelance · À distance ou Montpellier',
'texte' => "Ouvert à un poste en CDI ou CDD, ou à des missions freelance. Deux projets en production, présentés ci-dessus.",
                ],
            ],
            'skills' => [
                [
                    'categorie' => 'Back-end',
                    'accent' => 'violet',
                    'items' => [
                        ['nom' => 'PHP 8', 'note' => "Mon langage principal, utilisé sur tous mes projets en programmation orientée objet."],
['nom' => 'Symfony 7', 'note' => "Le framework de Perline Cookies et DP Services : Doctrine, formulaires, sécurité, rôles et événements."],
['nom' => 'MySQL', 'note' => "Des bases pensées pour de vrais usages : commandes, stocks, réservations, plannings."],
['nom' => 'Redis', 'note' => "Cache et sessions pour garder l'application rapide."],
['nom' => 'Docker Compose', 'note' => "Le même environnement en local et en production, sans surprise au déploiement."],
                    ]
                ],
                [
                    'categorie' => 'Front-end',
                    'accent' => 'sky',
                    'items' => [
                       ['nom' => 'HTML5', 'note' => "Des pages bien structurées, lisibles par tous, y compris les lecteurs d'écran."],
['nom' => 'CSS3', 'note' => "Des interfaces pensées mobile d'abord, avec Flexbox, Grid et quelques animations bien placées."],
['nom' => 'JavaScript (ES6+)', 'note' => "Ce qu'il faut pour rendre l'interface vivante : DOM, fetch, carrousels et thème clair/sombre."],
['nom' => 'Twig', 'note' => "Des templates découpés en blocs réutilisables, pour ne jamais écrire deux fois la même chose."],
['nom' => 'FullCalendar', 'note' => "Le planning de DP Services : les missions se déplacent au glisser-déposer."],
                    ]
                ],
                [
                    'categorie' => 'APIs & Services',
                    'accent' => 'coral',
                    'items' => [
                        ['nom' => 'Stripe', 'note' => "Le paiement de Perline Cookies, avec un webhook qui valide la commande seulement une fois l'argent reçu."],
['nom' => 'Google Places API', 'note' => "Des adresses saisies en quelques lettres, sans fautes, pour que les salariés trouvent le bon endroit."],
['nom' => 'Google Calendar API', 'note' => "Les missions de DP Services arrivent directement dans l'agenda de chacun."],
['nom' => 'Brevo', 'note' => "Tous les emails automatiques de mes projets : confirmations, notifications et formulaire de contact."],
['nom' => 'Claude API (Anthropic)', 'note' => "Au cœur de DANY AI, mon projet en cours d'aide à la recherche d'emploi."],
                    ]
                ],
                [
                    'categorie' => 'Outils & Workflows',
                    'accent' => 'sky',
                    'items' => [
                        ['nom' => 'Git & GitHub', 'note' => "Tous mes projets sont versionnés, du premier commit à la mise en production."],
['nom' => 'Figma', 'note' => "Je dessine les écrans avant de les coder, pour savoir où je vais."],
['nom' => 'Hébergement Hetzner', 'note' => "Mes sites tournent sur mon propre VPS : déploiement, SSL, crons et mises à jour, je gère tout."],
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
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
                'tags' => ['Docker Compose', 'Symfony', 'Stripe'],
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
                'context' => 'Une artisane pâtissière souhaitait vendre ses cookies en ligne sans perdre la chaleur de son identité. L\'enjeu : une boutique appétissante, fluide et sécurisée du mobile au desktop.',
                'role' => 'Conception UX, modélisation de la base, développement Symfony complet, intégration Stripe',
                'duree' => '12 semaines',
                'objectifs' => [
                    'Mettre les produits en valeur avec une photographie généreuse',
                    'Réduire le nombre d\'étapes jusqu\'au panier',
                    'Garantir une expérience mobile impeccable',
                    'Intégrer un paiement sécurisé avec Stripe',
                ],
                'demarche' => [
                    ['titre' => 'Direction artistique', 'texte' => 'Palette chaleureuse, typographie éditoriale, grille aérée pour laisser respirer les visuels du produit.'],
                    ['titre' => 'Modélisation données', 'texte' => 'Entités Produits, catégories, variantes, stocks et commandes avec Doctrine.'],
                    ['titre' => 'Parcours e-commerce', 'texte' => 'Tunnel court en trois étapes, panier persistant en session, validation côté serveur.'],
                    ['titre' => 'Intégration Stripe', 'texte' => 'Paiement sécurisé, confirmation email automatique, gestion des erreurs de transaction.'],
                    ['titre' => 'Dashboard commandes', 'texte' => 'Suivi des commandes en temps réel, gestion des stocks, export de bons de préparation.'],
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
                'description' => "Née de mon activité dans le ménage, cette plateforme gère les réservations de A à Z : attribution des missions, planning partagé, notifications en temps réel et un espace dédié à chaque rôle.",
                'tags' => ['Symfony 7', 'PostgreSQL', 'Docker'],
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
                'context' => 'Une auto-entrepreneuse en conciergerie et ménage jonglait entre appels, emails et tableurs. L\'objectif : centraliser les réservations, allouer les missions, suivre les interventions et garder le contrôle.',
                'role' => 'Conception UX/UI, modélisation complète (3 rôles), développement Symfony 7, intégration FullCalendar',
                'duree' => '24 semaines (V1 + V2 + V3)',
                'objectifs' => [
                    'Centraliser les réservations et les clients dans une source unique',
                    'Allouer les missions automatiquement selon les secteurs',
                    'Offrir un calendrier collaboratif temps réel',
                    'Notifier les salariés et les propriétaires en continu',
                    'Générer des reports et des analyses de chiffre d\'affaires',
                    'Offrir aux administrateurs un espace de prospection commerciale : recherche, qualification et suivi des prospects',
                ],
                'demarche' => [
                    ['titre' => 'Cadrage et entretiens', 'texte' => 'Cartographie des tâches réelles, identification des flux de travail, priorisation des écrans critiques.'],
                    ['titre' => 'Architecture multi-rôles', 'texte' => 'Design des 3 interfaces (Admin, Propriétaire, Salariée) avec permissions granulaires et sécurité.'],
                    ['titre' => 'Développement V1 ', 'texte' => 'Authentification, CRUD utilisateurs, entités métier, FullCalendar, dashboard par rôle.'],
                    ['titre' => 'Développement V2 ', 'texte' => 'Module Acquisition réservé aux administrateurs : recherche et qualification de prospects, scoring automatique, pipeline de suivi commercial, génération de devis et dashboard avec estimation du chiffre d\'affaires potentiel.'],
                    ['titre' => 'Développement V3 ', 'texte' => 'Synchronisation Google Calendar, notifications push, PWA, robustesse et monitoring.'],
                    ['titre' => 'Déploiement & monitoring', 'texte' => 'Déploiement sur Hetzner, SSL, crons automatisés, logging complet des actions.'],
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
                    ['role' => 'Admin', 'label' => 'Vue globale, gestion complète', 'email' => 'admin@dpservices.fr', 'password' => 'Demo1234!'],
                    ['role' => 'Propriétaire', 'label' => 'Suivi de ses logements', 'email' => 'proprietaire1@dpservices.fr', 'password' => 'Demo1234!'],
                    ['role' => 'Femme de ménage', 'label' => 'Missions assignées', 'email' => 'menage1@dpservices.fr', 'password' => 'Demo1234!'],
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
                    'titre' => 'Auditeur (CDI Fonctionnaire)',
                    'sous' => 'OFII · Montpellier',
                    'texte' => "Chargé de coordination à l'OFII : planning, suivi de dossiers et relation avec le public. En parallèle, développement de 2 projets complets le soir et les week-ends : Perline Cookies et DP Services Sud.",
                ],
                [
                    'periode' => 'Aujourd\'hui',
                    'titre' => 'À la recherche d\'une opportunité en développement web',
                    'sous' => 'Junior ou CDI · À distance ou Montpellier',
                    'texte' => 'Ouvert aux postes , CDD, CDI ou missions freelance. Portfolio actif avec 2 projets en production.',
                ],
            ],
            'skills' => [
                [
                    'categorie' => 'Back-end',
                    'accent' => 'violet',
                    'items' => [
                        ['nom' => 'PHP 8', 'note' => "Mon langage principal, utilisé sur tous mes projets en programmation orientée objet."],
['nom' => 'Symfony 7', 'note' => "Le framework de Perline Cookies et DP Services : Doctrine, formulaires, sécurité, rôles et événements."],
['nom' => 'PostgreSQL', 'note' => "Des bases pensées pour de vrais usages : commandes, stocks, réservations, plannings."],
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
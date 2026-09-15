<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
                'description' => 'Boutique e-commerce de cookies artisanaux. Catalogue produits, panier, commandes avec confirmation email, paiement Stripe, gestion des stocks, dashboard de suivi commandes.',
                'tags' => ['Docker Compose', 'Symfony', 'Stripe'],
                'images' => [
                    'Capture d’écran (219).png',
                    'Capture d’écran (224).png',
                    'Capture d’écran (230).png',
                ],
                'accent' => 'sky',
                'primaryCta' => 'Visiter le site',
                'url' => 'https://perlinecookies.com/',
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
                'description' => 'Plateforme SaaS pour gérer les réservations de ménage et conciergerie. Allocation des missions aux salariés, calendrier collaboratif, notifications temps réel, gestion multi-rôles et suivi client complet.',
                'tags' => ['Symfony 7', 'PostgreSQL', 'Docker'],
                'images' => [
                    'Capture d’écran (196).png',
                    'Capture d’écran (202).png',
                    'Capture d’écran (217).png',
                ],
                'accent' => 'violet',
                'primaryCta' => 'Voir le projet',
                'url' => 'https://dpservicessud.fr/',
                'context' => 'Une auto-entrepreneuse en conciergerie et ménage jonglait entre appels, emails et tableurs. L\'objectif : centraliser les réservations, allouer les missions, suivre les interventions et garder le contrôle.',
                'role' => 'Conception UX/UI, modélisation complète (3 rôles), développement Symfony 7, intégration FullCalendar',
                'duree' => '24 semaines (V1 + V2 + V3)',
                'objectifs' => [
                    'Centraliser les réservations et les clients dans une source unique',
                    'Allouer les missions automatiquement selon les secteurs',
                    'Offrir un calendrier collaboratif temps réel',
                    'Notifier les salariés et les propriétaires en continu',
                    'Générer des reports et des analyses de chiffre d\'affaires',
                ],
                'demarche' => [
                    ['titre' => 'Cadrage et entretiens', 'texte' => 'Cartographie des tâches réelles, identification des flux de travail, priorisation des écrans critiques.'],
                    ['titre' => 'Architecture multi-rôles', 'texte' => 'Design des 3 interfaces (Admin, Propriétaire, Salariée) avec permissions granulaires et sécurité.'],
                    ['titre' => 'Développement V1 ', 'texte' => 'Authentification, CRUD utilisateurs, entités métier, FullCalendar, dashboard par rôle.'],
                    ['titre' => 'Développement V2 ', 'texte' => 'Module Acquisition avec CRM, Google Places API, scoring automatique, génération de devis.'],
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
                    'periode' => 'Juillet 2024',
                    'titre' => 'Titre Professionnel Développeur Web & Mobile',
                    'sous' => 'Niveau 5 (Bac+2) · Ecole Travis, Montpellier',
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
                    'texte' => 'Poste administratif à temps plein. En parallèle, développement de 2 projets complets le soir et les weekends : Perline Cookies et DP Services Sud.',
                ],
                [
                    'periode' => 'Aujourd\'hui',
                    'titre' => 'À la recherche d\'une opportunité en développement web',
                    'sous' => 'Junior ou CDI · À distance ou Montpellier',
                    'texte' => 'Ouvert aux postes junior, CDD, CDI ou missions freelance. Portfolio actif avec 2 projets en production.',
                ],
            ],
            'skills' => [
                [
                    'categorie' => 'Back-end',
                    'accent' => 'violet',
                    'items' => [
                        ['nom' => 'PHP 8.3', 'note' => 'POO avancée, patterns SOLID et sécurité des formulaires.'],
                        ['nom' => 'Symfony 7', 'note' => 'Contrôleurs, Doctrine, formulaires, sécurité, services, événements et middlewares.'],
                        ['nom' => 'PostgreSQL', 'note' => 'Modélisation relationnelle avancée, optimisation et migrations Doctrine.'],
                        ['nom' => 'Redis', 'note' => 'Cache applicatif, sessions et gestion des jobs asynchrones.'],
                        ['nom' => 'Docker Compose', 'note' => 'Orchestration multi-conteneurs (PHP, Nginx, PostgreSQL, Redis).'],
                    ]
                ],
                [
                    'categorie' => 'Front-end',
                    'accent' => 'sky',
                    'items' => [
                        ['nom' => 'HTML5', 'note' => 'Structure sémantique, accessibilité et standards web modernes.'],
                        ['nom' => 'CSS3', 'note' => 'Flexbox, Grid, design responsive, animations et performance.'],
                        ['nom' => 'JavaScript (ES6+)', 'note' => 'DOM, fetch, interactions légères et intégration d\'APIs.'],
                        ['nom' => 'Twig', 'note' => 'Templates dynamiques réutilisables, blocs et système de composants.'],
                        ['nom' => 'FullCalendar', 'note' => 'Calendrier collaboratif, drag-drop et synchronisation temps réel.'],
                    ]
                ],
                [
                    'categorie' => 'APIs & Services',
                    'accent' => 'coral',
                    'items' => [
                        ['nom' => 'Stripe', 'note' => 'Paiement en ligne sécurisé, gestion des abonnements et webhook.'],
                        ['nom' => 'Google Places API', 'note' => 'Recherche de lieux, géolocalisation et enrichissement de données.'],
                        ['nom' => 'Google Calendar API', 'note' => 'Synchronisation bidirectionnelle, gestion des événements calendrier.'],
                        ['nom' => 'Brevo (ex-Sendinblue)', 'note' => 'Envoi d\'emails et SMS transactionnels, campagnes marketing.'],
                        ['nom' => 'Claude AI (Anthropic)', 'note' => 'Génération de contenu, résumés assistés et prototypage UX.'],
                    ]
                ],
                [
                    'categorie' => 'Outils & Workflows',
                    'accent' => 'sky',
                    'items' => [
                        ['nom' => 'Git & GitHub', 'note' => 'Branches, commits sémantiques, pull requests et collaboration.'],
                        ['nom' => 'Figma', 'note' => 'Wireframes, maquettes haute fidélité, design systems et prototypes.'],
                        ['nom' => 'Hébergement Hetzner', 'note' => 'Déploiement VPS, SSL/TLS, monitoring et maintenance serveur.'],
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
    public function contact(Request $request): Response
    {
        if (!$this->isCsrfTokenValid('contact', (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Session expirée, merci de réessayer.');
            return $this->redirectToRoute('app_home', ['_fragment' => 'contact']);
        }

        $nom = trim((string) $request->request->get('nom'));
        $email = trim((string) $request->request->get('email'));
        $sujet = trim((string) $request->request->get('sujet'));
        $message = trim((string) $request->request->get('message'));

        if ($nom === '' || $sujet === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addFlash('error', 'Merci de remplir correctement tous les champs.');
            return $this->redirectToRoute('app_home', ['_fragment' => 'contact']);
        }

        // TODO : envoyer l'e-mail avec symfony/mailer (MailerInterface) ou enregistrer en base.
        $this->addFlash('success', 'Message envoyé, merci ! Je reviens vers vous rapidement.');

        return $this->redirectToRoute('app_home', ['_fragment' => 'contact']);
    }
}
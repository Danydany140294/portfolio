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
                'slug' => 'dany-ai',
                'index' => '01',
                'category' => 'SaaS · IA',
                'category_en' => 'SaaS · AI',
                'title' => 'DANY AI',
                'description' => "Une application qui lit les offres à ma place, note chacune sur 100 en expliquant pourquoi, prépare mes candidatures et m'entraîne aux entretiens. Pensée pour le téléphone.",
                'description_en' => "An app that reads job offers for me, scores each one out of 100 and explains why, prepares my applications and trains me for interviews. Designed for the phone.",
                'tags' => ['Symfony 7', 'PostgreSQL', 'API Claude', 'PWA', 'Docker Compose'],
                // Texte d'accroche de la page d'étude de cas (différent de la carte d'accueil).
                'intro' => "Je cherchais un poste et je perdais mes journées à trier des annonces. J'ai construit l'outil que je voulais : il fait le tri, explique chaque note, prépare le dossier et ne décide jamais à ma place.",
                'intro_en' => "I was looking for a job and losing whole days sorting postings. So I built the tool I wanted: it does the sorting, explains every score, prepares the application and never decides for me.",
                // Captures au format téléphone (portrait), toutes en données fictives.
                // Tes fichiers : 1 dashboard · 2 candidatures · 3 offres · 4 fiche offre
                //                5 scoring · 6 envoi e-mail · 7 menu Plus · 8 coach d'entretien
                // L'ordre ci-dessous suit les légendes (imageAlts) : ne change l'un qu'avec l'autre.
                'images' => [
                    '1.jpg', // dashboard
                    '3.jpg', // offres triées
                    '4.jpg', // fiche offre
                    '5.jpg', // scoring
                    '6.jpg', // envoi e-mail
                    '2.jpg', // candidatures
                    '8.jpg', // coach d'entretien
                    '7.jpg', // menu Plus
                ],
                'imageFormat' => 'portrait',
                // Versions légères (480 px) pour les 3 téléphones de la carte d'accueil : gauche, centre, droite.
                // Les images pleine taille servent au carrousel de l'étude de cas.
                'cardImages' => [
                    'dany-ai-card-offres.webp',
                    'dany-ai-card-dashboard.webp',
                    'dany-ai-card-scoring.webp',
                ],
                'imageAlts' => [
                    "Tableau de bord : l'essentiel d'un coup d'œil",
                    "Les offres triées par score",
                    "Une fiche offre avec son « Très bon match »",
                    "Comment le score de 96 est calculé",
                    "Envoi par e-mail : CV adapté et lettre générée, relus avant envoi",
                    "Mes candidatures et leur état d'avancement",
                    "Coach d'entretien : une question à la fois",
                    "Menu des outils",
                ],
                'imageAlts_en' => [
                    "Dashboard: the essentials at a glance",
                    "Offers ranked by score",
                    "An offer page with its \"Very good match\"",
                    "How the score of 96 is computed",
                    "Email sending: tailored CV and generated letter, reviewed before sending",
                    "My applications and their progress",
                    "Interview coach: one question at a time",
                    "Tools menu",
                ],
                'accent' => 'coral',
                // Pas de site public : l'app réelle contient des données personnelles.
                // Le template doit masquer le bouton principal quand 'url' est null.
                'primaryCta' => null,
                'primaryCta_en' => null,
                'url' => null,
                // Dépôt non publié : le bouton « Voir le code » est masqué tant que githubUrl est null.
                'githubUrl' => null,
                'context' => "Chercher un poste, c'est lire des dizaines d'annonces pour n'en garder que quelques-unes. Les scores des plateformes sont opaques, et le suivi des candidatures finit dans un tableur oublié. Je voulais un outil qui trie à ma place, qui justifie ses choix, et qui relance au bon moment.",
                'context_en' => "Job hunting means reading dozens of postings to keep only a few. Platform scores are opaque, and application tracking ends up in a forgotten spreadsheet. I wanted a tool that ranks for me, justifies its choices, and follows up at the right time.",
                'role' => 'Concepteur et développeur : du besoin à la mise en ligne, avec Claude Code comme assistant. Symfony 7, scoring explicable, API Claude',
                'role_en' => 'Designer and developer: from need to launch, with Claude Code as an assistant. Symfony 7, explainable scoring, Claude API',
                'duree' => '6 semaines',
                'duree_en' => '6 weeks',
                'objectifs' => [
                    "Trier les offres à ma place, avec un score que je peux comprendre et contester",
                    "Préparer une candidature en quelques minutes : CV adapté, lettre générée et modifiable",
                    "Ne jamais rien envoyer sans ma validation",
                    "Suivre chaque candidature et programmer les relances",
                    "M'entraîner aux entretiens, à l'écrit ou à la voix",
                    "Utiliser l'application depuis mon iPhone, partout",
                ],
                'objectifs_en' => [
                    "Rank offers for me, with a score I can understand and challenge",
                    "Prepare an application in minutes: tailored CV, generated and editable letter",
                    "Never send anything without my approval",
                    "Track every application and schedule follow-ups",
                    "Practice interviews, typed or spoken",
                    "Use the application from my iPhone, anywhere",
                ],
                'demarche' => [
                    ['titre' => 'Partir de mon propre besoin', 'titre_en' => 'Starting from my own need', 'texte' => "Je cherche un poste, j'ai donc listé ce qui me faisait perdre du temps : trier les annonces, comprendre un score, relancer. C'est devenu la liste des écrans.", 'texte_en' => "I'm looking for a job, so I listed what wasted my time: sorting postings, understanding a score, following up. That became the list of screens."],
                    ['titre' => 'Un score qu\'on peut expliquer', 'titre_en' => 'A score you can explain', 'texte' => "Chaque offre reçoit une note sur 100 : compétences (40), lieu et trajet (30), salaire (20), opportunité (10). Des critères éliminatoires passent d'abord, et chaque point est détaillé à l'écran. Pas de boîte noire.", 'texte_en' => "Each offer gets a score out of 100: skills (40), location and commute (30), salary (20), opportunity (10). Knock-out criteria come first, and every point is detailed on screen. No black box."],
                    ['titre' => 'Elle lit, trie et filtre pour moi', 'titre_en' => 'It reads, sorts and filters for me', 'texte' => "Elle collecte les offres de plusieurs sources et lit aussi les alertes reçues dans ma boîte Gmail. Les doublons sont supprimés, chaque offre est lue puis classée par score, et celles qui ne conviennent pas sont écartées. Les candidatures partent par e-mail, uniquement après ma relecture.", 'texte_en' => "It collects offers from several sources and also reads the alerts landing in my Gmail inbox. Duplicates are removed, each offer is read then ranked by score, and unsuitable ones are filtered out. Applications go out by email, only after I have reviewed them."],
                    ['titre' => "De l'offre à la candidature", 'titre_en' => 'From offer to application', 'texte' => "CV adapté à l'offre, lettre générée puis modifiable, envoi par e-mail après relecture. Chaque candidature a son suivi et ses relances programmées. Un coach d'entretien et un chat à outils contrôlés complètent le parcours.", 'texte_en' => "CV tailored to the offer, generated then editable letter, email sent after review. Each application has its tracking and scheduled follow-ups. An interview coach and a chat with controlled tools complete the journey."],
                    ['titre' => 'Mobile et mise en ligne', 'titre_en' => 'Mobile and going live', 'texte' => "Pensée mobile d'abord : l'appli s'installe sur iPhone (PWA) avec des notifications. Hébergée sur mon VPS Hetzner avec SSL. Pour ce portfolio, un mode démo isolé (base séparée, aucune clé, aucun e-mail réel) m'a permis de montrer le produit sans exposer de donnée personnelle.", 'texte_en' => "Designed mobile first: the app installs on iPhone (PWA) with notifications. Hosted on my Hetzner VPS with SSL. For this portfolio, an isolated demo mode (separate database, no keys, no real emails) let me show the product without exposing any personal data."],
                ],
                'slogan' => "L'application prépare, je décide. Elle n'envoie jamais rien à un recruteur sans ma validation.",
                'slogan_en' => "The app prepares, I decide. It never sends anything to a recruiter without my approval.",
                'fonctionnalites' => [
                    ['titre' => 'Elle trouve les offres', 'titre_en' => 'It finds the offers',
                     'texte' => "Collecte automatique deux fois par jour sur plusieurs sources, suppression des doublons, lecture de chaque annonce.",
                     'texte_en' => "Automatic collection twice a day from several sources, duplicate removal, every posting read."],
                    ['titre' => 'Elle note chaque offre', 'titre_en' => 'It scores every offer',
                     'texte' => "Un score sur 100 calculé depuis mon profil, expliqué point par point, avec élimination des offres qui ne conviennent pas. Elle apprend de mes refus sans jamais changer un score en cachette.",
                     'texte_en' => "A score out of 100 computed from my profile, explained point by point, with unsuitable offers filtered out. It learns from my rejections without ever changing a score behind my back."],
                    ['titre' => 'Elle prépare mes candidatures', 'titre_en' => 'It prepares my applications',
                     'texte' => "Lettre en 3 tons, CV adapté à l'offre, fiche de préparation d'entretien, et relecture avant l'envoi par e-mail.",
                     'texte_en' => "Letter in 3 tones, CV tailored to the offer, interview prep sheet, and a review before sending by email."],
                    ['titre' => 'Elle suit tout', 'titre_en' => 'It tracks everything',
                     'texte' => "Étapes, relances automatiques, entretiens avec rappel et export agenda, contacts, notes, vues liste et tableau, statistiques.",
                     'texte_en' => "Stages, automatic follow-ups, interviews with reminders and calendar export, contacts, notes, list and board views, statistics."],
                    ['titre' => 'Elle me répond dans un chat', 'titre_en' => 'It answers me in a chat',
                     'texte' => "Je lui écris ou je lui dicte : elle cherche, explique un score, écrit une lettre, prépare un brouillon et lit ses réponses à voix haute.",
                     'texte_en' => "I type or dictate: it searches, explains a score, writes a letter, drafts an application and reads its answers aloud."],
                    ['titre' => "Elle m'entraîne", 'titre_en' => 'It trains me',
                     'texte' => "Coach d'entretien noté sur 5 à chaque réponse, et analyseur de CV avec score ATS et conseils.",
                     'texte_en' => "Interview coach scoring each answer out of 5, and a CV analyzer with an ATS score and advice."],
                    ['titre' => 'Elle me prévient', 'titre_en' => 'It notifies me',
                     'texte' => "Alertes pour les très bonnes offres, les relances et les entretiens, rappels chaque matin, notifications push sur le téléphone.",
                     'texte_en' => "Alerts for great offers, follow-ups and interviews, daily reminders, push notifications on the phone."],
                    ['titre' => 'Mon profil et mon CV', 'titre_en' => 'My profile and my CV',
                     'texte' => "Profil complet, taux de complétion du CV, deux modèles de CV (Moderne et Sobre ATS) avec export PDF.",
                     'texte_en' => "Full profile, CV completion rate, two CV templates (Modern and Plain ATS) with PDF export."],
                    ['titre' => 'Mon compte et mes garde-fous', 'titre_en' => 'My account and safeguards',
                     'texte' => "Thème sombre ou clair, export de mes données, suppression définitive du compte, budget IA plafonné, contrôle de santé horaire.",
                     'texte_en' => "Dark or light theme, data export, permanent account deletion, capped AI budget, hourly health check."],
                ],
                'limites' => [
                    "Elle n'envoie rien toute seule",
                    "Elle ne modifie pas mon profil sans que je confirme",
                    "Elle n'invente pas de score : tout est expliqué",
                ],
                'limites_en' => [
                    "It sends nothing on its own",
                    "It never edits my profile without my confirmation",
                    "It doesn't invent scores: everything is explained",
                ],
                'resultats' => [
                    ['valeur' => '440+ tests', 'label' => 'automatisés, tous au vert', 'label_en' => 'automated, all passing'],
                    ['valeur' => '4 critères', 'label' => 'pour un score expliqué sur 100', 'label_en' => 'for an explained score out of 100'],
                    ['valeur' => 'PWA', 'label' => 'installable sur iPhone', 'label_en' => 'installable on iPhone'],
                ],
                'apprentissages' => [
                    "Rendre une IA fiable : lui interdire d'inventer et l'appuyer sur des données réelles",
                    "Isoler l'IA derrière une interface pour tout tester avec un faux client",
                    "Concevoir un score déterministe dont chaque point est expliqué",
                    "Piloter un développement assisté par IA : cadrer, vérifier, corriger",
                    "Monter un mode démo isolé pour montrer un produit sans exposer de données personnelles",
                ],
                'apprentissages_en' => [
                    "Making an AI reliable: forbid it to make things up and anchor it in real data",
                    "Isolating the AI behind an interface to test everything with a fake client",
                    "Designing a deterministic score where every point is explained",
                    "Steering AI-assisted development: scope, verify, correct",
                    "Building an isolated demo mode to show a product without exposing personal data",
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
                'mediaNote' => "💻 Captures de l'application en ligne. Des accès de démonstration sont proposés dans l'étude de cas.",
                'mediaNote_en' => "💻 Screenshots of the live application. Demo access is provided in the case study.",
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
            [
                'slug' => 'perline-cookies',
                'index' => '03',
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
                'mediaNote' => "💻 Captures de la boutique en ligne, entièrement responsive dès 360 px.",
                'mediaNote_en' => "💻 Screenshots of the live shop, fully responsive from 360 px.",
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
                    'periode' => 'Novembre 2013 — Novembre 2020',
                    'periode_en' => 'November 2013 — November 2020',
                    'titre' => 'Militaire',
                    'titre_en' => 'Soldier',
                    'sous' => 'Armée de Terre · Le Mans',
                    'sous_en' => 'French Army · Le Mans',
                    'chips' => [['Caporal', 'Corporal'], ['Vigipirate', 'Vigipirate'], ['Opex', 'Overseas operations']],
                    'texte' => "Sept ans de service, avec des missions Vigipirate et des Opex. J'y ai appris la rigueur, la discipline, l'autonomie et le sens de l'organisation.",
                    'texte_en' => 'Seven years of service, including Vigipirate missions and overseas operations. I learned rigour, discipline, autonomy and a sense of organisation.',
                ],
                [
                    'periode' => 'Avril 2021 — Juillet 2023',
                    'periode_en' => 'April 2021 — July 2023',
                    'titre' => 'Deux postes administratifs',
                    'titre_en' => 'Two administrative roles',
                    'sous' => 'Avant le code',
                    'sous_en' => 'Before coding',
                    'jobs' => [
                        [
                            'titre' => 'Assistant administratif des ventes',
                            'titre_en' => 'Sales administrative assistant',
                            'lieu' => 'Sud Fromages',
                            'lieu_en' => 'Sud Fromages',
                            'periode' => 'Avril 2021 — Juillet 2022',
                            'periode_en' => 'April 2021 — July 2022',
                            'chips' => [['Facturation', 'Invoicing'], ['Comptabilité', 'Accounting'], ['Gestion de commandes', 'Order management'], ['Planification', 'Scheduling']],
                        ],
                        [
                            'titre' => 'Assistance technique (CDD)',
                            'titre_en' => 'Technical support (fixed-term)',
                            'lieu' => 'Régie des Eaux de Montpellier',
                            'lieu_en' => 'Régie des Eaux de Montpellier',
                            'periode' => 'Septembre 2022 — Juillet 2023',
                            'periode_en' => 'September 2022 — July 2023',
                            'chips' => [['Planning des techniciens', 'Technician scheduling'], ['Ordres de mission', 'Work orders'], ['Astreinte', 'On-call duty']],
                        ],
                    ],
                ],
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
                    'periode' => 'Mars 2024 — Mai 2024',
                    'periode_en' => 'March 2024 — May 2024',
                    'titre' => 'Développeur web (stage)',
                    'titre_en' => 'Web developer (internship)',
                    'sous' => 'Beenome · Saint-Jean-de-Védas',
                    'sous_en' => 'Beenome · Saint-Jean-de-Védas',
                    'items' => [
                        ['Intégration de sites WordPress / WooCommerce avec Bricks Builder', 'Building WordPress / WooCommerce sites with Bricks Builder'],
                        ['Reproduction de templates e-commerce à partir de maquettes', 'Recreating e-commerce templates from mockups'],
                    ],
                ],
                [
                    'periode' => "Novembre 2024 — Aujourd'hui",
                    'periode_en' => 'November 2024 — Today',
                    'now' => true,
                    'titre' => 'Chargé de coordination et auditeur des visites médicales',
                    'titre_en' => 'Medical visit coordinator and auditor',
                    'sous' => "OFII · Office français de l'immigration et de l'intégration (Préfecture de Montpellier)",
                    'sous_en' => 'OFII · French Office for Immigration and Integration (Montpellier Prefecture)',
                    'items' => [
                        ['Coordination des visites médicales des étrangers arrivant en France', 'Coordinating the medical visits of foreigners arriving in France'],
                        ['Audit des usagers et orientation', 'User audits and guidance'],
                        ['Suivi des dossiers et communication avec de multiples interlocuteurs', 'Case follow-up and communication with many contacts'],
                        ['En parallèle : conception et mise en production de 3 applications Symfony', 'In parallel: designing and shipping 3 Symfony applications'],
                    ],
                    'closing' => [
                        'lead' => 'En poste, et en recherche active.',
                        'lead_en' => 'In a role, and actively looking.',
                        'texte' => 'Ouvert à un CDI, un CDD ou des missions freelance, à distance. Trois projets à découvrir ci-dessus.',
                        'texte_en' => 'Open to a permanent role, a fixed-term contract or freelance assignments, remote. Three projects to discover above.',
                        'chips' => [['CDI', 'Permanent'], ['CDD', 'Fixed-term'], ['Freelance', 'Freelance'], ['À distance', 'Remote']],
                    ],
                ],
            ],
            'skills' => [
                [
                    'categorie' => 'Back-end',
                    'accent' => 'violet',
                    'items' => [
                        ['nom' => 'PHP 8', 'note' => "Mon langage principal, utilisé sur tous mes projets en programmation orientée objet.", 'note_en' => "My main language, used on all my projects with object-oriented programming."],
                        ['nom' => 'Symfony 7', 'note' => "Le framework de Perline Cookies, DP Services et DANY AI : Doctrine, formulaires, sécurité, rôles et événements.", 'note_en' => "The framework behind Perline Cookies, DP Services and DANY AI: Doctrine, forms, security, roles and events."],
                        ['nom' => 'MySQL', 'note' => "Des bases pensées pour de vrais usages : commandes, stocks, réservations, plannings.", 'note_en' => "Databases designed for real-world use: orders, stock, bookings, schedules."],
                        ['nom' => 'Redis', 'note' => "Cache et sessions pour garder l'application rapide.", 'note_en' => "Cache and sessions to keep the application fast."],
                        ['nom' => 'Docker Compose', 'note' => "Le même environnement en local et en production, sans surprise au déploiement.", 'note_en' => "The same environment locally and in production, with no surprises at deployment."],
                    ],
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
                    ],
                ],
                [
                    'categorie' => 'APIs & Services',
                    'accent' => 'coral',
                    'items' => [
                        ['nom' => 'Stripe', 'note' => "Le paiement de Perline Cookies, avec un webhook qui valide la commande seulement une fois l'argent reçu.", 'note_en' => "Perline Cookies payment, with a webhook that validates the order only once the money is received."],
                        ['nom' => 'Google Places API', 'note' => "Des adresses saisies en quelques lettres, sans fautes, pour que les salariés trouvent le bon endroit.", 'note_en' => "Addresses entered in a few letters, without typos, so employees find the right place."],
                        ['nom' => 'Google Calendar API', 'note' => "Les missions de DP Services arrivent directement dans l'agenda de chacun.", 'note_en' => "DP Services missions arrive directly in everyone's calendar."],
                        ['nom' => 'Brevo', 'note' => "Tous les emails automatiques de mes projets : confirmations, notifications et formulaire de contact.", 'note_en' => "All the automatic emails of my projects: confirmations, notifications and contact form."],
                        ['nom' => 'Claude API (Anthropic)', 'note' => "Au cœur de DANY AI, mon projet d'aide à la recherche d'emploi : scoring expliqué, lettres, coach d'entretien et chat.", 'note_en' => "At the heart of DANY AI, my job-search assistance project: explained scoring, letters, interview coach and chat."],
                    ],
                ],
                [
                    'categorie' => 'Outils & Workflows',
                    'categorie_en' => 'Tools & Workflows',
                    'accent' => 'sky',
                    'items' => [
                        ['nom' => 'Git & GitHub', 'note' => "Tous mes projets sont versionnés, du premier commit à la mise en production.", 'note_en' => "All my projects are versioned, from the first commit to production."],
                        ['nom' => 'Figma', 'note' => "Je dessine les écrans avant de les coder, pour savoir où je vais.", 'note_en' => "I design the screens before coding them, so I know where I'm going."],
                        ['nom' => 'Hébergement Hetzner', 'note' => "Mes sites tournent sur mon propre VPS : déploiement, SSL, crons et mises à jour, je gère tout.", 'note_en' => "My sites run on my own VPS: deployment, SSL, crons and updates, I handle everything."],
                    ],
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
            ->to('dany.dev19922@gmail.com')
            ->replyTo($emailVisiteur)
            ->subject('[Portfolio] ' . $sujet)
            ->text("De : $nom ($emailVisiteur)\n\n$message");

        $mailer->send($email);
        $this->addFlash('success', 'Message envoyé, merci ! Je reviens vers vous rapidement.');

        return $this->redirectToRoute('app_home', ['_fragment' => 'contact']);
    }
}
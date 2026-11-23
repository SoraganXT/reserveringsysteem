<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

const SUPPORTED_LANGS = ['nl', 'fr'];

$translations = [
    'nl' => [
        'nav.store' => 'Winkel',
        'nav.cart' => 'Winkelmand',
        'nav.uitleg' => 'Uitleg',
        'nav.staff' => 'Personeel',
        'nav.dashboard' => 'Dashboard',
        'nav.admin' => 'Admin',
        'nav.logout' => 'Uitloggen',
        'nav.login' => 'Inloggen',
        'hero.badge' => 'Modern reserveren',
        'hero.title' => 'Slimme reservaties voor lokale winkels.',
        'hero.subtitle' => 'Laat klanten producten reserveren, een afhaaldag en tijd kiezen, en houd je team gefocust op voorbereiden in plaats van telefoneren.',
        'hero.cta.primary' => 'Bekijk producten',
        'hero.cta.secondary' => 'Start reservering',
        'hero.why.title' => 'Waarom winkels dit kiezen',
        'hero.why.1' => 'Duidelijk overzicht van dagelijkse reservaties',
        'hero.why.2' => 'Snelle statusupdates per bestelling',
        'hero.why.3' => 'Slim voorraadbeheer en productbeheer',
        'hero.why.4' => 'Mobielvriendelijke ervaring voor klanten',
        'hero.today' => 'Vandaag',
        'hero.today.desc' => 'Zie wat voorbereid moet worden.',
        'hero.tomorrow' => 'Morgen',
        'hero.tomorrow.desc' => 'Plan productie vooruit.',
        'section.local.title' => 'Gemaakt voor lokale zaken',
        'section.local.bakery' => 'Bakkers',
        'section.local.bakery.desc' => 'Bouw je planning op basis van echte reservaties.',
        'section.local.night' => 'Nachtwinkels',
        'section.local.night.desc' => 'Klanten reserveren snacks en drank voor ze aankomen.',
        'section.local.florist' => 'Bloemisten',
        'section.local.florist.desc' => 'Plan afhaalmomenten voor boeketten en seizoenswerk.',
        'store.title' => 'Producten',
        'store.filter.all' => 'Alles',
        'store.general' => 'Algemeen',
        'store.stock' => 'Voorraad',
        'store.add' => 'Toevoegen',
        'store.qty' => 'Aantal',
        'cart.title' => 'Winkelmand',
        'cart.empty' => 'Je winkelmand is leeg.',
        'cart.checkout' => 'Verder naar afrekenen',
        'cart.update' => 'Bijwerken',
        'checkout.title' => 'Afrekenen',
        'checkout.summary' => 'Jouw selectie',
        'checkout.customer' => 'Jouw gegevens',
        'checkout.pickup' => 'Afhalen',
        'checkout.name' => 'Naam',
        'checkout.email' => 'E-mail',
        'checkout.phone' => 'Telefoon',
        'checkout.date' => 'Afhaaldatum',
        'checkout.slot' => 'Afhaaltijd',
        'checkout.notes' => 'Opmerking (optioneel)',
        'checkout.submit' => 'Reservatie plaatsen',
        'confirm.title' => 'Reservatie bevestigd',
        'confirm.message' => 'Bedankt %s. Je reservatie is ontvangen.',
        'confirm.pickup_date' => 'Afhaaldatum',
        'confirm.pickup_time' => 'Afhaaltijd',
        'confirm.items' => 'Items',
        'confirm.back' => 'Terug naar winkel',
        'error.contact' => 'Vul je naam, e-mail en afhaaldatum in.',
        'error.time' => 'Kies een afhaaltijd.',
        'error.empty_cart' => 'Je winkelmand is leeg.',
        'error.invalid_slot' => 'Ongeldig tijdslot.',
        'error.stock' => 'Niet genoeg voorraad voor een of meer producten.',
        'error.save' => 'Er ging iets mis bij het opslaan van je reservatie.',
        'error.check' => 'Controleer het volgende:',
        'error.not_found' => 'Reservatie niet gevonden.',
        'uitleg.title' => 'Uitleg',
        'uitleg.hero.title' => 'Laat klanten reserveren zonder gedoe.',
        'uitleg.hero.subtitle' => 'Een snelle, duidelijke en professionele reservatieflow voor lokale winkels en voedingszaken.',
        'uitleg.usecases.title' => 'Use cases per type zaak',
        'uitleg.bakery.title' => 'Bakkerij',
        'uitleg.bakery.desc' => 'Verkoop broden, patisserie, taarten en sandwiches met een overzichtelijke afhaalplanning.',
        'uitleg.florist.title' => 'Bloemist',
        'uitleg.florist.desc' => 'Laat klanten boeketten reserveren en een afhaalmoment kiezen, ideaal voor piekdagen.',
        'uitleg.night.title' => 'Nachtwinkel',
        'uitleg.night.desc' => 'Klanten reserveren drank, snacks of basics zodat alles klaar ligt bij aankomst.',
        'uitleg.features.title' => 'Wat het systeem doet',
        'uitleg.features.1' => 'Online producten tonen met duidelijke categorieen',
        'uitleg.features.2' => 'Winkelmandje met afrekenen op datum en tijd',
        'uitleg.features.3' => 'Statusbeheer per bestelling voor het team',
        'uitleg.features.4' => 'Voorraadbewegingen automatisch bij reservatie',
        'uitleg.features.5' => 'Overzicht per dag zodat productie slim gepland wordt',
        'uitleg.steps.title' => 'Hoe het werkt',
        'uitleg.steps.1' => 'Klant kiest producten en mikt ze in de winkelmand.',
        'uitleg.steps.2' => 'Klant kiest afhaaldag en tijdslot en bevestigt.',
        'uitleg.steps.3' => 'Jij ziet meteen wat voorbereid moet worden.',
        'uitleg.results.title' => 'Resultaat voor jouw zaak',
        'uitleg.results.1' => 'Minder telefoons, meer rust in de zaak',
        'uitleg.results.2' => 'Duidelijke planning per dag en tijdslot',
        'uitleg.results.3' => 'Minder fouten bij afhaalbestellingen',
        'uitleg.growth.title' => 'Klaar voor groei',
        'uitleg.growth.1' => 'Uitbreidbaar met bezorging en meldingen',
        'uitleg.growth.2' => 'QR pickup en abonnementen kunnen later aan',
        'uitleg.cta' => 'Bekijk de demo winkel',
        'staff.title' => 'Personeel',
        'staff.subtitle' => 'Login voor zaakvoerders en teamleden',
        'staff.button' => 'Ga naar login',
        'login.title' => 'Inloggen',
        'login.email' => 'E-mail',
        'login.password' => 'Wachtwoord',
        'login.button' => 'Inloggen',
        'login.error' => 'Ongeldige login gegevens.',
        'common.select_time' => 'Kies tijd',
        'common.currency' => 'EUR',
        'common.no_business' => 'Geen actieve zaak gevonden.',
        'footer.note' => 'Lichtgewicht reservatieplatform.',
    ],
    'fr' => [
        'nav.store' => 'Boutique',
        'nav.cart' => 'Panier',
        'nav.uitleg' => 'Infos',
        'nav.staff' => 'Equipe',
        'nav.dashboard' => 'Tableau',
        'nav.admin' => 'Admin',
        'nav.logout' => 'Deconnexion',
        'nav.login' => 'Connexion',
        'hero.badge' => 'Reservation moderne',
        'hero.title' => 'Reservations intelligentes pour les commerces locaux.',
        'hero.subtitle' => 'Laissez les clients reserver des produits, choisir un jour et une heure, et gardez votre equipe concentree sur la preparation.',
        'hero.cta.primary' => 'Voir les produits',
        'hero.cta.secondary' => 'Demarrer la reservation',
        'hero.why.title' => 'Pourquoi les commerces choisissent ceci',
        'hero.why.1' => 'Vue claire des reservations quotidiennes',
        'hero.why.2' => 'Mises a jour rapides des statuts',
        'hero.why.3' => 'Gestion simple des produits et du stock',
        'hero.why.4' => 'Experience mobile fluide',
        'hero.today' => 'Aujourdhui',
        'hero.today.desc' => 'Voir ce qui doit etre prepare.',
        'hero.tomorrow' => 'Demain',
        'hero.tomorrow.desc' => 'Planifier la production a lavance.',
        'section.local.title' => 'Concu pour les commerces locaux',
        'section.local.bakery' => 'Boulangeries',
        'section.local.bakery.desc' => 'Planifiez la production avec des reservations reelles.',
        'section.local.night' => 'Night shops',
        'section.local.night.desc' => 'Les clients reservent snacks et boissons avant d arriver.',
        'section.local.florist' => 'Fleuristes',
        'section.local.florist.desc' => 'Planifiez les retraits pour bouquets et commandes saisonnieres.',
        'store.title' => 'Produits',
        'store.filter.all' => 'Tous',
        'store.general' => 'General',
        'store.stock' => 'Stock',
        'store.add' => 'Ajouter',
        'store.qty' => 'Quantite',
        'cart.title' => 'Panier',
        'cart.empty' => 'Votre panier est vide.',
        'cart.checkout' => 'Passer a la caisse',
        'cart.update' => 'Mettre a jour',
        'checkout.title' => 'Paiement',
        'checkout.summary' => 'Votre selection',
        'checkout.customer' => 'Vos coordonnees',
        'checkout.pickup' => 'Retrait',
        'checkout.name' => 'Nom',
        'checkout.email' => 'Email',
        'checkout.phone' => 'Telephone',
        'checkout.date' => 'Date de retrait',
        'checkout.slot' => 'Heure de retrait',
        'checkout.notes' => 'Note (optionnel)',
        'checkout.submit' => 'Envoyer la reservation',
        'confirm.title' => 'Reservation confirmee',
        'confirm.message' => 'Merci %s. Votre reservation est bien recue.',
        'confirm.pickup_date' => 'Date de retrait',
        'confirm.pickup_time' => 'Heure de retrait',
        'confirm.items' => 'Articles',
        'confirm.back' => 'Retour a la boutique',
        'error.contact' => 'Entrez votre nom, email et date de retrait.',
        'error.time' => 'Choisissez une heure de retrait.',
        'error.empty_cart' => 'Votre panier est vide.',
        'error.invalid_slot' => 'Creneau invalide.',
        'error.stock' => 'Stock insuffisant pour un ou plusieurs produits.',
        'error.save' => 'Erreur lors de lenregistrement de la reservation.',
        'error.check' => 'Verifiez les points suivants :',
        'error.not_found' => 'Reservation introuvable.',
        'uitleg.title' => 'Infos',
        'uitleg.hero.title' => 'Laissez les clients reserver sans friction.',
        'uitleg.hero.subtitle' => 'Un parcours de reservation clair et professionnel pour commerces locaux et alimentaires.',
        'uitleg.usecases.title' => 'Use cases par type de commerce',
        'uitleg.bakery.title' => 'Boulangerie',
        'uitleg.bakery.desc' => 'Vendez pains, patisseries, gateaux et sandwiches avec un planning clair.',
        'uitleg.florist.title' => 'Fleuriste',
        'uitleg.florist.desc' => 'Les clients reservent un bouquet et choisissent un retrait.',
        'uitleg.night.title' => 'Night shop',
        'uitleg.night.desc' => 'Reservation de boissons, snacks et produits de base.',
        'uitleg.features.title' => 'Ce que le systeme fait',
        'uitleg.features.1' => 'Catalogue en ligne avec categories claires',
        'uitleg.features.2' => 'Panier et retrait par date et heure',
        'uitleg.features.3' => 'Gestion des statuts par commande',
        'uitleg.features.4' => 'Stock mis a jour automatiquement',
        'uitleg.features.5' => 'Vue par jour pour planifier la production',
        'uitleg.steps.title' => 'Comment ca marche',
        'uitleg.steps.1' => 'Le client choisit ses produits et ajoute au panier.',
        'uitleg.steps.2' => 'Le client choisit date et creneau puis confirme.',
        'uitleg.steps.3' => 'Vous voyez tout de suite ce qui doit etre prepare.',
        'uitleg.results.title' => 'Resultat pour votre commerce',
        'uitleg.results.1' => 'Moins d appels, plus de calme',
        'uitleg.results.2' => 'Planning clair par jour et creneau',
        'uitleg.results.3' => 'Moins d erreurs lors des retraits',
        'uitleg.growth.title' => 'Pret pour evoluer',
        'uitleg.growth.1' => 'Extensible avec livraison et notifications',
        'uitleg.growth.2' => 'QR pickup et abonnements plus tard',
        'uitleg.cta' => 'Voir la demo',
        'staff.title' => 'Equipe',
        'staff.subtitle' => 'Connexion pour les commercants',
        'staff.button' => 'Aller a la connexion',
        'login.title' => 'Connexion',
        'login.email' => 'Email',
        'login.password' => 'Mot de passe',
        'login.button' => 'Connexion',
        'login.error' => 'Identifiants invalides.',
        'common.select_time' => 'Choisir une heure',
        'common.currency' => 'EUR',
        'common.no_business' => 'Aucun commerce actif trouve.',
        'footer.note' => 'Plateforme de reservation legere.',
    ],
];

function current_lang(): string
{
    ensure_session();

    if (isset($_GET['lang'])) {
        $lang = strtolower((string) $_GET['lang']);
        if (in_array($lang, SUPPORTED_LANGS, true)) {
            $_SESSION['lang'] = $lang;
        }
    }

    $lang = $_SESSION['lang'] ?? 'nl';
    if (!in_array($lang, SUPPORTED_LANGS, true)) {
        $lang = 'nl';
    }

    return $lang;
}

function t(string $key): string
{
    global $translations;
    $lang = current_lang();

    if (isset($translations[$lang][$key])) {
        return $translations[$lang][$key];
    }

    return $translations['nl'][$key] ?? $key;
}

function lang_url(string $lang): string
{
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $parts = parse_url($uri);
    $path = $parts['path'] ?? '/';
    $query = [];

    if (!empty($parts['query'])) {
        parse_str($parts['query'], $query);
    }

    $query['lang'] = $lang;
    return $path . '?' . http_build_query($query);
}

function day_name(int $day): string
{
    $lang = current_lang();
    $days = [
        'nl' => ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
        'fr' => ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    ];

    $list = $days[$lang] ?? $days['nl'];
    return $list[$day] ?? (string) $day;
}

function field(array $row, string $key): string
{
    $lang = current_lang();
    $fallback = $row[$key] ?? '';

    if ($lang === 'fr') {
        $altKey = $key . '_fr';
        $value = $row[$altKey] ?? '';
        if ($value !== '') {
            return (string) $value;
        }
    }

    return (string) $fallback;
}

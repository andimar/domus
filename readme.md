# Domus Medica 1.0 — tema PHP/Twig

SEO: `ThemeSetup/Seo.php` integra Yoast senza duplicare i metadati e fornisce un fallback quando manca un provider SEO. Titolo e descrizione home hanno default locali e campi nel gruppo SEO delle impostazioni Domus; i valori espliciti di Yoast mantengono la precedenza. Entità laboratorio da dati pubblici configurati, nessuna offerta o recensione inventata. Preview/local/development/staging sono noindex. In produzione verificare ambiente, HTTPS, cache e sitemap: procedura in `docs/20-audit-seo-aeo-geo.md` della repository contenitore.

Tema autonomo OOP: `functions.php` → `Domus\Bootstrap` → repository/view model PHP → Twig con autoescape. Nessuna SPA, nessuna sostituzione della struttura PHP. PHP >=8.2, WordPress >=6.4; verificato nel clone WordPress 7.1.3/PHP 8.5.

Installare il plugin **Domus Contenuti** insieme al tema. Conservare **Domus Open Map** per la mappa interattiva; senza plugin rimane il collegamento a OpenStreetMap. Non sono necessari ACF o plugin premium.

- **Aspetto → Domus Medica:** layout Base (approvata), Tagli di luce, Vicina, ogni giorno; testi suggeriti dal mockup, proposte diretti/accoglienti/essenziali; immagine o raccolta per tutte le sezioni; rotazione a ogni accesso, senza slideshow. Le immagini facoltative vuote non aggiungono foto alle sezioni.
- **Aspetto → Orari:** prelievi lun–ven e sabato, ritiro referti mattina/pomeriggio lun–ven, sabato chiuso e nota; validazione degli intervalli.
- **Aspetto → FAQ:** domande/risposte, visibilità, aggiunta/rimozione e ordinamento. Testi del mockup suggeriti inizialmente.
- **Domus Medica → Footer:** mostra/nascondi Accedi e scegli il suo URL (vuoto: login WordPress). Privacy collegata alla pagina Privacy configurata in WordPress, indipendentemente da Accedi.
- **Aspetto → Personalizza → Mezzi pubblici:** visibilità gruppi, linee/link, fermate, nota e avvisi del gestore. Mappa gestita dal plugin indipendente.
- **Aspetto → Personalizza → Immagini della home:** sette selettori multipli dalla libreria, ordine delle immagini, rimozione/ripristino e rotazione per visita. Opzioni condivise con la pagina Domus Medica; anteprima prima di Pubblica.
- **Pacchetti:** articoli originali con metadati; **Avvisi** e **Altri servizi:** CPT indipendenti dal tema.
- **Strumenti → Dati Domus:** importazione esplicita e ripetibile dello snapshot pubblico del sito.

Scelte fissate: azzurri + oro chiarissimo solo FAQ; Newsreader titoli, Source Sans 3 testi/card, Georgia prezzi; solo tema chiaro. Non vengono esposte nuove scelte cromatiche o tipografiche.

Le scene del mockup incluse sono illustrative e generate, con provenienza conservata negli asset. Sostituibili con foto reali dalla Libreria media. Immagini pacchetti dai media originali; nessuna immagine del personale è presentata come reale senza fonte.

Build dal repository contenitore: `node scripts/prepare-copy-presets.mjs`, `node frontend/tools/build.mjs` dalla cartella frontend, quindi `node scripts/assemble-theme.mjs` dalla radice. Dipendenze PHP fissate in composer.lock; `composer install` se vendor mancante. I frammenti Twig di produzione sono sorgenti: non rigenerarli dal mockup durante la normale build.

ZIP installabili e rapporti di verifica nella cartella outputs della repository contenitore. Il sito online non viene modificato da questi comandi. Il clone locale su porta 8092 conserva dati e plugin legacy separati dalla produzione.

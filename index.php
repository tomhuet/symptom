<?php
require_once 'config.php';

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self'");

$projects = getProjects();
$reviews = getReviews();
usort($projects, fn($a, $b) => strtotime($b['created_at']) - strtotime($a['created_at']));
usort($reviews, fn($a, $b) => strtotime($b['created_at']) - strtotime($a['created_at']));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="SYMPTOM - Agence produit et tech. Designed to perform. Conseil, développement, IA, automatisation.">
  <meta name="keywords" content="agence digitale, développement web, IA, automatisation, conseil tech">
  <meta name="author" content="SYMPTOM">
  <meta name="theme-color" content="#000000">
  
  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo SITE_URL; ?>">
  <meta property="og:title" content="SYMPTOM - Designed to Perform">
  <meta property="og:description" content="Agence produit et tech. Conseil, développement, IA, automatisation.">
  <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/img/og-image.png">
  
  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="<?php echo SITE_URL; ?>">
  <meta property="twitter:title" content="SYMPTOM - Designed to Perform">
  <meta property="twitter:description" content="Agence produit et tech. Conseil, développement, IA, automatisation.">
  <meta property="twitter:image" content="<?php echo SITE_URL; ?>/assets/img/og-image.png">
  
  <title>SYMPTOM - Designed to Perform</title>
  
  <!-- Preconnect to external resources -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  
  <!-- Fonts with display swap for better performance -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  
  <!-- Preload critical resources -->
  <link rel="preload" href="assets/css/styles.css" as="style">
  <link rel="preload" href="assets/js/script.js" as="script">
  
  <link rel="stylesheet" href="assets/css/styles.css">
  
  <!-- Schema.org markup for organization -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "SYMPTOM",
    "url": "<?php echo SITE_URL; ?>",
    "logo": "<?php echo SITE_URL; ?>/assets/img/logo.svg",
    "description": "Agence produit et tech. Designed to perform. Conseil, développement, IA, automatisation.",
    "email": "hello@symptom.agency",
    "telephone": "+33123456789",
    "address": {
      "@type": "PostalAddress",
      "addressCountry": "FR"
    },
    "sameAs": [
      "https://linkedin.com",
      "https://twitter.com"
    ]
  }
  </script>
</head>
<body>

  <div class="loader" id="loader">
    <div class="loader-inner">
      <div class="loader-logo">
        <img src="assets/img/loader.svg" alt="S">
      </div>
      <div class="loader-text">SYMPTOM</div>
      <div class="loader-bar">
        <div class="loader-progress"></div>
      </div>
    </div>
  </div>

  <nav class="nav" id="nav">
    <div class="nav-inner">
      <a href="/" class="nav-logo">
        <img src="assets/img/logo.svg" alt="SYMPTOM">
      </a>
      <div class="nav-links">
        <a href="#services" class="nav-link">Services</a>
        <a href="#process" class="nav-link">Process</a>
        <a href="#projects" class="nav-link">Projets</a>
        <a href="#reviews" class="nav-link">Avis</a>
        <a href="#contact" class="nav-link">Contact</a>
      </div>
      <a href="#" class="nav-cta" id="client-btn">
        <span>Espace Client</span>
        <div class="btn-fill"></div>
      </a>
      <button class="nav-mobile-toggle" id="mobile-toggle" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>

  <div class="mobile-menu" id="mobile-menu">
    <a href="#services" class="mobile-link">Services</a>
    <a href="#process" class="mobile-link">Process</a>
    <a href="#projects" class="mobile-link">Projets</a>
    <a href="#reviews" class="mobile-link">Avis</a>
    <a href="#contact" class="mobile-link">Contact</a>
  </div>

  <header class="hero" id="hero">
    <div class="hero-bg">
      <div class="ripple-wrapper">
        <div class="ripple-circle" style="--i: 0;"></div>
        <div class="ripple-circle" style="--i: 1;"></div>
        <div class="ripple-circle" style="--i: 2;"></div>
        <div class="ripple-circle" style="--i: 3;"></div>
        <div class="ripple-circle" style="--i: 4;"></div>
        <div class="ripple-circle" style="--i: 5;"></div>
        <div class="ripple-circle" style="--i: 6;"></div>
        <div class="ripple-circle" style="--i: 7;"></div>
      </div>
    </div>
    
    <div class="hero-content">
      <div class="hero-tag">
        <span class="hero-tag-dot"></span>
        <span>Agence Produit & Tech</span>
      </div>
      
      <h1 class="hero-title">
        <div class="title-line"><span class="title-word">DESIGNED</span></div>
        <div class="title-line title-line-rotate">
          <span class="title-word">TO</span>
          <span class="title-word-wrapper">
            <span class="rotating-words" id="rotating-words">
              <span class="rotating-word active">PERFORM</span>
              <span class="rotating-word">INSPIRE</span>
              <span class="rotating-word">IMPACT</span>
              <span class="rotating-word">TRANSFORM</span>
              <span class="rotating-word">INTERACT</span>
              <span class="rotating-word">INNOVATE</span>
              <span class="rotating-word">MAKE SENSE</span>
              <span class="rotating-word">CONNECT</span>
              <span class="rotating-word">CONVERT</span>
              <span class="rotating-word">EVOLVE</span>
              <span class="rotating-word">OPTIMIZE</span>
              <span class="rotating-word">PERFORM</span>
            </span>
          </span>
        </div>
      </h1>

      <p class="hero-desc">Nous concevons des solutions sur-mesure qui transforment vos idées en produits performants.</p>

      <form class="hero-form" id="hero-form">
        <input type="hidden" name="csrf_token" value="<?php echo getCSRFToken(); ?>">
        <div class="form-input-wrap">
          <input type="text" name="project" placeholder="Décrivez votre projet..." required aria-label="Description de votre projet">
          <button type="submit" class="form-btn" aria-label="Envoyer">
            <svg class="btn-icon-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
            <div class="btn-loader"><div class="spinner"></div></div>
          </button>
        </div>
      </form>
    </div>

    <div class="hero-scroll">
      <span>Scroll</span>
      <div class="scroll-line"></div>
    </div>

    <div class="hero-stats">
      <div class="stat">
        <span class="stat-number"><?php echo count($projects); ?></span>
        <span class="stat-label">Projets</span>
      </div>
      <div class="stat">
        <span class="stat-number"><?php echo count($reviews); ?></span>
        <span class="stat-label">Avis</span>
      </div>
      <div class="stat">
        <span class="stat-number">98<span class="stat-suffix">%</span></span>
        <span class="stat-label">Satisfaction</span>
      </div>
    </div>
  </header>

  <main>
    <section class="services" id="services">
      <div class="container">
        <div class="section-header">
          <span class="section-tag">Nos expertises</span>
          <h2 class="section-title">
            <span class="reveal-text">Des solutions adaptées</span>
            <span class="reveal-text">à chaque besoin</span>
          </h2>
        </div>

        <div class="services-grid">
          <article class="service-card service-card-large">
            <div class="service-icon">
              <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="24" cy="24" r="20"/><path d="M24 14v20M14 24h20"/>
              </svg>
            </div>
            <span class="service-num">01</span>
            <h3>Conseil & Stratégie</h3>
            <p>Accompagnement sur-mesure pour votre transformation digitale et l'optimisation de vos processus.</p>
            <ul class="service-list">
              <li>Audit digital</li>
              <li>Stratégie de digitalisation</li>
              <li>Choix d'outils</li>
              <li>Conformité RGPD</li>
              <li>Optimisation processus</li>
              <li>Roadmap produit</li>
            </ul>
          </article>

          <article class="service-card service-card-large">
            <div class="service-icon">
              <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="6" y="10" width="36" height="28" rx="2"/>
                <path d="M16 24l4 4-4 4M26 24h6"/>
              </svg>
            </div>
            <span class="service-num">02</span>
            <h3>Développement Web & Apps</h3>
            <p>Création de sites internet et applications web performantes, adaptées à vos besoins spécifiques.</p>
            <ul class="service-list">
              <li>Sites vitrine</li>
              <li>E-commerce</li>
              <li>Applications web</li>
              <li>Applications mobiles</li>
              <li>APIs & intégrations</li>
              <li>Maintenance</li>
            </ul>
          </article>

          <article class="service-card service-card-large">
            <div class="service-icon">
              <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M24 4L4 14v20l20 10 20-10V14L24 4z"/><path d="M4 14l20 10 20-10M24 44V24"/>
              </svg>
            </div>
            <span class="service-num">03</span>
            <h3>IA & Automatisation</h3>
            <p>Intégration de l'intelligence artificielle et automatisation de vos processus métiers.</p>
            <ul class="service-list">
              <li>Chatbots IA</li>
              <li>Agents intelligents</li>
              <li>Automatisation RPA</li>
              <li>Formation IA</li>
              <li>Intégration outils</li>
              <li>Analyse prédictive</li>
            </ul>
          </article>

          <article class="service-card">
            <div class="service-icon">
              <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="24" cy="12" r="8"/><path d="M8 44c0-9 7-16 16-16s16 7 16 16"/>
              </svg>
            </div>
            <span class="service-num">04</span>
            <h3>Formation & Adoption</h3>
            <p>Accompagnement de vos équipes dans la prise en main des outils et nouvelles technologies.</p>
            <ul class="service-list">
              <li>Onboarding personnalisé</li>
              <li>Playbooks</li>
              <li>Formations sur-mesure</li>
              <li>Support continu</li>
            </ul>
          </article>

          <article class="service-card">
            <div class="service-icon">
              <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="14" cy="14" r="6"/><circle cx="34" cy="14" r="6"/><circle cx="24" cy="34" r="6"/>
                <path d="M14 20v8l10 6M34 20v8l-10 6"/>
              </svg>
            </div>
            <span class="service-num">05</span>
            <h3>Mise en Relation</h3>
            <p>Accès à notre réseau d'experts et partenaires pour compléter vos besoins.</p>
            <ul class="service-list">
              <li>Experts tech & data</li>
              <li>Spécialistes IA</li>
              <li>Consultants sécurité</li>
              <li>Partenaires métiers</li>
            </ul>
          </article>

          <article class="service-card">
            <div class="service-icon">
              <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="6" y="6" width="36" height="36" rx="4"/>
                <path d="M6 18h36M18 18v24"/>
              </svg>
            </div>
            <span class="service-num">06</span>
            <h3>Produit & Prototypage</h3>
            <p>Validation rapide de vos idées grâce à des prototypes fonctionnels et tests utilisateurs.</p>
            <ul class="service-list">
              <li>Wireframes</li>
              <li>Maquettes</li>
              <li>POC & MVP</li>
              <li>Tests utilisateurs</li>
            </ul>
          </article>
        </div>
      </div>
    </section>

    <section class="process" id="process">
      <div class="container">
        <div class="section-header">
          <span class="section-tag">Notre approche</span>
          <h2 class="section-title">
            <span class="reveal-text">Un processus clair</span>
            <span class="reveal-text">et transparent</span>
          </h2>
        </div>

        <div class="process-timeline">
          <div class="process-step">
            <div class="step-marker">
              <span class="step-number">01</span>
              <div class="step-line"></div>
            </div>
            <div class="step-content">
              <div class="step-badge">Gratuit</div>
              <h3>Prise de contact</h3>
              <p>Nous échangeons sur vos besoins, vos objectifs et les premiers éléments de votre projet. Un premier appel pour faire connaissance et comprendre votre contexte.</p>
            </div>
          </div>

          <div class="process-step">
            <div class="step-marker">
              <span class="step-number">02</span>
              <div class="step-line"></div>
            </div>
            <div class="step-content">
              <div class="step-badge">Gratuit</div>
              <h3>Audit en présentiel</h3>
              <p>Nos équipes se déplacent dans vos locaux pour identifier les axes d'amélioration et comprendre en profondeur vos problématiques internes.</p>
            </div>
          </div>

          <div class="process-step">
            <div class="step-marker">
              <span class="step-number">03</span>
              <div class="step-line"></div>
            </div>
            <div class="step-content">
              <div class="step-badge">Gratuit</div>
              <h3>Rédaction de la proposition</h3>
              <p>Dans les jours suivant l'audit, nous rédigeons une proposition détaillée contenant l'ensemble des solutions pour répondre aux éléments identifiés.</p>
            </div>
          </div>

          <div class="process-divider">
            <div class="divider-line"></div>
            <span class="divider-text">Jusqu'ici, c'est gratuit et sans engagement</span>
            <div class="divider-line"></div>
          </div>

          <div class="process-step">
            <div class="step-marker">
              <span class="step-number">04</span>
              <div class="step-line"></div>
            </div>
            <div class="step-content">
              <h3>Présentation de la proposition</h3>
              <p>Nous organisons un rendez-vous pour vous présenter notre proposition en détail, répondre à vos questions et ajuster si nécessaire.</p>
            </div>
          </div>

          <div class="process-step">
            <div class="step-marker">
              <span class="step-number">05</span>
              <div class="step-line"></div>
            </div>
            <div class="step-content">
              <h3>Validation & Ajustements</h3>
              <p>Si la proposition vous convient, nous avançons ensemble. Sinon, nous travaillons sur une version plus adaptée à vos contraintes et attentes.</p>
            </div>
          </div>

          <div class="process-step">
            <div class="step-marker">
              <span class="step-number">06</span>
              <div class="step-line last"></div>
            </div>
            <div class="step-content">
              <h3>Réalisation du projet</h3>
              <p>Une fois la proposition acceptée, nous débutons la réalisation. Vous recevez une deadline claire tenant compte de vos contraintes, avec des points d'étape réguliers.</p>
            </div>
          </div>
        </div>

        <div class="process-cta">
          <p>Prêt à démarrer ?</p>
          <a href="#contact" class="btn-primary">
            <span>Planifier un échange</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
          </a>
        </div>
      </div>
    </section>

    <?php if (!empty($projects)): ?>
    <section class="projects-section" id="projects">
      <div class="container">
        <div class="section-header">
          <span class="section-tag">Nos réalisations</span>
          <h2 class="section-title">
            <span class="reveal-text">Projets qui</span>
            <span class="reveal-text">font la différence</span>
          </h2>
        </div>
      </div>

      <div class="stacking-cards">
        <?php foreach ($projects as $index => $project): ?>
        <article class="stacking-card" data-index="<?php echo $index; ?>" style="--card-index: <?php echo $index; ?>;">
          <div class="card-image">
            <?php if (!empty($project['image'])): ?>
              <img src="<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['company']); ?>" loading="lazy">
            <?php else: ?>
              <div class="card-image-placeholder"><?php echo strtoupper(substr($project['company'], 0, 2)); ?></div>
            <?php endif; ?>
          </div>
          <div class="card-overlay"></div>
          <div class="card-content">
            <div class="card-meta">
              <span class="card-sector"><?php echo htmlspecialchars($project['sector']); ?></span>
              <span class="card-date"><?php echo date('Y', strtotime($project['created_at'])); ?></span>
            </div>
            <h3 class="card-title"><?php echo htmlspecialchars($project['company']); ?></h3>
            <p class="card-problem"><?php echo htmlspecialchars($project['problem']); ?></p>
            <a href="projet/<?php echo htmlspecialchars($project['slug']); ?>" class="card-link">
              <span>Découvrir le projet</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
          </div>
        </article>
        <?php endforeach; ?>
      </div>

      <div class="projects-cta">
        <a href="#contact" class="btn-outline">
          <span>Discuter de votre projet</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($reviews)): ?>
    <section class="reviews-section" id="reviews">
      <div class="container">
        <?php $avgRating = round(array_sum(array_column($reviews, 'rating')) / count($reviews), 1); ?>
        <div class="reviews-header">
          <div class="section-header">
            <span class="section-tag">Témoignages</span>
            <h2 class="section-title">
              <span class="reveal-text">Ce que disent</span>
              <span class="reveal-text">nos clients</span>
            </h2>
          </div>
          <div class="reviews-score">
            <span class="score-label">Score moyen</span>
            <div class="score-value"><?php echo number_format($avgRating, 1, ',', ' '); ?></div>
            <p>Basé sur nos derniers projets livrés</p>
          </div>
        </div>

        <div class="reviews-rail">
          <?php foreach ($reviews as $review): ?>
          <?php $metaLine = trim(($review['position'] ?? '') . (!empty($review['position']) && !empty($review['company']) ? ' • ' : '') . ($review['company'] ?? '')); ?>
          <article class="review-card">
            <div class="review-top">
              <span class="review-chip"><?php echo htmlspecialchars($review['company'] ?? 'Client'); ?></span>
              <div class="review-stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <span class="star <?php echo $i <= $review['rating'] ? 'filled' : ''; ?>">★</span>
                <?php endfor; ?>
              </div>
            </div>
            <blockquote class="review-content">"<?php echo htmlspecialchars($review['content']); ?>"</blockquote>
            <div class="review-author">
              <div class="review-avatar"><?php echo strtoupper(substr($review['author'], 0, 1)); ?></div>
              <div class="review-info">
                <strong><?php echo htmlspecialchars($review['author']); ?></strong>
                <?php if (!empty($metaLine)): ?><span><?php echo htmlspecialchars($metaLine); ?></span><?php endif; ?>
              </div>
              <?php if (!empty($review['created_at'])): ?>
              <span class="review-date"><?php echo date('M Y', strtotime($review['created_at'])); ?></span>
              <?php endif; ?>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <div class="marquee-section">
      <div class="marquee">
        <div class="marquee-track">
          <span>DESIGNED TO PERFORM</span><span class="dot">•</span>
          <span>SYMPTOM</span><span class="dot">•</span>
          <span>DESIGNED TO PERFORM</span><span class="dot">•</span>
          <span>SYMPTOM</span><span class="dot">•</span>
          <span>DESIGNED TO PERFORM</span><span class="dot">•</span>
          <span>SYMPTOM</span><span class="dot">•</span>
        </div>
      </div>
    </div>

    <section class="contact" id="contact">
      <div class="container">
        <div class="contact-inner">
          <div class="contact-left">
            <span class="section-tag">Contact</span>
            <h2 class="contact-title">
              <span class="reveal-text">Votre projet</span>
              <span class="reveal-text">commence ici</span>
            </h2>
            <p class="contact-desc">Partagez-nous votre vision. Nous reviendrons vers vous avec un plan d'action concret sous 48h. Premier échange et audit gratuits.</p>
            <div class="contact-info">
              <a href="mailto:hello@symptom.agency" class="contact-link">
                <span class="contact-link-label">Email</span>
                <span class="contact-link-value">hello@symptom.agency</span>
              </a>
              <a href="tel:+33123456789" class="contact-link">
                <span class="contact-link-label">Téléphone</span>
                <span class="contact-link-value">+33 1 23 45 67 89</span>
              </a>
            </div>
          </div>

          <form class="contact-form" id="contact-form" action="/contact-submit.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo getCSRFToken(); ?>">
            <div class="form-group">
              <label for="name">Nom</label>
              <input type="text" id="name" name="name" required aria-required="true">
              <div class="input-line"></div>
              <span class="error-message">Ce champ est requis</span>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" required aria-required="true">
              <div class="input-line"></div>
              <span class="error-message">Email invalide</span>
            </div>
            <div class="form-group">
              <label for="message">Votre projet</label>
              <textarea id="message" name="message" rows="4" required aria-required="true"></textarea>
              <div class="input-line"></div>
              <span class="error-message">Ce champ est requis</span>
            </div>
            <button type="submit" class="btn-submit"><span>Envoyer</span></button>
          </form>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container">
      <div class="footer-top">
        <div class="footer-brand">
          <img src="assets/img/logo.svg" alt="SYMPTOM" class="footer-logo">
          <p>Designed to perform.</p>
        </div>
        <div class="footer-links">
          <div class="footer-col">
            <h4>Navigation</h4>
            <a href="#hero">Accueil</a>
            <a href="#services">Services</a>
            <a href="#process">Process</a>
            <a href="#projects">Projets</a>
            <a href="#contact">Contact</a>
          </div>
          <div class="footer-col">
            <h4>Social</h4>
            <a href="https://linkedin.com" target="_blank" rel="noopener">LinkedIn</a>
            <a href="https://twitter.com" target="_blank" rel="noopener">Twitter</a>
          </div>
          <div class="footer-col">
            <h4>Légal</h4>
            <a href="mentions-legales.php">Mentions légales</a>
            <a href="confidentialite.php">Confidentialité</a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <span>© <?php echo date('Y'); ?> SYMPTOM. Tous droits réservés.</span>
      </div>
    </div>
  </footer>

  <div class="overlay-rocket" id="overlay-rocket">
      <div class="rocket-content">
        <div class="rocket-orbits">
          <span class="orbit orbit-1"></span>
          <span class="orbit orbit-2"></span>
          <span class="orbit orbit-3"></span>
        </div>
        <div class="rocket-animation">
          <div class="rocket-icon">🚀</div>
          <div class="rocket-trail"></div>
        </div>
        <div class="rocket-loader"><div class="rocket-spinner"></div></div>
        <h3>Nous sommes déjà en train de travailler sur votre projet</h3>
        <p>Nous orchestrons l'équipe et préparons un premier plan d'action.</p>
      </div>
  </div>

  <script src="assets/js/script.js"></script>
</body>
</html>

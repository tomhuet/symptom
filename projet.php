<?php
require_once 'config.php';

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
if (empty($slug)) { header('Location: /'); exit; }

$project = getProject($slug);
if (!$project) { header('HTTP/1.0 404 Not Found'); include '404.php'; exit; }

$projectReviews = array_values(getReviewsByProject($project['id']));
$allProjects = getProjects();
$otherProjects = array_slice(array_filter($allProjects, fn($p) => $p['id'] !== $project['id']), 0, 3);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php echo htmlspecialchars($project['problem']); ?>">
  <meta property="og:title" content="<?php echo htmlspecialchars($project['company']); ?> - SYMPTOM">
  <meta property="og:description" content="<?php echo htmlspecialchars($project['problem']); ?>">
  <link rel="canonical" href="<?php echo SITE_URL; ?>/projet/<?php echo $project['slug']; ?>">
  <title><?php echo htmlspecialchars($project['company']); ?> - SYMPTOM</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/styles.css">
  <link rel="stylesheet" href="/assets/css/project.css">
</head>
<body class="project-page">

  <nav class="nav" id="nav">
    <div class="nav-inner">
      <a href="/" class="nav-logo"><img src="/assets/img/logo.png" alt="SYMPTOM"></a>
      <div class="nav-links">
        <a href="/#services" class="nav-link">Services</a>
        <a href="/#projects" class="nav-link">Projets</a>
        <a href="/#contact" class="nav-link">Contact</a>
      </div>
      <a href="/#contact" class="nav-cta"><span>Nous contacter</span><div class="btn-fill"></div></a>
    </div>
  </nav>

  <header class="project-hero">
    <div class="project-hero-bg">
      <?php if (!empty($project['image'])): ?>
        <img src="/<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['company']); ?>">
      <?php endif; ?>
      <div class="project-hero-overlay"></div>
    </div>
    
    <div class="container">
      <a href="/#projects" class="back-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        <span>Retour aux projets</span>
      </a>
      
      <div class="project-hero-content">
        <div class="project-meta">
          <span class="project-sector"><?php echo htmlspecialchars($project['sector']); ?></span>
          <span class="project-year"><?php echo date('Y', strtotime($project['created_at'])); ?></span>
        </div>
        <h1 class="project-title"><?php echo htmlspecialchars($project['company']); ?></h1>
        <p class="project-problem"><?php echo htmlspecialchars($project['problem']); ?></p>
      </div>
    </div>
  </header>

  <main class="project-main">
    <div class="container">
      <div class="project-layout">
        <aside class="project-sidebar">
          <div class="sidebar-block">
            <h3>Secteur</h3>
            <p><?php echo htmlspecialchars($project['sector']); ?></p>
          </div>
          <div class="sidebar-block">
            <h3>Année</h3>
            <p><?php echo date('Y', strtotime($project['created_at'])); ?></p>
          </div>
          <?php if (!empty($projectReviews)): ?>
          <div class="sidebar-block">
            <h3>Satisfaction</h3>
            <div class="sidebar-stars">
              <?php 
              $avgRating = array_sum(array_column($projectReviews, 'rating')) / count($projectReviews);
              for ($i = 1; $i <= 5; $i++): ?>
                <span class="star <?php echo $i <= round($avgRating) ? 'filled' : ''; ?>">★</span>
              <?php endfor; ?>
            </div>
          </div>
          <?php endif; ?>
        </aside>

        <article class="project-body">
          <section class="project-section">
            <h2>Description du projet</h2>
            <div class="project-description"><?php echo $project['description']; ?></div>
          </section>

          <?php if (!empty($project['feedback'])): ?>
          <section class="project-section project-feedback">
            <h2>Retour de l'entreprise</h2>
            <blockquote>
              <p>"<?php echo nl2br(htmlspecialchars($project['feedback'])); ?>"</p>
              <cite>— <?php echo htmlspecialchars($project['company']); ?></cite>
            </blockquote>
          </section>
          <?php endif; ?>

          <?php if (!empty($projectReviews)): ?>
          <section class="project-section">
            <h2>Avis sur ce projet</h2>
            <div class="reviews-list">
              <?php foreach ($projectReviews as $review): ?>
              <div class="review-item">
                <div class="review-header">
                  <div class="review-avatar"><?php echo strtoupper(substr($review['author'], 0, 1)); ?></div>
                  <div class="review-author-info">
                    <strong><?php echo htmlspecialchars($review['author']); ?></strong>
                    <?php if (!empty($review['position'])): ?><span><?php echo htmlspecialchars($review['position']); ?></span><?php endif; ?>
                  </div>
                  <div class="review-rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                      <span class="star <?php echo $i <= $review['rating'] ? 'filled' : ''; ?>">★</span>
                    <?php endfor; ?>
                  </div>
                </div>
                <p class="review-text">"<?php echo htmlspecialchars($review['content']); ?>"</p>
              </div>
              <?php endforeach; ?>
            </div>
          </section>
          <?php endif; ?>
        </article>
      </div>

      <?php if (!empty($otherProjects)): ?>
      <section class="other-projects">
        <h2>Autres projets</h2>
        <div class="other-projects-grid">
          <?php foreach ($otherProjects as $op): ?>
          <a href="/projet/<?php echo htmlspecialchars($op['slug']); ?>" class="other-project-card">
            <div class="other-project-image">
              <?php if (!empty($op['image'])): ?>
                <img src="/<?php echo htmlspecialchars($op['image']); ?>" alt="<?php echo htmlspecialchars($op['company']); ?>" loading="lazy">
              <?php else: ?>
                <div class="image-placeholder"><?php echo strtoupper(substr($op['company'], 0, 2)); ?></div>
              <?php endif; ?>
            </div>
            <div class="other-project-info">
              <span class="other-project-sector"><?php echo htmlspecialchars($op['sector']); ?></span>
              <h3><?php echo htmlspecialchars($op['company']); ?></h3>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </section>
      <?php endif; ?>

      <section class="project-cta">
        <h2>Vous avez un projet similaire ?</h2>
        <p>Discutons de vos besoins et trouvons ensemble la meilleure solution.</p>
        <a href="/#contact" class="btn-primary">
          <span>Nous contacter</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </section>
    </div>
  </main>

  <footer class="footer footer-simple">
    <div class="container">
      <div class="footer-bottom">
        <span>© <?php echo date('Y'); ?> SYMPTOM</span>
        <a href="/">Retour à l'accueil</a>
      </div>
    </div>
  </footer>

  <script src="/assets/js/script.js"></script>
</body>
</html>

<?php require_once 'config.php'; http_response_code(404); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>Page non trouvée - SYMPTOM</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/styles.css">
  <style>
    .error-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 40px; }
    .error-container { max-width: 600px; }
    .error-container h1 { font-size: clamp(4rem, 12vw, 10rem); font-weight: 900; line-height: 1; background: linear-gradient(90deg, #a855f7 0%, #6366f1 50%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 24px; }
    .error-container h2 { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 700; margin-bottom: 16px; }
    .error-container p { color: var(--gray-400); font-size: 1.125rem; margin-bottom: 40px; line-height: 1.6; }
    .error-links { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
  </style>
</head>
<body class="error-page">
  <div class="error-container">
    <h1>404</h1>
    <h2>Page non trouvée</h2>
    <p>Désolé, la page que vous recherchez n'existe pas ou a été déplacée. Retournez à l'accueil ou explorez nos services.</p>
    <div class="error-links">
      <a href="/" class="btn-primary">
        <span>Retour à l'accueil</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      </a>
      <a href="/#contact" class="btn-outline">
        <span>Nous contacter</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      </a>
    </div>
  </div>
</body>
</html>

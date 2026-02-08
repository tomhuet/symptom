# SYMPTOM - Agence Produit & Tech

Site web professionnel pour SYMPTOM, agence spécialisée en développement, IA et automatisation.

## 🚀 Fonctionnalités

- **Design moderne et responsive** : Interface élégante avec animations fluides
- **Performance optimisée** : Caching, compression, lazy loading
- **Sécurité renforcée** : CSRF protection, input sanitization, headers de sécurité
- **SEO optimisé** : Meta tags, Schema.org, sitemap
- **Accessibilité** : ARIA labels, navigation clavier, support reduced motion
- **Formulaires intelligents** : Validation en temps réel, notifications élégantes

## 📋 Prérequis

- PHP 7.4 ou supérieur
- Apache avec mod_rewrite activé
- Extensions PHP : json, fileinfo, mbstring

## 🛠️ Installation

1. Cloner le repository
```bash
git clone https://github.com/tomhuet/symptom.git
cd symptom
```

2. Configurer les permissions
```bash
chmod 755 data/ uploads/
```

3. Configurer l'environnement
   - Modifier `config.php` pour ajuster les paramètres
   - Utiliser des variables d'environnement pour les données sensibles en production

4. Construire les assets minifiés (optionnel)
```bash
php build-assets.php
```

## 📁 Structure du projet

```
symptom/
├── assets/
│   ├── css/          # Fichiers CSS
│   ├── js/           # Fichiers JavaScript
│   └── img/          # Images
├── data/             # Données JSON (projets, avis)
├── uploads/          # Images uploadées
├── index.php         # Page d'accueil
├── projet.php        # Page projet
├── contact-submit.php # Traitement formulaire
├── config.php        # Configuration globale
├── .htaccess         # Configuration Apache
└── README.md         # Documentation
```

## 🔒 Sécurité

### Mesures implémentées

- **CSRF Protection** : Tokens pour tous les formulaires
- **Input Sanitization** : Filtrage et validation des données utilisateur
- **Security Headers** : CSP, X-Frame-Options, X-XSS-Protection
- **Session Security** : Configuration sécurisée des cookies
- **File Upload Validation** : Vérification MIME type et taille
- **Protected Directories** : .htaccess pour /data et fichiers sensibles

### Bonnes pratiques

1. **Ne jamais committer de données sensibles**
2. **Utiliser HTTPS en production**
3. **Changer le mot de passe admin par défaut**
4. **Vérifier régulièrement les logs de contact**

## ⚡ Performance

### Optimisations implémentées

- **Caching** : Cache fichier pour projets/avis (5 min)
- **Compression Gzip** : Activée via .htaccess
- **Browser Caching** : Headers Cache-Control configurés
- **Resource Hints** : Preconnect, preload pour ressources critiques
- **Lazy Loading** : Images chargées à la demande
- **Minification** : Script de build pour CSS/JS

### Améliorer les performances

1. Activer OPcache en production
2. Utiliser Redis/Memcached pour le cache
3. Optimiser les images (WebP, compression)
4. Utiliser un CDN pour les assets statiques

## 🎨 Personnalisation

### Modifier les couleurs

Éditer les variables CSS dans `assets/css/styles.css` :

```css
:root {
  --black: #000;
  --white: #fff;
  --gray-900: #171717;
  /* ... autres couleurs */
}
```

### Ajouter des projets

Les projets sont stockés dans `data/projects.json`. Structure :

```json
{
  "id": "unique-id",
  "slug": "project-slug",
  "company": "Nom entreprise",
  "sector": "Secteur",
  "problem": "Description courte",
  "description": "Description complète",
  "image": "uploads/image.jpg",
  "created_at": "2025-01-01 00:00:00"
}
```

## 📧 Configuration Email

Le formulaire de contact utilise la fonction `mail()` de PHP. En production :

1. Configurer un SMTP relay
2. Ou utiliser une API email (SendGrid, Mailgun, etc.)
3. Les messages sont sauvegardés dans `data/contacts/` en backup

## 🌐 Déploiement

### Production Checklist

- [ ] Changer le mot de passe admin
- [ ] Activer HTTPS (modifier .htaccess ligne 5-6)
- [ ] Vérifier les permissions des dossiers
- [ ] Configurer le SMTP pour les emails
- [ ] Activer OPcache
- [ ] Tester les formulaires
- [ ] Valider le SEO (Google Search Console)
- [ ] Tester la performance (PageSpeed Insights)

### Variables d'environnement (recommandé)

```php
// Au lieu de valeurs hardcodées dans config.php
define('ADMIN_PASSWORD', getenv('ADMIN_PASSWORD'));
define('SMTP_HOST', getenv('SMTP_HOST'));
```

## 🧪 Tests

### Tests manuels

1. Tester tous les formulaires
2. Vérifier la navigation mobile
3. Tester sur différents navigateurs
4. Valider l'accessibilité (WAVE, axe)
5. Tester les performances (Lighthouse)

## 📝 Maintenance

### Tâches régulières

- Vérifier les logs de contact
- Nettoyer le cache si nécessaire
- Mettre à jour les projets et avis
- Vérifier les backups
- Surveiller les erreurs PHP

### Nettoyage du cache

```bash
rm -f data/cache_*.json
```

## 🤝 Contribution

Pour contribuer :

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📄 Licence

Propriété de SYMPTOM. Tous droits réservés.

## 🔗 Liens utiles

- [Site web](https://www.symptom.agency)
- Email : hello@symptom.agency

---

**Designed to Perform** 🚀

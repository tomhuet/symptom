document.addEventListener('DOMContentLoaded', function() {
  
  var loader = document.getElementById('loader');
  if (loader) {
    setTimeout(function() {
      loader.style.opacity = '0';
      loader.style.visibility = 'hidden';
      loader.style.pointerEvents = 'none';
    }, 2500);
  }
  
  function initRotatingWords() {
    var container = document.getElementById('rotating-words');
    if (!container) return;
    
    var words = container.querySelectorAll('.rotating-word');
    if (words.length === 0) return;
    
    var currentIndex = 0;
    var totalWords = words.length;
    
    function rotateWord() {
      var currentWord = words[currentIndex];
      var nextIndex = currentIndex + 1;
      
      if (nextIndex >= totalWords) return;
      
      var nextWord = words[nextIndex];
      
      currentWord.style.opacity = '0';
      currentWord.style.transform = 'translateY(-100%)';
      
      setTimeout(function() {
        currentWord.classList.remove('active');
        nextWord.classList.add('active');
        nextWord.style.opacity = '1';
        nextWord.style.transform = 'translateY(0)';
      }, 300);
      
      currentIndex = nextIndex;
      
      if (currentIndex < totalWords - 1) {
        setTimeout(rotateWord, 2000);
      }
    }
    
    setTimeout(function() {
      rotateWord();
    }, 4000);
  }
  
  initRotatingWords();
  
  var nav = document.getElementById('nav');
  var mobileToggle = document.getElementById('mobile-toggle');
  var mobileMenu = document.getElementById('mobile-menu');
  
  if (nav) {
    window.addEventListener('scroll', function() {
      if (window.scrollY > 50) {
        nav.classList.add('scrolled');
      } else {
        nav.classList.remove('scrolled');
      }
    });
  }
  
  if (mobileToggle && mobileMenu) {
    mobileToggle.addEventListener('click', function() {
      mobileToggle.classList.toggle('active');
      mobileMenu.classList.toggle('active');
    });
    
    var mobileLinks = mobileMenu.querySelectorAll('.mobile-link');
    for (var i = 0; i < mobileLinks.length; i++) {
      mobileLinks[i].addEventListener('click', function() {
        mobileToggle.classList.remove('active');
        mobileMenu.classList.remove('active');
      });
    }
  }
  
  var revealTexts = document.querySelectorAll('.reveal-text');
  
  function checkReveal() {
    for (var i = 0; i < revealTexts.length; i++) {
      var el = revealTexts[i];
      var rect = el.getBoundingClientRect();
      if (rect.top < window.innerHeight * 0.85) {
        el.classList.add('visible');
      }
    }
  }
  
  window.addEventListener('scroll', checkReveal);
  checkReveal();
  
  var heroForm = document.getElementById('hero-form');
  var contactForm = document.getElementById('contact-form');
  var overlayRocket = document.getElementById('overlay-rocket');
  
// Improved notification system
function showNotification(message, type = 'success') {
  const notification = document.createElement('div');
  notification.className = `notification ${type}`;
  notification.innerHTML = `
    <div class="notification-header">
      <div class="notification-icon">${type === 'success' ? '✓' : '✗'}</div>
      <div class="notification-title">${type === 'success' ? 'Succès' : 'Erreur'}</div>
    </div>
    <div class="notification-message">${message}</div>
  `;
  document.body.appendChild(notification);
  
  setTimeout(function() { notification.classList.add('show'); }, 100);
  setTimeout(function() {
    notification.classList.remove('show');
    setTimeout(function() { notification.remove(); }, 400);
  }, 5000);
}

// Form validation helper
function validateEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validateForm(form) {
  var isValid = true;
  var inputs = form.querySelectorAll('input[required], textarea[required]');
  
  for (var i = 0; i < inputs.length; i++) {
    var input = inputs[i];
    var group = input.closest('.form-group');
    var value = input.value.trim();
    
    if (!value) {
      if (group) group.classList.add('error');
      isValid = false;
    } else if (input.type === 'email' && !validateEmail(value)) {
      if (group) group.classList.add('error');
      isValid = false;
    } else {
      if (group) group.classList.remove('error');
    }
  }
  
  return isValid;
}

// Enhanced form submission with AJAX
function handleFormSubmit(e) {
  e.preventDefault();
  var form = e.target;
  
  if (!validateForm(form)) {
    showNotification('Veuillez remplir tous les champs correctement', 'error');
    return;
  }
  
  var submitBtn = form.querySelector('.form-btn, .btn-submit');
  if (submitBtn) {
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;
  }
  
  var formData = new FormData(form);
  
  fetch('/contact-submit.php', {
    method: 'POST',
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(function(response) { return response.json(); })
  .then(function(data) {
    if (data.success) {
      showNotification('Votre message a été envoyé avec succès!', 'success');
      form.reset();
      
      if (overlayRocket) {
        overlayRocket.classList.add('active');
        setTimeout(function() {
          overlayRocket.classList.remove('active');
        }, 3000);
      }
    } else {
      var errorMsg = data.errors ? data.errors.join(', ') : 'Une erreur est survenue';
      showNotification(errorMsg, 'error');
    }
  })
  .catch(function(error) {
    showNotification('Erreur réseau. Veuillez réessayer.', 'error');
  })
  .finally(function() {
    if (submitBtn) {
      submitBtn.classList.remove('loading');
      submitBtn.disabled = false;
    }
  });
}
  
  // Real-time input validation
  var allInputs = document.querySelectorAll('.form-group input, .form-group textarea');
  for (var i = 0; i < allInputs.length; i++) {
    allInputs[i].addEventListener('blur', function() {
      var group = this.closest('.form-group');
      var value = this.value.trim();
      
      if (this.hasAttribute('required') && !value) {
        if (group) group.classList.add('error');
      } else if (this.type === 'email' && value && !validateEmail(value)) {
        if (group) group.classList.add('error');
      } else {
        if (group) group.classList.remove('error');
      }
    });
    
    allInputs[i].addEventListener('input', function() {
      var group = this.closest('.form-group');
      if (group && group.classList.contains('error')) {
        group.classList.remove('error');
      }
    });
  }
  
  // Check for success/error messages in URL
  var urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('sent') === '1') {
    showNotification('Votre message a été envoyé avec succès!', 'success');
  } else if (urlParams.get('error')) {
    var errorType = urlParams.get('error');
    var errorMsg = errorType === 'csrf' ? 'Erreur de sécurité. Veuillez réessayer.' : 'Une erreur est survenue';
    showNotification(errorMsg, 'error');
  }
  
  if (heroForm) heroForm.addEventListener('submit', handleFormSubmit);
  if (contactForm) contactForm.addEventListener('submit', handleFormSubmit);
  
  var clientBtn = document.getElementById('client-btn');
  if (clientBtn) {
    clientBtn.addEventListener('click', function(e) {
      e.preventDefault();
      window.location.href = '/admin/';
    });
  }
  
  var anchors = document.querySelectorAll('a[href^="#"]');
  for (var i = 0; i < anchors.length; i++) {
    anchors[i].addEventListener('click', function(e) {
      var href = this.getAttribute('href');
      if (href === '#') return;
      var target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        var navHeight = nav ? nav.offsetHeight : 0;
        window.scrollTo({
          top: target.offsetTop - navHeight,
          behavior: 'smooth'
        });
      }
    });
  }
  
  var stackingCards = document.querySelectorAll('.stacking-card');
  
  function updateStackingCards() {
    for (var i = 0; i < stackingCards.length; i++) {
      var card = stackingCards[i];
      var rect = card.getBoundingClientRect();
      if (rect.top < 120) {
        var scale = Math.max(0.92, 1 - (120 - rect.top) * 0.0003);
        var opacity = Math.max(0.6, 1 - (120 - rect.top) * 0.002);
        card.style.transform = 'scale(' + scale + ')';
        card.style.opacity = opacity;
      } else {
        card.style.transform = 'scale(1)';
        card.style.opacity = '1';
      }
    }
  }
  
  if (stackingCards.length > 0) {
    window.addEventListener('scroll', updateStackingCards);
  }
});

// Performance: Throttle function for scroll events
function throttle(func, wait) {
  var timeout;
  var previous = 0;
  return function() {
    var now = Date.now();
    var remaining = wait - (now - previous);
    var context = this;
    var args = arguments;
    
    if (remaining <= 0 || remaining > wait) {
      if (timeout) {
        clearTimeout(timeout);
        timeout = null;
      }
      previous = now;
      func.apply(context, args);
    } else if (!timeout) {
      timeout = setTimeout(function() {
        previous = Date.now();
        timeout = null;
        func.apply(context, args);
      }, remaining);
    }
  };
}

// Performance: Use throttled scroll handlers
window.addEventListener('scroll', throttle(checkReveal, 200));
if (stackingCards.length > 0) {
  window.addEventListener('scroll', throttle(updateStackingCards, 100));
}

// Accessibility: Handle keyboard navigation for mobile menu
if (mobileMenu) {
  var firstFocusable = mobileMenu.querySelector('.mobile-link');
  var focusableElements = mobileMenu.querySelectorAll('.mobile-link');
  var lastFocusable = focusableElements[focusableElements.length - 1];
  
  mobileMenu.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      mobileToggle.classList.remove('active');
      mobileMenu.classList.remove('active');
      mobileToggle.focus();
    }
    
    if (e.key === 'Tab') {
      if (e.shiftKey && document.activeElement === firstFocusable) {
        e.preventDefault();
        lastFocusable.focus();
      } else if (!e.shiftKey && document.activeElement === lastFocusable) {
        e.preventDefault();
        firstFocusable.focus();
      }
    }
  });
}

// Preload critical resources on interaction
var hasInteracted = false;
function preloadResources() {
  if (hasInteracted) return;
  hasInteracted = true;
  
  // Preload images that are below the fold
  var lazyImages = document.querySelectorAll('img[loading="lazy"]');
  for (var i = 0; i < Math.min(3, lazyImages.length); i++) {
    var img = new Image();
    img.src = lazyImages[i].src;
  }
}

// Trigger preload on first interaction
['mousemove', 'scroll', 'keydown', 'click', 'touchstart'].forEach(function(event) {
  document.addEventListener(event, preloadResources, { once: true, passive: true });
});

// Add loading class to body when page is still loading
if (document.readyState === 'loading') {
  document.body.classList.add('page-loading');
}

window.addEventListener('load', function() {
  document.body.classList.remove('page-loading');
  
  // Performance: Report Web Vitals if available (for monitoring)
  if (window.performance && window.performance.getEntriesByType) {
    var paintMetrics = performance.getEntriesByType('paint');
    if (paintMetrics.length > 0) {
      console.log('Page Performance:', {
        'First Paint': paintMetrics[0].startTime + 'ms',
        'First Contentful Paint': paintMetrics[paintMetrics.length - 1].startTime + 'ms'
      });
    }
  }
});

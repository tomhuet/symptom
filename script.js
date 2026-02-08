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
  
  function handleFormSubmit(e) {
    e.preventDefault();
    var submitBtn = e.target.querySelector('.form-btn, .btn-submit');
    if (submitBtn) {
      submitBtn.classList.add('loading');
    }
    setTimeout(function() {
      if (overlayRocket) {
        overlayRocket.classList.add('active');
      }
      setTimeout(function() {
        window.location.href = '/?sent=1#contact';
      }, 3000);
    }, 500);
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

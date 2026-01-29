// Menu Responsivo Moderno
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    const header = document.querySelector('.header');
    
    // Toggle menu
    menuToggle.addEventListener('click', function() {
        navLinks.classList.toggle('active');
        menuToggle.querySelector('i').classList.toggle('fa-bars');
        menuToggle.querySelector('i').classList.toggle('fa-times');
        document.body.classList.toggle('no-scroll');
    });
    
    // Fechar menu ao clicar em um link
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('active');
            menuToggle.querySelector('i').classList.add('fa-bars');
            menuToggle.querySelector('i').classList.remove('fa-times');
            document.body.classList.remove('no-scroll');
        });
    });
    
    // Header scroll effect
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
    
    // Slider de Imagens Moderno
    const slides = document.querySelectorAll('.slide');
    if (slides.length > 0) {
        let currentSlide = 0;
        const totalSlides = slides.length;
        let slideInterval;
        
        function initSlider() {
            // Configurar slides
            slides.forEach((slide, index) => {
                if (index === 0) {
                    slide.classList.add('active');
                } else {
                    slide.classList.remove('active');
                }
            });
            
            // Iniciar autoplay
            startAutoSlide();
            
            // Pausar autoplay ao passar o mouse
            const heroSection = document.querySelector('.hero');
            if (heroSection) {
                heroSection.addEventListener('mouseenter', pauseAutoSlide);
                heroSection.addEventListener('mouseleave', startAutoSlide);
            }
        }
        
        function nextSlide() {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % totalSlides;
            slides[currentSlide].classList.add('active');
        }
        
        function startAutoSlide() {
            clearInterval(slideInterval);
            slideInterval = setInterval(nextSlide, 6000); // Aumentado para 6 segundos
        }
        
        function pauseAutoSlide() {
            clearInterval(slideInterval);
        }
        
        initSlider();
    }
    
    // Smooth Scrolling moderno
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Animações ao rolar
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                
                // Animar números na seção sobre
                if (entry.target.classList.contains('stat-number')) {
                    animateCounter(entry.target);
                }
            }
        });
    }, observerOptions);
    
    // Observar elementos para animação
    document.querySelectorAll('.pilar-card, .valor-card, .evento-card, .sobre-card, .stat-number').forEach(el => {
        observer.observe(el);
    });
    
    // Animação de contador
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-count'));
        const suffix = element.textContent.includes('+') ? '+' : '';
        const duration = 2000; // 2 segundos
        const increment = target / (duration / 16); // 60fps
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target + suffix;
                element.classList.add('animated');
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current) + suffix;
            }
        }, 16);
    }
    
    // Efeito de brilho no logo IEIMA
    const ieimaTitle = document.querySelector('.ieima-title');
    if (ieimaTitle) {
        ieimaTitle.addEventListener('mouseenter', function() {
            this.style.background = 'linear-gradient(to right, var(--azul-brilho) 0%, var(--branco) 100%)';
            this.style.webkitBackgroundClip = 'text';
            this.style.backgroundClip = 'text';
            this.style.transition = 'background 0.5s ease';
        });
        
        ieimaTitle.addEventListener('mouseleave', function() {
            this.style.background = 'linear-gradient(to right, var(--branco) 0%, var(--azul-neve) 100%)';
            this.style.webkitBackgroundClip = 'text';
            this.style.backgroundClip = 'text';
        });
    }
    
    // Efeito parallax suave
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero');
        
        if (hero) {
            hero.style.transform = `translateY(${scrolled * 0.1}px)`;
        }
    });
    
    // Preloader (opcional)
    window.addEventListener('load', function() {
        const preloader = document.createElement('div');
        preloader.className = 'preloader';
        preloader.innerHTML = `
            <div class="preloader-content">
                <div class="spinner"></div>
                <div class="loading-text">IEIMA</div>
            </div>
        `;
        
        // Adicionar preloader ao corpo
        document.body.appendChild(preloader);
        
        // Remover após carregamento
        setTimeout(() => {
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.remove();
            }, 500);
        }, 1000);
        
        // Adicionar estilos para o preloader
        const preloaderStyles = document.createElement('style');
        preloaderStyles.textContent = `
            .preloader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: var(--azul-profundo);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
                transition: opacity 0.5s ease;
            }
            
            .preloader-content {
                text-align: center;
            }
            
            .spinner {
                width: 60px;
                height: 60px;
                border: 4px solid rgba(255, 255, 255, 0.1);
                border-top-color: var(--azul-brilho);
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: 0 auto 20px;
            }
            
            .loading-text {
                font-family: 'Montserrat', sans-serif;
                font-size: 24px;
                font-weight: 900;
                color: var(--azul-brilho);
                letter-spacing: 2px;
                animation: pulse 1.5s ease-in-out infinite;
            }
            
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
            
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.5; }
            }
            
            .no-scroll {
                overflow: hidden;
            }
        `;
        document.head.appendChild(preloaderStyles);
    });
});
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') Ulbi Fest</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Exo+2:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --neon-blue: #00f3ff;
            --neon-purple: #b967ff;
            --dark-bg: #0a0a1f;
            --card-bg: rgba(16, 18, 37, 0.8);
        }
        
        body {
            font-family: 'Exo 2', sans-serif;
            background: linear-gradient(135deg, var(--dark-bg) 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
            color: white;
        }
        
        .neon-text {
            text-shadow: 0 0 10px var(--neon-blue), 0 0 20px var(--neon-blue), 0 0 30px var(--neon-blue);
        }
        
        .neon-border {
            border: 2px solid var(--neon-blue);
            box-shadow: 0 0 15px var(--neon-blue), inset 0 0 15px var(--neon-blue);
        }
        
        .glow-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 243, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 243, 255, 0.1);
        }
        
        .holographic-effect {
            background: linear-gradient(45deg, 
                rgba(0, 243, 255, 0.1) 0%, 
                rgba(185, 103, 255, 0.1) 50%, 
                rgba(0, 243, 255, 0.1) 100%);
        }
    </style>
</head>
<body class="min-h-screen">
    @yield('content')
    
    <script>
        // Particle background effect
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.createElement('canvas');
            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            canvas.style.zIndex = '-1';
            document.body.appendChild(canvas);
            
            const ctx = canvas.getContext('2d');
            let particles = [];
            
            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            
            class Particle {
                constructor() {
                    this.reset();
                }
                
                reset() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.vx = (Math.random() - 0.5) * 2;
                    this.vy = (Math.random() - 0.5) * 2;
                    this.radius = Math.random() * 2;
                    this.alpha = Math.random() * 0.5 + 0.2;
                }
                
                update() {
                    this.x += this.vx;
                    this.y += this.vy;
                    
                    if (this.x < 0 || this.x > canvas.width || this.y < 0 || this.y > canvas.height) {
                        this.reset();
                    }
                }
                
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(0, 243, 255, ${this.alpha})`;
                    ctx.fill();
                }
            }
            
            function initParticles() {
                particles = [];
                for (let i = 0; i < 100; i++) {
                    particles.push(new Particle());
                }
            }
            
            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                particles.forEach(particle => {
                    particle.update();
                    particle.draw();
                });
                
                requestAnimationFrame(animate);
            }
            
            resizeCanvas();
            initParticles();
            animate();
            
            window.addEventListener('resize', resizeCanvas);
        });
    </script>
</body>
</html>
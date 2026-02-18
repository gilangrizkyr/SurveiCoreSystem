<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy"
        content="default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; connect-src 'self' https://cdn.jsdelivr.net; img-src 'self' data: https:; font-src 'self' data: https://fonts.gstatic.com;">
    <title>SurveyCore | Platform Infrastruktur Survei Terpusat</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <!-- Chart.js for stats -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <!-- Three.js -->
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/build/three.min.js"></script>
    <!-- Marked.js for Markdown rendering -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
</head>

<body>
    <!-- 3D Background Container -->
    <div id="canvas-container"></div>

    <!-- Navbar -->
    <nav class="glass-nav fade-in-down">
        <a href="/" class="logo">SurveyCore<span class="dot">.</span></a>
        <div class="nav-links">
            <a href="#stats">Statistik</a>
            <a href="#features">Keunggulan</a>
            <a href="#how-it-works">Cara Kerja</a>
            <a href="/api/v1">Dokumentasi API</a>
        </div>
        <a href="/admin/login" class="btn btn-primary glow-effect">Masuk Panel</a>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="badge fade-in-up">🚀 Infrastruktur Survei Generasi Terbaru</div>
            <h1 class="title fade-in-up delay-100">
                Pengambilan Keputusan <br>
                <span class="text-gradient">Berbasis Data Akurat.</span>
            </h1>
            <p class="subtitle fade-in-up delay-200">
                Platform survei terpusat dengan performa tinggi.
                Skalabilitas tanpa batas, keamanan enterprise, dan integrasi API yang seamless.
            </p>
            <div class="cta-group fade-in-up delay-300">
                <a href="/admin" class="btn btn-primary glow-effect">
                    Mulai Sekarang
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="#stats" class="btn btn-outline glass-hover">
                    Lihat Data Publik
                </a>
            </div>
        </div>
    </section>

    <!-- Tenant Ecosystem Section -->
    <section class="ecosystem-section fade-in-up">
        <div class="container">
            <p class="ecosystem-label">Aplikasi yang Terintegrasi</p>
            <div class="tenant-slider" id="tenantSlider">
                <!-- Data loaded via JS -->
                <div class="loading-spinner"></div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="section-glass">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Statistik <span class="text-gradient">Real-Time</span></h2>
                <p class="section-subtitle">Transparansi data publik yang diperbarui secara langsung dari seluruh
                    instansi terdaftar.</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card glass fade-in-up delay-100">
                    <div class="stat-icon-bg">📊</div>
                    <div class="stat-content">
                        <div class="stat-value text-gradient-blue" id="totalSurveys">0</div>
                        <div class="stat-label">Survei Aktif</div>
                    </div>
                </div>

                <div class="stat-card glass fade-in-up delay-200">
                    <div class="stat-icon-bg">✅</div>
                    <div class="stat-content">
                        <div class="stat-value text-gradient-green" id="totalResponses">0</div>
                        <div class="stat-label">Total Respons</div>
                    </div>
                </div>

                <div class="stat-card glass fade-in-up delay-300">
                    <div class="stat-icon-bg">🏢</div>
                    <div class="stat-content">
                        <div class="stat-value text-gradient-purple" id="totalOrgs">0</div>
                        <div class="stat-label">Organisasi</div>
                    </div>
                </div>

                <div class="stat-card glass fade-in-up delay-400">
                    <div class="stat-icon-bg">📈</div>
                    <div class="stat-content">
                        <div class="stat-value text-gradient-orange" id="responseRate">0</div>
                        <div class="stat-label">Partisipasi (%)</div>
                    </div>
                </div>
            </div>

            <!-- Charts & Popular Surveys Grid -->
            <div class="chart-grid">
                <!-- Chart Section -->
                <div class="glass-panel fade-in-up">
                    <h3 class="panel-title">Tren Respons Bulanan</h3>
                    <div class="chart-container">
                        <canvas id="responseChart"></canvas>
                    </div>
                </div>

                <!-- Popular Surveys -->
                <div class="glass-panel fade-in-up delay-100">
                    <h3 class="panel-title">Survei Terpopuler</h3>
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Survei</th>
                                    <th>Respons</th>
                                    <th>Sentimen AI</th>
                                </tr>
                            </thead>
                            <tbody id="popularSurveysTable">
                                <!-- Data loaded via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="section-dark">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Cara Kerja <span class="text-gradient">Platform</span></h2>
                <p class="section-subtitle">Alur kerja otomatis untuk efisiensi maksimal.</p>
            </div>

            <div class="steps-grid">
                <div class="step-card glass fade-in-up delay-100">
                    <div class="step-number">01</div>
                    <h3>Buat Survei</h3>
                    <p>Desain kuesioner interaktif dengan builder drag-and-drop yang intuitif.</p>
                </div>
                <div class="step-card glass fade-in-up delay-200">
                    <div class="step-number">02</div>
                    <h3>Sebarkan</h3>
                    <p>Distribusikan via Link, QR Code, atau Embed API ke website instansi Anda.</p>
                </div>
                <div class="step-card glass fade-in-up delay-300">
                    <div class="step-number">03</div>
                    <h3>Analisis</h3>
                    <p>Monitor hasil secara real-time dengan visualisasi data bertenaga AI.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section-glass">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2 class="section-title">Teknologi <span class="text-gradient">Unggulan</span></h2>
                <p class="section-subtitle">Didukung arsitektur modern untuk masa depan.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card glass fade-in-up delay-100">
                    <div class="icon-wrapper">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                        </svg>
                    </div>
                    <h3>Multi-Tenant Architecture</h3>
                    <p>Isolasi data level kernel untuk keamanan dan privasi data mutlak antar instansi.</p>
                </div>
                <div class="feature-card glass fade-in-up delay-200">
                    <div class="icon-wrapper">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                        </svg>
                    </div>
                    <h3>API-First Core</h3>
                    <p>Bukan sekadar website, tapi engine API yang siap diintegrasikan dengan Smart City.</p>
                </div>
                <div class="feature-card glass fade-in-up delay-300">
                    <div class="icon-wrapper">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
                        </svg>
                    </div>
                    <h3>AI Analytics</h3>
                    <p>Analisis sentimen otomatis dan deteksi anomali pada data respons survei.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Chatbot Widget -->
    <div class="chat-widget bounce-in">
        <div class="chat-window glass" id="chatWindow">
            <div class="chat-header">
                <div class="status-pulse"></div>
                <div class="chat-title">
                    <span>Asisten AI</span>
                    <span class="chat-subtitle">Online</span>
                </div>
            </div>
            <div class="chat-messages custom-scrollbar" id="chatMessages">
                <div class="message ai fade-in">
                    Halo! 👋 Saya siap bantu menjelaskan fitur atau data platform ini.
                </div>
            </div>
            <div class="chat-input-area">
                <input type="text" id="chatInput" placeholder="Ketik pesan..." autocomplete="off">
                <button class="send-btn" id="sendBtn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="chat-button glow-effect" id="chatBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
            </svg>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-glass">
        <div class="container">
            <div class="footer-grid">
                <div class="brand-col">
                    <a href="/" class="logo">SurveyCore<span class="dot">.</span></a>
                    <p>Platform infrastruktur survei terpusat untuk modernisasi pengumpulan data instansi pemerintah dan
                        swasta.</p>
                </div>
                <div class="links-col">
                    <h4>Platform</h4>
                    <a href="#stats">Statistik</a>
                    <a href="#features">Keunggulan</a>
                    <a href="#how-it-works">Cara Kerja</a>
                </div>
                <div class="links-col">
                    <h4>Developer</h4>
                    <a href="/api/v1">REST API</a>
                    <a href="/status">System Status</a>
                    <a href="/changelog">Changelog</a>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} SurveyCore Platform. Hak Cipta Dilindungi Undang-Undang.
            </div>
        </div>
    </footer>

    <script>
        // --------------------------------------------------
        // 3D Network Animation (Professional & Modern)
        // --------------------------------------------------
        const init3D = () => {
            const container = document.getElementById('canvas-container');
            const scene = new THREE.Scene();

            // Fog for depth
            scene.fog = new THREE.FogExp2(0x0f172a, 0.002);

            const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.z = 20;

            const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            // container.appendChild(renderer.domElement);
            if (container) {
                container.appendChild(renderer.domElement);
            } else {
                console.error('Canvas container not found');
                return;
            }

            // Particles
            const geometry = new THREE.BufferGeometry();
            const particlesCount = 70; // Professional amount, not too crowded
            const posArray = new Float32Array(particlesCount * 3);

            for (let i = 0; i < particlesCount * 3; i++) {
                posArray[i] = (Math.random() - 0.5) * 50;
            }

            geometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));

            // Material
            const material = new THREE.PointsMaterial({
                size: 0.15,
                color: 0x6366f1, // Primary color
                transparent: true,
                opacity: 0.8,
            });

            // Mesh
            const particlesMesh = new THREE.Points(geometry, material);
            scene.add(particlesMesh);

            // Lines connecting particles
            const lineMaterial = new THREE.LineBasicMaterial({
                color: 0x6366f1,
                transparent: true,
                opacity: 0.15
            });

            const linesGeometry = new THREE.BufferGeometry();
            const linesMesh = new THREE.LineSegments(linesGeometry, lineMaterial);
            scene.add(linesMesh);

            // Animation Loop
            let mouseX = 0;
            let mouseY = 0;

            // Smooth mouse movement
            document.addEventListener('mousemove', (event) => {
                mouseX = event.clientX / window.innerWidth - 0.5;
                mouseY = event.clientY / window.innerHeight - 0.5;
            });

            const clock = new THREE.Clock();

            const animate = () => {
                requestAnimationFrame(animate);
                const elapsedTime = clock.getElapsedTime();

                // Rotate entire system slowly
                particlesMesh.rotation.y = elapsedTime * 0.05;
                particlesMesh.rotation.x = elapsedTime * 0.02;
                linesMesh.rotation.y = elapsedTime * 0.05;
                linesMesh.rotation.x = elapsedTime * 0.02;

                // Mouse interaction
                camera.position.x += (mouseX * 10 - camera.position.x) * 0.05;
                camera.position.y += (-mouseY * 10 - camera.position.y) * 0.05;
                camera.lookAt(scene.position);

                // Update lines
                updateLines();

                renderer.render(scene, camera);
            };

            function updateLines() {
                const positions = particlesMesh.geometry.attributes.position.array;
                const linePositions = [];

                // Simple version: Connect points that are close in the static buffer.

                for (let i = 0; i < particlesCount; i++) {
                    for (let j = i + 1; j < particlesCount; j++) {
                        const dist = Math.sqrt(
                            Math.pow(positions[i * 3] - positions[j * 3], 2) +
                            Math.pow(positions[i * 3 + 1] - positions[j * 3 + 1], 2) +
                            Math.pow(positions[i * 3 + 2] - positions[j * 3 + 2], 2)
                        );

                        if (dist < 8) { // Connection threshold
                            linePositions.push(
                                positions[i * 3], positions[i * 3 + 1], positions[i * 3 + 2],
                                positions[j * 3], positions[j * 3 + 1], positions[j * 3 + 2]
                            );
                        }
                    }
                }

                linesMesh.geometry.setAttribute('position', new THREE.Float32BufferAttribute(linePositions, 3));
            }

            animate();

            // Resize
            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });
        };

        // Initialize 3D on load
        document.addEventListener('DOMContentLoaded', init3D);


        // --------------------------------------------------
        // Stats & Logic
        // --------------------------------------------------

        // Fetch Public Stats
        let responseChart = null;

        async function loadStats() {
            try {
                const response = await fetch('/api/public/stats');
                const result = await response.json();

                if (result.success) {
                    const data = result.data;

                    animateValue('totalSurveys', 0, data.total_surveys, 2000);
                    animateValue('totalResponses', 0, data.total_responses, 2000);
                    animateValue('totalOrgs', 0, data.total_organizations, 2000);
                    document.getElementById('responseRate').textContent = data.response_rate.toFixed(1);

                    createResponseChart(data.monthly_responses);
                    showPopularSurveys(data.popular_surveys);
                    showTenants(data.active_tenants);
                }
            } catch (error) {
                console.error('Failed to load stats:', error);
            }
        }

        function animateValue(id, start, end, duration) {
            const element = document.getElementById(id);
            if (!element) return;
            const range = end - start;
            if (range === 0) { element.textContent = end.toLocaleString('id-ID'); return; }
            const increment = end > start ? 1 : -1;
            const stepTime = Math.abs(Math.floor(duration / range));
            let current = start;
            const timer = setInterval(() => {
                current += increment;
                element.textContent = current.toLocaleString('id-ID');
                if (current === end) { clearInterval(timer); }
            }, Math.max(stepTime, 10));
        }

        function createResponseChart(monthlyData) {
            const ctx = document.getElementById('responseChart');
            if (!ctx) return;

            // Destroy existing if needed
            if (responseChart) responseChart.destroy();

            // Chart.js Gradient
            const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(99, 102, 241, 0.5)');
            gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

            responseChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Object.keys(monthlyData),
                    datasets: [{
                        label: 'Respons',
                        data: Object.values(monthlyData),
                        borderColor: '#6366f1',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#6366f1',
                        pointHoverBackgroundColor: '#6366f1',
                        pointHoverBorderColor: '#fff',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleColor: '#fff',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(255,255,255,0.1)',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: { color: '#64748b' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#64748b' }
                        }
                    }
                }
            });
        }

        function showPopularSurveys(surveys) {
            const container = document.getElementById('popularSurveysTable');
            if (!container) return;

            if (!surveys || surveys.length === 0) {
                container.innerHTML = '<tr><td colspan="3" class="text-center py-4">Belum ada survei publik.</td></tr>';
                return;
            }

            // Sentiment mapping (AI Simulation for feedback)
            const sentiments = [
                { label: 'Positif', class: 'positive' },
                { label: 'Netral', class: 'neutral' },
                { label: 'Kritis', class: 'negative' }
            ];

            container.innerHTML = surveys.map((survey, index) => {
                const s = sentiments[index % 3]; // Mock logic
                return `
                <tr>
                    <td>
                        <div class="survey-name">${survey.title}</div>
                        <div class="survey-meta">ID: ${survey.uuid.substring(0, 8)}</div>
                    </td>
                    <td>
                        <div class="count-badge">${survey.responses_count}</div>
                    </td>
                    <td>
                        <span class="sentiment-badge ${s.class}">${s.label}</span>
                    </td>
                </tr>
            `}).join('');
        }

        function showTenants(tenants) {
            const container = document.getElementById('tenantSlider');
            if (!container) return;

            if (!tenants || tenants.length === 0) {
                container.innerHTML = '<p class="text-secondary">Siap melayani berbagai instansi.</p>';
                return;
            }

            container.innerHTML = tenants.map(tenant => `
                <div class="tenant-item glass-hover-sm">
                    <div class="tenant-logo-placeholder">${tenant.name.substring(0, 1)}</div>
                    <span class="tenant-name">${tenant.name}</span>
                </div>
            `).join('');

            // Duplicate for infinite scroll effect
            if (tenants.length > 4) {
                container.innerHTML += container.innerHTML;
            }
        }

        document.addEventListener('DOMContentLoaded', loadStats);

        // Chatbot Interaction
        const chatBtn = document.getElementById('chatBtn');
        const chatWindow = document.getElementById('chatWindow');
        const chatInput = document.getElementById('chatInput');
        const sendBtn = document.getElementById('sendBtn');
        const chatMessages = document.getElementById('chatMessages');

        if (chatBtn) chatBtn.addEventListener('click', () => chatWindow.classList.toggle('active'));

        function addMessage(text, isAi = false) {
            if (!chatMessages) return;
            const msg = document.createElement('div');
            msg.className = `message ${isAi ? 'ai' : 'user'} fade-in`;
            msg.innerHTML = isAi ? marked.parse(text) : text;
            chatMessages.appendChild(msg);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        async function handleChat() {
            if (!chatInput || !chatInput.value.trim()) return;
            const text = chatInput.value.trim();
            chatInput.value = '';

            addMessage(text, false);

            const loadingId = 'loading-' + Date.now();
            const loadingMsg = document.createElement('div');
            loadingMsg.className = 'message ai fade-in';
            loadingMsg.id = loadingId;
            loadingMsg.innerHTML = '<span class="typing-dots"><span>.</span><span>.</span><span>.</span></span>';
            chatMessages.appendChild(loadingMsg);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            try {
                const response = await fetch('/api/public/chatbot', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ message: text })
                });
                const result = await response.json();
                document.getElementById(loadingId).remove();
                addMessage(result.success ? result.message : 'Maaf, layanan sedang sibuk.', true);
            } catch (error) {
                document.getElementById(loadingId).remove();
                addMessage('Gangguan koneksi.', true);
            }
        }

        if (sendBtn) sendBtn.addEventListener('click', handleChat);
        if (chatInput) chatInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') handleChat(); });

        // Scroll Animation Observer
        const observerOptions = { threshold: 0.1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));
    </script>
</body>

</html>
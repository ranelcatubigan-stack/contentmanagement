<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS — Nacasabug Creative</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #0f172a;
            --navy-soft: #1e293b;
            --blue: #3b82f6;
            --blue-light: #60a5fa;
            --blue-glow: rgba(59,130,246,0.10);
            --slate: #64748b;
            --slate-light: #94a3b8;
            --border: #e2e8f0;
            --white: #ffffff;
            --bg: #f8fafc;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--white);
            color: var(--navy);
        }

        /* ── NAV ── */
        nav {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-logo {
            width: 36px; height: 36px;
            background: var(--navy);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .nav-name {
            font-size: 17px;
            font-weight: 700;
            color: var(--navy);
        }

        .nav-name span { color: var(--blue); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
            list-style: none;
        }

        .nav-links a {
            color: var(--slate);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-links a:hover { color: var(--navy); background: var(--bg); }

        .btn-login {
            background: var(--navy) !important;
            color: white !important;
            font-weight: 600 !important;
            border-radius: 10px !important;
        }

        .btn-login:hover { opacity: 0.85; }

        .btn-register {
            background: var(--blue) !important;
            color: white !important;
            font-weight: 600 !important;
            border-radius: 10px !important;
        }

        .btn-register:hover { background: #2563eb !important; }

        /* ── HERO ── */
        .hero {
            background: var(--navy);
            padding: 100px 40px 90px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -80px; left: 50%;
            transform: translateX(-50%);
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(59,130,246,0.18) 0%, transparent 65%);
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(59,130,246,0.15);
            border: 1px solid rgba(59,130,246,0.3);
            border-radius: 100px;
            padding: 6px 16px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--blue-light);
            margin-bottom: 28px;
            position: relative;
        }

        .hero-title {
            font-size: clamp(36px, 5vw, 64px);
            font-weight: 800;
            color: white;
            line-height: 1.1;
            margin-bottom: 20px;
            position: relative;
        }

        .hero-title .blue { color: var(--blue-light); }

        .hero-sub {
            font-size: 17px;
            color: #94a3b8;
            max-width: 520px;
            margin: 0 auto 44px;
            line-height: 1.75;
            font-weight: 400;
            position: relative;
        }

        .hero-cta {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
        }

        .btn-cta-primary {
            background: var(--blue);
            color: white;
            font-weight: 700;
            font-size: 15px;
            padding: 13px 32px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-cta-primary:hover {
            background: #2563eb;
            color: white;
            transform: translateY(-2px);
        }

        .btn-cta-ghost {
            background: rgba(255,255,255,0.07);
            color: white;
            font-weight: 600;
            font-size: 15px;
            padding: 13px 32px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255,255,255,0.12);
            transition: all 0.2s;
        }

        .btn-cta-ghost:hover {
            background: rgba(255,255,255,0.12);
            color: white;
            transform: translateY(-2px);
        }

        /* ── SECTION SHARED ── */
        .section-wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .section-label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--blue);
            margin-bottom: 10px;
            display: block;
        }

        .section-title {
            font-size: clamp(26px, 3vw, 40px);
            font-weight: 800;
            color: var(--navy);
            line-height: 1.2;
            margin-bottom: 12px;
        }

        .section-sub {
            font-size: 15px;
            color: var(--slate);
            line-height: 1.7;
            max-width: 500px;
        }

        /* ── ROLES ── */
        .roles-section {
            padding: 80px 40px;
            background: var(--bg);
            border-bottom: 1px solid var(--border);
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 48px;
        }

        .role-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 30px 26px;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }

        .role-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.08);
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }

        .role-admin::before { background: linear-gradient(90deg, #3b82f6, #06b6d4); }
        .role-author::before { background: linear-gradient(90deg, #8b5cf6, #ec4899); }
        .role-subscriber::before { background: linear-gradient(90deg, #10b981, #06b6d4); }

        .role-icon {
            width: 46px; height: 46px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .icon-admin { background: #eff6ff; color: #3b82f6; }
        .icon-author { background: #f5f3ff; color: #8b5cf6; }
        .icon-subscriber { background: #ecfdf5; color: #10b981; }

        .role-name {
            font-size: 17px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .role-desc {
            font-size: 13px;
            color: var(--slate);
            line-height: 1.65;
            margin-bottom: 20px;
        }

        .role-perms {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .role-perms li {
            font-size: 12.5px;
            color: var(--slate);
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .role-perms li i.bi-check-circle-fill { color: #22c55e; font-size: 12px; }
        .role-perms li i.bi-x-circle-fill { color: #e2e8f0; font-size: 12px; }
        .role-perms li.no { color: #cbd5e1; }

        /* ── FEATURES ── */
        .features-section {
            padding: 80px 40px;
            background: white;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 48px;
        }

        .feature-card {
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px 24px;
            transition: all 0.25s;
        }

        .feature-card:hover {
            border-color: #bfdbfe;
            box-shadow: 0 8px 24px rgba(59,130,246,0.07);
            transform: translateY(-3px);
        }

        .feat-icon {
            width: 44px; height: 44px;
            background: var(--blue-glow);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--blue);
            margin-bottom: 16px;
        }

        .feat-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .feat-desc {
            font-size: 13px;
            color: var(--slate);
            line-height: 1.65;
        }

        /* ── STATS ── */
        .stats-section {
            background: var(--navy);
            padding: 60px 40px;
        }

        .stats-grid {
            max-width: 900px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            text-align: center;
        }

        .stat-val {
            font-size: 44px;
            font-weight: 800;
            color: white;
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-val span { color: var(--blue-light); }
        .stat-lbl { font-size: 13px; color: #475569; font-weight: 500; }

        /* ── CTA ── */
        .cta-section {
            padding: 80px 40px;
            background: var(--bg);
            text-align: center;
            border-top: 1px solid var(--border);
        }

        .btn-cta-light {
            background: white;
            color: var(--navy);
            font-weight: 700;
            font-size: 15px;
            padding: 13px 32px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--border);
            transition: all 0.2s;
        }

        .btn-cta-light:hover {
            border-color: var(--blue);
            color: var(--blue);
            transform: translateY(-2px);
        }

        /* ── FOOTER ── */
        footer {
            background: var(--navy);
            padding: 28px 40px;
            text-align: center;
        }

        .footer-text { font-size: 13px; color: #334155; }
        .footer-text span { color: var(--blue-light); }

        /* REVEAL */
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 900px) {
            .roles-grid, .features-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 600px) {
            .roles-grid, .features-grid, .stats-grid { grid-template-columns: 1fr; }
            .nav-inner { padding: 0 20px; }
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav>
    <div class="nav-inner">
        <a href="/" class="nav-brand">
            <div class="nav-logo"><i class="bi bi-newspaper"></i></div>
            <span class="nav-name">Nacasabug <span>CMS</span></span>
        </a>
        <ul class="nav-links">
            <li><a href="#roles">Roles</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="/login" class="btn-login">Login</a></li>
            <li><a href="/register" class="btn-register">Register</a></li>
        </ul>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-badge">
        <i class="bi bi-check-circle-fill"></i>
        Content Management System
    </div>
    <h1 class="hero-title">
        Write Articles.<br>
        Publish <span class="blue">News.</span><br>
        Engage Readers.
    </h1>
    <p class="hero-sub">
        A clean, role-based CMS where Admins and Authors create content —
        and Subscribers read, like, and comment.
    </p>
    <div class="hero-cta">
        <a href="/login" class="btn-cta-primary">
            <i class="bi bi-box-arrow-in-right"></i> Sign In
        </a>
        <a href="/register" class="btn-cta-ghost">
            <i class="bi bi-person-plus"></i> Create Account
        </a>
    </div>
</section>

<!-- ROLES -->
<section class="roles-section" id="roles">
    <div class="section-wrap">
        <div class="reveal">
            <span class="section-label">Who Can Do What</span>
            <h2 class="section-title">Three roles. Clear permissions.</h2>
            <p class="section-sub">
                Every user gets exactly what they need.
                Admins manage everything, Authors create content, Subscribers engage.
            </p>
        </div>

        <div class="roles-grid">

            <!-- ADMIN -->
            <div class="role-card role-admin reveal">
                <div class="role-icon icon-admin">
                    <i class="bi bi-shield-fill-check"></i>
                </div>
                <div class="role-name">Admin</div>
                <p class="role-desc">Full control over the entire system — users, content, and settings.</p>
                <ul class="role-perms">
                    <li><i class="bi bi-check-circle-fill"></i> Manage all users</li>
                    <li><i class="bi bi-check-circle-fill"></i> Create & edit articles</li>
                    <li><i class="bi bi-check-circle-fill"></i> Publish news posts</li>
                    <li><i class="bi bi-check-circle-fill"></i> Moderate comments</li>
                    <li><i class="bi bi-check-circle-fill"></i> View analytics</li>
                    <li><i class="bi bi-check-circle-fill"></i> Manage categories</li>
                </ul>
            </div>

            <!-- AUTHOR -->
            <div class="role-card role-author reveal" style="transition-delay:0.1s">
                <div class="role-icon icon-author">
                    <i class="bi bi-pencil-fill"></i>
                </div>
                <div class="role-name">Author</div>
                <p class="role-desc">Create and manage their own articles and news posts with full editing tools.</p>
                <ul class="role-perms">
                    <li class="no"><i class="bi bi-x-circle-fill"></i> Cannot manage users</li>
                    <li><i class="bi bi-check-circle-fill"></i> Create & edit articles</li>
                    <li><i class="bi bi-check-circle-fill"></i> Publish news posts</li>
                    <li><i class="bi bi-check-circle-fill"></i> Comment on content</li>
                    <li><i class="bi bi-check-circle-fill"></i> View own dashboard</li>
                    <li class="no"><i class="bi bi-x-circle-fill"></i> No analytics access</li>
                </ul>
            </div>

            <!-- SUBSCRIBER -->
            <div class="role-card role-subscriber reveal" style="transition-delay:0.2s">
                <div class="role-icon icon-subscriber">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="role-name">Subscriber</div>
                <p class="role-desc">Read articles and news, engage through likes and comments.</p>
                <ul class="role-perms">
                    <li class="no"><i class="bi bi-x-circle-fill"></i> Cannot create content</li>
                    <li class="no"><i class="bi bi-x-circle-fill"></i> Cannot publish news</li>
                    <li><i class="bi bi-check-circle-fill"></i> Read all articles</li>
                    <li><i class="bi bi-check-circle-fill"></i> Read all news</li>
                    <li><i class="bi bi-check-circle-fill"></i> Like & comment</li>
                    <li><i class="bi bi-check-circle-fill"></i> View comment history</li>
                </ul>
            </div>

        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features-section" id="features">
    <div class="section-wrap">
        <div class="reveal">
            <span class="section-label">Platform Features</span>
            <h2 class="section-title">Everything in one place</h2>
            <p class="section-sub">
                Built for modern content teams with a clean, fast interface.
            </p>
        </div>

        <div class="features-grid">
            <div class="feature-card reveal">
                <div class="feat-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
                <div class="feat-title">My Articles</div>
                <p class="feat-desc">Authors and Admins write, edit, and publish full articles with categories and tags.</p>
            </div>
            <div class="feature-card reveal" style="transition-delay:0.08s">
                <div class="feat-icon"><i class="bi bi-broadcast-fill"></i></div>
                <div class="feat-title">My News</div>
                <p class="feat-desc">Post breaking news with cover photos, categories, and real-time engagement tools.</p>
            </div>
            <div class="feature-card reveal" style="transition-delay:0.16s">
                <div class="feat-icon"><i class="bi bi-heart-fill"></i></div>
                <div class="feat-title">Likes & Comments</div>
                <p class="feat-desc">Subscribers react to and comment on both articles and news posts instantly.</p>
            </div>
            <div class="feature-card reveal" style="transition-delay:0.24s">
                <div class="feat-icon"><i class="bi bi-chat-left-text-fill"></i></div>
                <div class="feat-title">Comment History</div>
                <p class="feat-desc">Every user can view and manage their own comment history in one place.</p>
            </div>
            <div class="feature-card reveal" style="transition-delay:0.32s">
                <div class="feat-icon"><i class="bi bi-people-fill"></i></div>
                <div class="feat-title">User Management</div>
                <p class="feat-desc">Admins manage all users, assign roles, and control platform access.</p>
            </div>
            <div class="feature-card reveal" style="transition-delay:0.40s">
                <div class="feat-icon"><i class="bi bi-bar-chart-fill"></i></div>
                <div class="feat-title">Analytics Dashboard</div>
                <p class="feat-desc">Track total users, posts, comments and top content — Admin only.</p>
            </div>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="reveal">
            <div class="stat-val">3<span>+</span></div>
            <div class="stat-lbl">User Roles</div>
        </div>
        <div class="reveal" style="transition-delay:0.1s">
            <div class="stat-val">2<span>+</span></div>
            <div class="stat-lbl">Content Types</div>
        </div>
        <div class="reveal" style="transition-delay:0.2s">
            <div class="stat-val">30<span>+</span></div>
            <div class="stat-lbl">API Routes</div>
        </div>
        <div class="reveal" style="transition-delay:0.3s">
            <div class="stat-val">100<span>%</span></div>
            <div class="stat-lbl">Laravel Powered</div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="section-wrap">
        <div class="reveal">
            <span class="section-label">Get Started</span>
            <h2 class="section-title" style="text-align:center; margin:0 auto 12px;">
                Ready to start creating?
            </h2>
            <p class="section-sub" style="text-align:center; margin:0 auto 36px;">
                Sign up as an Author and start publishing articles and news in minutes.
            </p>
            <div class="hero-cta">
                <a href="/register" class="btn-cta-primary">
                    <i class="bi bi-person-plus-fill"></i> Create Account
                </a>
                <a href="/login" class="btn-cta-light">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <p class="footer-text">
        © 2026 <span>Nacasabug Creative CMS</span> — Built with Laravel & Bootstrap
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) e.target.classList.add('visible');
        });
    }, { threshold: 0.1 });
    reveals.forEach(el => observer.observe(el));
</script>
</body>
</html>
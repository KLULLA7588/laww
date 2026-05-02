<?php 
// This file is included by search.php (variables $results and $crime_desc are already available)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results — Smart Legal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* ═══════════ DESIGN TOKENS — identical to home ═══════════ */
        :root {
            --navy:        #060d1f;
            --midnight:    #0b1629;
            --royal:       #1a3a6e;
            --gold:        #c9a84c;
            --gold-light:  #f0c96e;
            --gold-pale:   rgba(201,168,76,0.12);
            --text:        #e8e2d5;
            --muted:       #8a8070;
            --glass:       rgba(255,255,255,0.04);
            --glass-border:rgba(201,168,76,0.18);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            background: var(--navy);
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Grid overlay */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image:
                repeating-linear-gradient(0deg,transparent,transparent 60px,rgba(201,168,76,.025) 60px,rgba(201,168,76,.025) 61px),
                repeating-linear-gradient(90deg,transparent,transparent 60px,rgba(201,168,76,.025) 60px,rgba(201,168,76,.025) 61px);
            pointer-events: none; z-index: 0;
        }

        /* Ambient orbs */
        .orb { position: fixed; border-radius: 50%; filter: blur(120px); pointer-events: none; z-index: 0; }
        .orb-1 { width: 600px; height: 600px; background: rgba(26,58,110,.5); top: -200px; left: -200px; animation: drift 12s ease-in-out infinite; }
        .orb-2 { width: 400px; height: 400px; background: rgba(201,168,76,.08); bottom: -100px; right: -100px; animation: drift 16s ease-in-out infinite reverse; }
        @keyframes drift { 0%,100%{transform:translate(0,0)} 50%{transform:translate(30px,20px)} }

        /* ═══════════ NAVBAR ═══════════ */
        .navbar {
            background: rgba(6,13,31,.85); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 0; position: fixed; width: 100%; top: 0; z-index: 1000; transition: all .3s;
        }
        .navbar.scrolled { padding: .6rem 0; background: rgba(6,13,31,.97); }
        .navbar-brand {
            font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 700;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: .5px;
        }
        .nav-link { color: var(--text) !important; font-weight: 500; font-size: .9rem; letter-spacing: .5px; text-transform: uppercase; padding: .5rem 1.2rem !important; transition: color .2s; }
        .nav-link:hover { color: var(--gold) !important; }
        .btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--navy); font-weight: 700; font-size: .95rem; padding: 14px 36px;
            border-radius: 100px; border: none; letter-spacing: .5px; transition: all .3s;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-gold:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(201,168,76,.35); color: var(--navy); }
        .btn-outline-gold {
            background: transparent; color: var(--gold); border: 1.5px solid var(--glass-border);
            font-weight: 500; padding: 13px 28px; border-radius: 100px; font-size: .9rem;
            transition: all .3s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-outline-gold:hover { background: var(--gold-pale); color: var(--gold-light); border-color: var(--gold); }

        /* ═══════════ PAGE HERO ═══════════ */
        .page-hero {
            padding: 130px 0 60px; position: relative; z-index: 1; text-align: center;
        }
        .page-hero::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(26,58,110,.6) 0%, transparent 70%);
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--gold-pale); border: 1px solid var(--glass-border);
            color: var(--gold-light); padding: 6px 18px; border-radius: 100px;
            font-size: .8rem; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase;
            margin-bottom: 1.5rem; animation: fadeUp .6s ease both;
        }
        .page-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.2rem); font-weight: 900; color: white;
            animation: fadeUp .7s .1s ease both;
        }
        .page-hero h1 span {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .query-pill {
            display: inline-flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,.04); border: 1px solid var(--glass-border);
            border-radius: 100px; padding: 10px 22px; margin-top: 1.2rem;
            font-size: .95rem; color: var(--text); max-width: 700px;
            animation: fadeUp .7s .2s ease both;
        }
        .query-pill i { color: var(--gold); flex-shrink: 0; }
        .query-text { color: var(--gold-light); font-weight: 500; font-style: italic; }

        /* ═══════════ RESULTS META BAR ═══════════ */
        .results-meta-bar {
            position: relative; z-index: 2;
            border-top: 1px solid var(--glass-border); border-bottom: 1px solid var(--glass-border);
            background: rgba(255,255,255,.02); padding: 1.2rem 0; margin-bottom: 3rem;
        }
        .meta-stat { text-align: center; }
        .meta-num {
            font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .meta-label { color: var(--muted); font-size: .75rem; letter-spacing: 1px; text-transform: uppercase; margin-top: 2px; }

        /* ═══════════ MAIN SECTION ═══════════ */
        .main-section { position: relative; z-index: 2; padding-bottom: 80px; }

        /* ═══════════ RESULT CARD ═══════════ */
        .result-card {
            background: rgba(255,255,255,.03);
            border: 1px solid var(--glass-border);
            border-radius: 24px; overflow: hidden;
            transition: all .35s cubic-bezier(.25,.8,.25,1);
            animation: fadeUp .5s ease both;
            height: 100%;
        }
        .result-card:hover {
            transform: translateY(-6px);
            border-color: rgba(201,168,76,.45);
            box-shadow: 0 24px 50px rgba(0,0,0,.35);
        }
        .result-card::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(201,168,76,.06) 0%, transparent 60%);
            opacity: 0; transition: opacity .3s; pointer-events: none;
        }
        .result-card:hover::before { opacity: 1; }

        .card-top {
            background: linear-gradient(135deg, rgba(201,168,76,.18), rgba(201,168,76,.04));
            border-bottom: 1px solid var(--glass-border);
            padding: 1.4rem 1.75rem;
            display: flex; align-items: center; gap: 14px;
        }
        .card-icon {
            width: 46px; height: 46px; border-radius: 12px; flex-shrink: 0;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            display: flex; align-items: center; justify-content: center;
            color: var(--navy); font-size: 1.1rem;
        }
        .card-category {
            font-family: 'Playfair Display', serif; font-size: 1.05rem;
            font-weight: 700; color: white; margin-bottom: 2px;
        }
        .card-section-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: var(--gold-pale); border: 1px solid var(--glass-border);
            color: var(--gold-light); border-radius: 100px;
            padding: 3px 12px; font-size: .72rem; font-weight: 600; letter-spacing: .5px;
        }

        .card-body-inner { padding: 1.5rem 1.75rem; }
        .card-title-text {
            font-family: 'Playfair Display', serif; font-size: 1.1rem;
            color: var(--gold-light); font-weight: 700; margin-bottom: .75rem;
        }
        .card-description {
            color: var(--muted); font-size: .88rem; line-height: 1.75; margin-bottom: 1.25rem;
        }

        /* Punishment block */
        .punishment-block {
            background: rgba(16,185,129,.08);
            border: 1px solid rgba(16,185,129,.25);
            border-radius: 14px; padding: 1rem 1.25rem; margin-bottom: 1rem;
        }
        .punishment-label {
            color: #6ee7b7; font-size: .72rem; font-weight: 700;
            letter-spacing: 1.2px; text-transform: uppercase; margin-bottom: .4rem;
            display: flex; align-items: center; gap: 6px;
        }
        .punishment-text { color: var(--text); font-size: .88rem; line-height: 1.6; }

        /* Keywords block */
        .keywords-block {
            border-top: 1px solid var(--glass-border); padding: 1rem 1.75rem;
            display: flex; flex-wrap: wrap; align-items: center; gap: 6px;
        }
        .kw-label { color: var(--muted); font-size: .72rem; text-transform: uppercase; letter-spacing: .8px; margin-right: 4px; }
        .kw-tag {
            background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08);
            color: var(--muted); border-radius: 6px; padding: 3px 10px; font-size: .72rem;
        }

        /* ═══════════ NO RESULTS ═══════════ */
        .no-results-card {
            background: rgba(255,255,255,.03); border: 1px solid var(--glass-border);
            border-radius: 24px; padding: 4rem 2rem; text-align: center;
        }
        .no-results-icon {
            width: 80px; height: 80px; border-radius: 50%;
            background: rgba(201,168,76,.1); border: 1px solid var(--glass-border);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem; font-size: 2rem; color: var(--gold);
        }
        .no-results-title {
            font-family: 'Playfair Display', serif; font-size: 1.6rem;
            font-weight: 700; color: white; margin-bottom: .75rem;
        }
        .no-results-text { color: var(--muted); font-size: .95rem; line-height: 1.7; max-width: 420px; margin: 0 auto 2rem; }

        /* ═══════════ QUICK TIPS SIDEBAR ═══════════ */
        .sidebar-sticky {
            position: sticky;
            top: 100px;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .tips-card {
            background: rgba(255,255,255,.025); border: 1px solid var(--glass-border);
            border-radius: 20px; overflow: hidden;
        }
        .tips-header {
            background: linear-gradient(135deg, rgba(201,168,76,.15), rgba(201,168,76,.03));
            border-bottom: 1px solid var(--glass-border); padding: 1.2rem 1.5rem;
            display: flex; align-items: center; gap: 10px;
        }
        .tips-header-icon {
            width: 34px; height: 34px; border-radius: 10px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            display: flex; align-items: center; justify-content: center;
            color: var(--navy); font-size: .85rem; flex-shrink: 0;
        }
        .tips-header-title {
            font-family: 'Playfair Display', serif; color: var(--gold-light);
            font-size: 1rem; font-weight: 700;
        }
        .tips-body { padding: 1.25rem 1.5rem; }
        .tip-item {
            display: flex; gap: 12px; align-items: flex-start;
            padding: .85rem 0; border-bottom: 1px solid rgba(255,255,255,.05);
        }
        .tip-item:last-child { border-bottom: none; padding-bottom: 0; }
        .tip-num {
            width: 24px; height: 24px; border-radius: 50%; flex-shrink: 0;
            background: var(--gold-pale); border: 1px solid var(--glass-border);
            color: var(--gold-light); font-size: .7rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center; margin-top: 1px;
        }
        .tip-text { color: var(--muted); font-size: .83rem; line-height: 1.6; }

        /* Emergency bar */
        .emergency-bar {
            background: linear-gradient(90deg, rgba(239,68,68,.15), rgba(239,68,68,.05));
            border: 1px solid rgba(239,68,68,.3); border-radius: 14px;
            padding: 14px 20px; margin-bottom: 2.5rem;
            display: flex; align-items: center; gap: 14px;
        }
        .pulse-icon {
            width: 38px; height: 38px; border-radius: 50%;
            background: rgba(239,68,68,.15); flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            color: #f87171; animation: pulse-border 2s infinite;
        }
        @keyframes pulse-border { 0%,100%{box-shadow:0 0 0 0 rgba(239,68,68,.4)} 50%{box-shadow:0 0 0 10px rgba(239,68,68,0)} }

        /* ═══════════ FOOTER ═══════════ */
        footer {
            background: var(--midnight); border-top: 1px solid var(--glass-border);
            padding: 3rem 0 2rem; position: relative; z-index: 2;
        }
        .footer-brand {
            font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .footer-disclaimer {
            background: rgba(255,255,255,.02); border: 1px solid var(--glass-border);
            border-radius: 12px; padding: 12px 18px; font-size: .8rem;
            color: var(--muted); margin-top: 1.5rem; text-align: center;
        }

        /* ═══════════ UTILITIES ═══════════ */
        @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--navy); }
        ::-webkit-scrollbar-thumb { background: rgba(201,168,76,.3); border-radius: 10px; }

        @media(max-width:768px) {
            .sidebar-sticky { position: static; margin-top: 2rem; }
        }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<!-- ═══════════ NAVBAR ═══════════ -->
<nav class="navbar navbar-expand-lg" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="index.php">⚖ Smart Legal</a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav" style="color:var(--gold)">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="#">How it Works</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                <li class="nav-item ms-2">
                    <a href="index.php#form-section" class="btn-gold" style="font-size:.82rem;padding:10px 22px">
                        <i class="fas fa-gavel"></i> New Search
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ═══════════ PAGE HERO ═══════════ -->
<section class="page-hero">
    <div class="container position-relative" style="z-index:2">
        <div class="hero-badge"><i class="fas fa-balance-scale"></i> Legal Analysis Complete</div>
        <h1>Your <span>Legal Results</span></h1>
        <div class="query-pill">
            <i class="fas fa-quote-left"></i>
            <span class="query-text"><?php echo htmlspecialchars($crime_desc); ?></span>
        </div>
    </div>
</section>

<!-- ═══════════ RESULTS META BAR ═══════════ -->
<div class="results-meta-bar">
    <div class="container">
        <div class="row g-3 text-center">
            <div class="col-4">
                <div class="meta-num"><?php echo count($results); ?></div>
                <div class="meta-label">Laws Found</div>
            </div>
            <div class="col-4">
                <div class="meta-num"><?php echo count(array_unique(array_column($results, 'category'))); ?></div>
                <div class="meta-label">Categories</div>
            </div>
            <div class="col-4">
                <div class="meta-num" style="font-size:1.1rem"><?php echo ($ai_answer ? '&#x1F916; AI' : 'DB'); ?></div>
                <div class="meta-label"><?php echo ($ai_answer ? 'AI Powered' : 'Keyword Match'); ?></div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════ MAIN SECTION ═══════════ -->
<section class="main-section">
    <div class="container">

        <!-- Emergency Bar -->
        <div class="emergency-bar">
            <div class="pulse-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
                <strong style="color:#f87171;font-size:.9rem">In immediate danger?</strong>
                <span style="color:var(--muted);font-size:.85rem;margin-left:8px">
                    Call <strong style="color:white">112</strong> (Police) •
                    <strong style="color:white">1930</strong> (Cybercrime) •
                    <strong style="color:white">181</strong> (Women Helpline)
                </span>
            </div>
        </div>

        <!-- ═══ AI ANSWER CARD (shown only when Gemini returns an answer) ═══ -->
        <?php if (!empty($ai_answer)): ?>
        <div class="ai-answer-card mb-5" style="
            background: linear-gradient(135deg, rgba(201,168,76,0.08) 0%, rgba(26,58,110,0.25) 100%);
            border: 1.5px solid rgba(201,168,76,0.35);
            border-radius: 24px;
            overflow: hidden;
            animation: fadeUp 0.5s ease both;
        ">
            <!-- Card Header -->
            <div style="
                background: linear-gradient(135deg, rgba(201,168,76,0.18), rgba(201,168,76,0.06));
                border-bottom: 1px solid rgba(201,168,76,0.2);
                padding: 1.2rem 2rem;
                display: flex; align-items: center; gap: 12px;
            ">
                <div style="
                    width: 40px; height: 40px; border-radius: 50%;
                    background: linear-gradient(135deg, var(--gold), var(--gold-light));
                    display: flex; align-items: center; justify-content: center;
                    flex-shrink: 0;
                ">
                    <i class="fas fa-robot" style="color:var(--navy); font-size:1rem;"></i>
                </div>
                <div>
                    <div style="font-family:'Playfair Display',serif; color:var(--gold-light); font-size:1.1rem; font-weight:700;">AI Legal Analysis</div>
                    <div style="font-size:0.75rem; color:var(--muted); letter-spacing:1px; text-transform:uppercase;">Powered by Gemini</div>
                </div>
                <?php
                $severity_cfg = [
                    'low'      => ['color' => '#6ee7b7', 'bg' => 'rgba(16,185,129,0.1)',  'border' => 'rgba(16,185,129,0.3)',  'label' => 'Low Severity'],
                    'medium'   => ['color' => '#fcd34d', 'bg' => 'rgba(251,191,36,0.1)',   'border' => 'rgba(251,191,36,0.3)',   'label' => 'Medium Severity'],
                    'high'     => ['color' => '#fb923c', 'bg' => 'rgba(249,115,22,0.1)',   'border' => 'rgba(249,115,22,0.3)',   'label' => 'High Severity'],
                    'critical' => ['color' => '#f87171', 'bg' => 'rgba(239,68,68,0.1)',    'border' => 'rgba(239,68,68,0.3)',    'label' => 'Critical'],
                ];
                $sev_key = strtolower($severity ?? 'medium');
                $sev = $severity_cfg[$sev_key] ?? $severity_cfg['medium'];
                ?>
                <span style="
                    margin-left: auto;
                    background: <?php echo $sev['bg']; ?>;
                    border: 1px solid <?php echo $sev['border']; ?>;
                    color: <?php echo $sev['color']; ?>;
                    border-radius: 100px;
                    padding: 5px 16px;
                    font-size: 0.78rem;
                    font-weight: 600;
                    letter-spacing: 0.5px;
                    text-transform: uppercase;
                "><?php echo htmlspecialchars($sev['label']); ?></span>
            </div>

            <!-- Card Body -->
            <div style="padding: 1.8rem 2rem;">
                <!-- AI Answer Text -->
                <p style="
                    color: var(--text);
                    font-size: 1rem;
                    line-height: 1.8;
                    margin-bottom: <?php echo $recommended_action ? '1.5rem' : '0'; ?>;
                "><?php echo nl2br(htmlspecialchars($ai_answer)); ?></p>

                <?php if (!empty($recommended_action)): ?>
                <!-- Recommended Action -->
                <div style="
                    background: rgba(201,168,76,0.08);
                    border: 1px solid rgba(201,168,76,0.2);
                    border-radius: 14px;
                    padding: 1rem 1.4rem;
                    display: flex; align-items: flex-start; gap: 12px;
                ">
                    <i class="fas fa-arrow-right-long" style="color:var(--gold); margin-top:3px; flex-shrink:0;"></i>
                    <div>
                        <div style="font-size:0.75rem; color:var(--gold); text-transform:uppercase; letter-spacing:1px; font-weight:600; margin-bottom:4px;">Recommended Action</div>
                        <div style="color:var(--text); font-size:0.9rem;"><?php echo htmlspecialchars($recommended_action); ?></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Card Footer -->
            <div style="
                border-top: 1px solid rgba(201,168,76,0.12);
                padding: 0.8rem 2rem;
                display: flex; align-items: center; gap: 8px;
            ">
                <i class="fas fa-circle-info" style="color:var(--muted); font-size:0.75rem;"></i>
                <span style="color:var(--muted); font-size:0.78rem;">This AI analysis is for informational purposes only. Consult a qualified lawyer for legal advice.</span>
            </div>
        </div>
        <?php endif; ?>

        <?php if (empty($results)): ?>
        <!-- ── No Results ── -->
        <div class="no-results-card">
            <div class="no-results-icon"><i class="fas fa-search"></i></div>
            <div class="no-results-title">No Matching Laws Found</div>
            <div class="no-results-text">
                We couldn't find an exact match for your description. Try using different keywords or select a crime category from the dropdown.
            </div>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="index.php#form-section" class="btn-gold"><i class="fas fa-redo me-2"></i>Try Again</a>
                <a href="categories.php" class="btn-outline-gold"><i class="fas fa-layer-group me-2"></i>Browse Categories</a>
            </div>
        </div>

        <?php else: ?>
        <!-- ── Results + Sidebar ── -->
        <div class="row g-5">

            <!-- Results Grid -->
            <div class="col-lg-8">
                <div class="row g-4">
                    <?php foreach ($results as $i => $law): ?>
                    <div class="col-12" style="animation-delay:<?php echo $i * 0.08; ?>s">
                        <div class="result-card position-relative">
                            <!-- Card Top -->
                            <div class="card-top">
                                <div class="card-icon">
                                    <i class="fas fa-gavel"></i>
                                </div>
                                <div>
                                    <div class="card-category"><?php echo htmlspecialchars($law['category']); ?></div>
                                    <span class="card-section-badge">
                                        <i class="fas fa-bookmark" style="font-size:.6rem"></i>
                                        Section <?php echo htmlspecialchars($law['section']); ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body-inner">
                                <div class="card-title-text"><?php echo htmlspecialchars($law['title']); ?></div>
                                <div class="card-description">
                                    <?php echo nl2br(htmlspecialchars($law['description'])); ?>
                                </div>

                                <!-- Punishment -->
                                <div class="punishment-block">
                                    <div class="punishment-label">
                                        <i class="fas fa-balance-scale"></i> Punishment
                                    </div>
                                    <div class="punishment-text">
                                        <?php echo nl2br(htmlspecialchars($law['punishment'])); ?>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Bottom Actions -->
                <div class="d-flex gap-3 flex-wrap mt-5">
                    <a href="index.php#form-section" class="btn-gold">
                        <i class="fas fa-search"></i> New Search
                    </a>
                    <a href="categories.php" class="btn-outline-gold">
                        <i class="fas fa-layer-group"></i> Browse All Categories
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar-sticky">
                <div class="tips-card">
                    <div class="tips-header">
                        <div class="tips-header-icon"><i class="fas fa-lightbulb"></i></div>
                        <div class="tips-header-title">Next Steps to Take</div>
                    </div>
                    <div class="tips-body">
                        <div class="tip-item">
                            <div class="tip-num">1</div>
                            <div class="tip-text">Note down the IPC section numbers shown above — you'll need these when speaking to police.</div>
                        </div>
                        <div class="tip-item">
                            <div class="tip-num">2</div>
                            <div class="tip-text">Visit your nearest police station and request to file an <strong style="color:var(--text)">FIR</strong> citing the relevant sections.</div>
                        </div>
                        <div class="tip-item">
                            <div class="tip-num">3</div>
                            <div class="tip-text">Preserve all evidence — messages, photos, receipts, or witness contacts.</div>
                        </div>
                        <div class="tip-item">
                            <div class="tip-num">4</div>
                            <div class="tip-text">Consult a qualified advocate for professional legal advice specific to your situation.</div>
                        </div>
                        <div class="tip-item">
                            <div class="tip-num">5</div>
                            <div class="tip-text">For online crimes, also file at <strong style="color:var(--gold-light)">cybercrime.gov.in</strong> or call <strong style="color:var(--gold-light)">1930</strong>.</div>
                        </div>
                    </div>
                </div>

                <!-- Helpline Card -->
                <div class="tips-card">
                    <div class="tips-header">
                        <div class="tips-header-icon" style="background:linear-gradient(135deg,#ef4444,#f87171)"><i class="fas fa-phone-alt"></i></div>
                        <div class="tips-header-title">Emergency Helplines</div>
                    </div>
                    <div class="tips-body">
                        <?php
                        $helplines = [
                            ['num'=>'112',  'label'=>'Police Emergency'],
                            ['num'=>'1930', 'label'=>'Cybercrime Helpline'],
                            ['num'=>'181',  'label'=>'Women Helpline'],
                            ['num'=>'1064', 'label'=>'Anti-Corruption (ACB)'],
                            ['num'=>'100',  'label'=>'Police Control Room'],
                        ];
                        foreach ($helplines as $h): ?>
                        <div class="tip-item">
                            <div style="background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.25);border-radius:8px;padding:4px 10px;font-size:.78rem;font-weight:700;color:#fca5a5;flex-shrink:0;min-width:52px;text-align:center">
                                <?php echo $h['num']; ?>
                            </div>
                            <div class="tip-text" style="color:var(--text)"><?php echo $h['label']; ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                </div><!-- /sidebar-sticky -->
            </div>

        </div>
        <?php endif; ?>

    </div>
</section>

<!-- ═══════════ FOOTER ═══════════ -->
<footer>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="footer-brand">⚖ Smart Legal</div>
                <div style="color:var(--muted);font-size:.85rem;margin-top:.5rem">Instant legal intelligence for every Indian citizen.</div>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <p style="color:var(--muted);font-size:.85rem">© 2026 Smart Legal Assistance System</p>
            </div>
        </div>
        <div class="footer-disclaimer">
            <i class="fas fa-info-circle me-2" style="color:var(--gold)"></i>
            For Educational & Informational Purpose Only — Not a substitute for professional legal advice. Always consult a qualified advocate for legal matters.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('scroll', () => {
        document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 60);
    });

    // Scroll reveal
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.style.opacity = '1';
                e.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.08 });

    document.querySelectorAll('.result-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity .5s ease, transform .5s ease';
        obs.observe(el);
    });
</script>
</body>
</html>
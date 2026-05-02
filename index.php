<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Legal Assistance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #060d1f;
            --midnight: #0b1629;
            --royal: #1a3a6e;
            --gold: #c9a84c;
            --gold-light: #f0c96e;
            --gold-pale: rgba(201,168,76,0.12);
            --cream: #fdf8ef;
            --text: #e8e2d5;
            --muted: #8a8070;
            --glass: rgba(255,255,255,0.04);
            --glass-border: rgba(201,168,76,0.18);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { background: var(--navy); font-family: 'DM Sans', sans-serif; color: var(--text); min-height: 100vh; overflow-x: hidden; }
        body::before { content: ''; position: fixed; inset: 0; background-image: repeating-linear-gradient(0deg, transparent, transparent 60px, rgba(201,168,76,0.025) 60px, rgba(201,168,76,0.025) 61px), repeating-linear-gradient(90deg, transparent, transparent 60px, rgba(201,168,76,0.025) 60px, rgba(201,168,76,0.025) 61px); pointer-events: none; z-index: 0; }
        .orb { position: fixed; border-radius: 50%; filter: blur(120px); pointer-events: none; z-index: 0; }
        .orb-1 { width: 600px; height: 600px; background: rgba(26,58,110,0.5); top: -200px; left: -200px; animation: drift 12s ease-in-out infinite; }
        .orb-2 { width: 400px; height: 400px; background: rgba(201,168,76,0.08); bottom: -100px; right: -100px; animation: drift 16s ease-in-out infinite reverse; }
        @keyframes drift { 0%,100%{transform:translate(0,0)} 50%{transform:translate(30px,20px)} }
        .navbar { background: rgba(6,13,31,0.85); backdrop-filter: blur(20px); border-bottom: 1px solid var(--glass-border); padding: 1rem 0; position: fixed; width: 100%; top: 0; z-index: 1000; transition: all 0.3s; }
        .navbar.scrolled { padding: 0.6rem 0; background: rgba(6,13,31,0.97); }
        .navbar-brand { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 700; background: linear-gradient(135deg, var(--gold), var(--gold-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: 0.5px; }
        .nav-link { color: var(--text) !important; font-weight: 500; font-size: 0.9rem; letter-spacing: 0.5px; text-transform: uppercase; padding: 0.5rem 1.2rem !important; transition: color 0.2s; }
        .nav-link:hover, .nav-link.active { color: var(--gold) !important; }
        .hero { min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; z-index: 1; padding: 140px 0 80px; overflow: hidden; }
        .hero::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(26,58,110,0.6) 0%, transparent 70%); }
        .hero-badge { display: inline-flex; align-items: center; gap: 8px; background: var(--gold-pale); border: 1px solid var(--glass-border); color: var(--gold-light); padding: 6px 18px; border-radius: 100px; font-size: 0.8rem; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 1.5rem; animation: fadeUp 0.6s ease both; }
        .hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(2.8rem, 7vw, 5rem); font-weight: 900; line-height: 1.05; color: white; animation: fadeUp 0.7s 0.1s ease both; }
        .hero h1 span { background: linear-gradient(135deg, var(--gold), var(--gold-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero p { font-size: 1.15rem; color: #a09888; max-width: 600px; margin: 1.5rem auto 2.5rem; animation: fadeUp 0.7s 0.2s ease both; line-height: 1.8; }
        .hero-cta { animation: fadeUp 0.7s 0.3s ease both; }
        .btn-gold { background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--navy); font-weight: 700; font-size: 0.95rem; padding: 14px 36px; border-radius: 100px; border: none; letter-spacing: 0.5px; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-gold:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(201,168,76,0.35); color: var(--navy); }
        .btn-outline-gold { background: transparent; color: var(--gold); border: 1.5px solid var(--glass-border); font-weight: 500; padding: 13px 28px; border-radius: 100px; font-size: 0.9rem; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-outline-gold:hover { background: var(--gold-pale); color: var(--gold-light); border-color: var(--gold); }
        .stats-strip { position: relative; z-index: 2; border-top: 1px solid var(--glass-border); border-bottom: 1px solid var(--glass-border); background: rgba(255,255,255,0.02); padding: 2rem 0; }
        .stat-item { text-align: center; }
        .stat-num { font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 700; background: linear-gradient(135deg, var(--gold), var(--gold-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .stat-label { color: var(--muted); font-size: 0.8rem; letter-spacing: 1px; text-transform: uppercase; margin-top: 4px; }
        .main-section { position: relative; z-index: 2; padding: 80px 0; }
        .glass-card { background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border); border-radius: 24px; backdrop-filter: blur(12px); overflow: hidden; transition: border-color 0.3s; }
        .glass-card:hover { border-color: rgba(201,168,76,0.35); }
        .card-gold-header { background: linear-gradient(135deg, rgba(201,168,76,0.15), rgba(201,168,76,0.05)); border-bottom: 1px solid var(--glass-border); padding: 1.5rem 2rem; }
        .card-gold-header h4 { font-family: 'Playfair Display', serif; color: var(--gold-light); font-size: 1.3rem; margin: 0; }
        .form-control, .form-select { background: rgba(255,255,255,0.05) !important; border: 1.5px solid rgba(201,168,76,0.2) !important; border-radius: 14px !important; padding: 14px 18px !important; color: var(--text) !important; font-size: 1rem; transition: all 0.3s; }
        .form-control::placeholder { color: var(--muted) !important; }
        .form-control:focus, .form-select:focus { border-color: var(--gold) !important; box-shadow: 0 0 0 4px rgba(201,168,76,0.12) !important; background: rgba(255,255,255,0.07) !important; }
        .form-select option { background: #0f1c2e; color: var(--text); }
        label.form-label { color: var(--gold-light); font-weight: 600; font-size: 0.85rem; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 8px; }
        .btn-submit { background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%); color: var(--navy); border: none; padding: 16px; font-weight: 700; border-radius: 14px; font-size: 1rem; letter-spacing: 0.5px; transition: all 0.3s; width: 100%; }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(201,168,76,0.35); color: var(--navy); }
        .quick-btn { background: var(--gold-pale); border: 1px solid var(--glass-border); color: var(--gold-light); border-radius: 100px; font-size: 0.85rem; padding: 9px 20px; font-weight: 500; transition: all 0.3s; }
        .quick-btn:hover { background: rgba(201,168,76,0.2); border-color: var(--gold); color: var(--gold-light); transform: translateY(-2px); }
        .section-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; color: white; text-align: center; margin-bottom: 0.5rem; }
        .section-subtitle { color: var(--muted); text-align: center; font-size: 0.95rem; margin-bottom: 2.5rem; }
        .gold-rule { width: 60px; height: 2px; background: linear-gradient(90deg, var(--gold), var(--gold-light)); margin: 0.75rem auto 2rem; }
        .example-card { background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border); border-radius: 18px; overflow: hidden; transition: all 0.3s; }
        .example-card:hover { transform: translateY(-4px); border-color: rgba(201,168,76,0.4); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        .example-card-header { background: linear-gradient(135deg, rgba(201,168,76,0.2), rgba(201,168,76,0.05)); border-bottom: 1px solid var(--glass-border); padding: 1rem 1.5rem; font-family: 'Playfair Display', serif; color: var(--gold-light); font-size: 1rem; }
        .example-card-body { padding: 1.5rem; }
        .punishment-badge { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7; border-radius: 10px; padding: 10px 14px; font-size: 0.85rem; margin-top: 1rem; }
        .mic-btn { background: var(--gold-pale); border: 1px solid var(--glass-border); color: var(--gold); border-radius: 12px; padding: 14px 18px; cursor: pointer; transition: all 0.3s; }
        .mic-btn:hover { background: rgba(201,168,76,0.2); }
        .mic-btn.recording { background: rgba(239,68,68,0.15); border-color: rgba(239,68,68,0.4); color: #f87171; animation: pulse-red 1s infinite; }
        @keyframes pulse-red { 0%,100%{box-shadow:0 0 0 0 rgba(239,68,68,0.3)} 50%{box-shadow:0 0 0 8px rgba(239,68,68,0)} }
        /* Voice language toggle */
        .vlang-btn {
            background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1);
            color: var(--muted); border-radius: 100px; padding: 4px 12px;
            font-size: 0.75rem; cursor: pointer; transition: all 0.2s;
            font-family: 'DM Sans', sans-serif;
        }
        .vlang-btn:hover { border-color: var(--gold); color: var(--gold-light); }
        .vlang-btn.active-vlang { background: var(--gold-pale); border-color: var(--gold); color: var(--gold-light); font-weight: 600; }
        .char-counter { font-size: 0.78rem; color: var(--muted); text-align: right; margin-top: 6px; }
        .char-counter.warn { color: var(--gold); }
        .char-counter.danger { color: #f87171; }
        .recent-tag { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 100px; padding: 5px 14px; font-size: 0.8rem; color: var(--muted); cursor: pointer; transition: all 0.2s; }
        .recent-tag:hover { color: var(--text); border-color: var(--glass-border); }
        .recent-tag .close-x { color: var(--muted); font-size: 0.7rem; margin-left: 2px; cursor: pointer; }
        .recent-tag .close-x:hover { color: #f87171; }
        .step-card { background: rgba(255,255,255,0.02); border: 1px solid var(--glass-border); border-radius: 18px; padding: 2rem; text-align: center; transition: all 0.3s; }
        .step-card:hover { background: rgba(255,255,255,0.05); transform: translateY(-4px); }
        .step-num { width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--navy); font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.2rem; }
        .step-title { color: var(--gold-light); font-weight: 600; font-size: 1rem; margin-bottom: 0.5rem; }
        .step-desc { color: var(--muted); font-size: 0.88rem; line-height: 1.7; }

        /* ─── IPC Quick Reference ─── */
        .ipc-ref-card { background: rgba(255,255,255,0.025); border: 1px solid var(--glass-border); border-radius: 16px; overflow: hidden; }
        .ipc-ref-header { background: linear-gradient(135deg, rgba(201,168,76,0.15), rgba(201,168,76,0.03)); border-bottom: 1px solid var(--glass-border); padding: 1rem 1.5rem; }
        .ipc-section-label { font-size: 0.65rem; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--gold); margin-bottom: 3px; }
        .ipc-section-num { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; background: linear-gradient(135deg, var(--gold), var(--gold-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .ipc-ref-body { padding: 1.25rem 1.5rem; }
        .ipc-crime { color: white; font-weight: 600; font-size: 0.95rem; margin-bottom: 4px; }
        .ipc-punishment { color: #6ee7b7; font-size: 0.82rem; }
        .severity-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        .sev-low { background: #6ee7b7; }
        .sev-med { background: var(--gold); }
        .sev-high { background: #f87171; }

        /* ─── FILTER BUTTON ─── */
        .filter-trigger-btn {
            width: 100%; background: rgba(255,255,255,0.04);
            border: 1.5px solid rgba(201,168,76,0.25); border-radius: 14px;
            padding: 13px 18px; color: var(--text); font-size: 0.9rem;
            cursor: pointer; display: flex; align-items: center;
            justify-content: space-between; transition: all 0.3s;
            font-family: 'DM Sans', sans-serif;
        }
        .filter-trigger-btn:hover { border-color: var(--gold); background: rgba(201,168,76,0.06); }
        .filter-trigger-btn .ficon {
            width: 28px; height: 28px; background: linear-gradient(135deg,var(--gold),var(--gold-light));
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            color: var(--navy); font-size: 0.8rem; flex-shrink: 0;
        }
        .filter-badge-pill {
            background: rgba(201,168,76,0.15); color: var(--gold-light);
            font-size: 0.7rem; font-weight: 700; padding: 3px 10px;
            border-radius: 100px; border: 1px solid rgba(201,168,76,0.3);
        }
        /* ─── FILTER OVERLAY + POPUP ─── */
        .filter-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.7); z-index: 1050;
            backdrop-filter: blur(6px);
            animation: fadeInOverlay 0.25s ease;
        }
        @keyframes fadeInOverlay { from{opacity:0} to{opacity:1} }
        .filter-popup {
            display: none; position: fixed;
            top: 50%; left: 50%; transform: translate(-50%,-50%);
            z-index: 1060; width: min(600px, 94vw);
            max-height: 88vh; overflow-y: auto;
            background: var(--midnight);
            border: 1px solid rgba(201,168,76,0.28);
            border-radius: 24px;
            box-shadow: 0 40px 80px rgba(0,0,0,0.7);
            animation: popIn 0.3s cubic-bezier(.34,1.56,.64,1);
        }
        @keyframes popIn { from{opacity:0;transform:translate(-50%,-46%) scale(0.94)} to{opacity:1;transform:translate(-50%,-50%) scale(1)} }
        .filter-popup::-webkit-scrollbar { width: 4px; }
        .filter-popup::-webkit-scrollbar-thumb { background: rgba(201,168,76,0.3); border-radius:10px; }
        .fp-header {
            background: linear-gradient(135deg,rgba(201,168,76,0.18),rgba(201,168,76,0.04));
            border-bottom: 1px solid rgba(201,168,76,0.18);
            padding: 18px 22px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 10;
        }
        .fp-close {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            color: var(--muted); width: 34px; height: 34px; border-radius: 10px;
            cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .fp-close:hover { background: rgba(239,68,68,0.15); color: #f87171; border-color: rgba(239,68,68,0.3); }
        .fp-section { margin-bottom: 22px; }
        .fp-section-title {
            color: var(--gold); font-size: 0.68rem; font-weight: 700;
            letter-spacing: 1.5px; text-transform: uppercase;
            margin-bottom: 12px; display: flex; align-items: center; gap: 7px;
        }
        .fp-section-title::before { content:''; width:16px; height:2px; background:var(--gold); border-radius:2px; }
        .fp-divider { border-top: 1px solid rgba(201,168,76,0.1); margin: 20px 0; }
        /* Severity chips */
        .sev-chip {
            border-radius: 100px; padding: 9px 20px; font-size: 0.82rem;
            cursor: pointer; transition: all 0.2s; display: inline-flex;
            align-items: center; gap: 7px; border: 1px solid;
        }
        .sev-chip.high { background:rgba(239,68,68,0.08); border-color:rgba(239,68,68,0.25); color:#fca5a5; }
        .sev-chip.med  { background:rgba(251,191,36,0.08); border-color:rgba(251,191,36,0.25); color:#fde68a; }
        .sev-chip.low  { background:rgba(16,185,129,0.08); border-color:rgba(16,185,129,0.25); color:#6ee7b7; }
        .sev-chip.active { outline: 2px solid var(--gold); outline-offset: 2px; font-weight: 700; box-shadow: 0 0 14px rgba(201,168,76,0.2); }
        /* Bail chips */
        .bail-chip {
            border-radius: 100px; padding: 9px 20px; font-size: 0.82rem;
            cursor: pointer; transition: all 0.2s; display: inline-flex;
            align-items: center; gap: 7px;
            background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1);
            color: var(--muted);
        }
        .bail-chip.active-bail { background:rgba(16,185,129,0.12); border-color:rgba(16,185,129,0.4); color:#6ee7b7; font-weight:700; }
        .bail-chip.active-non  { background:rgba(239,68,68,0.12); border-color:rgba(239,68,68,0.4); color:#fca5a5; font-weight:700; }
        .bail-chip.active-both { background:rgba(201,168,76,0.12); border-color:rgba(201,168,76,0.35); color:var(--gold-light); font-weight:700; }
        /* Category cards */
        .cat-filter-card {
            border-radius: 14px; padding: 14px 10px; cursor: pointer;
            text-align: center; transition: all 0.25s; border: 1px solid;
        }
        .cat-filter-card:hover { transform: translateY(-3px); }
        .cat-filter-card.selected {
            outline: 2.5px solid var(--gold); outline-offset: 2px;
            box-shadow: 0 0 20px rgba(201,168,76,0.25);
            transform: scale(1.04);
        }
        .cat-filter-card .cf-icon { font-size: 1.5rem; margin-bottom: 6px; }
        .cat-filter-card .cf-name { color: white; font-size: 0.8rem; font-weight: 600; }
        .cat-filter-card .cf-sec  { color: var(--muted); font-size: 0.68rem; margin-top: 2px; }
        /* Footer */
        .fp-footer {
            border-top: 1px solid rgba(201,168,76,0.18);
            padding: 14px 22px; display: flex; gap: 10px;
            position: sticky; bottom: 0; background: var(--midnight);
        }
        .fp-clear-btn {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            color: var(--muted); border-radius: 12px; padding: 12px 20px;
            font-size: 0.88rem; cursor: pointer; transition: all 0.2s;
            font-family: 'DM Sans', sans-serif;
        }
        .fp-clear-btn:hover { background: rgba(239,68,68,0.1); color: #f87171; border-color: rgba(239,68,68,0.3); }
        .fp-apply-btn {
            flex: 1; background: linear-gradient(135deg,var(--gold),var(--gold-light));
            color: var(--navy); border: none; border-radius: 12px;
            padding: 12px; font-size: 0.95rem; font-weight: 700;
            cursor: pointer; transition: all 0.3s; font-family: 'DM Sans', sans-serif;
        }
        .fp-apply-btn:hover { opacity: 0.88; transform: translateY(-2px); }

        .floating-chat-btn { position: fixed; bottom: 28px; right: 28px; width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), var(--gold-light)); border: none; color: var(--navy); z-index: 999; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 30px rgba(201,168,76,0.4); cursor: pointer; transition: all 0.3s; animation: float 3s ease-in-out infinite; }
        .floating-chat-btn:hover { transform: scale(1.1); box-shadow: 0 15px 40px rgba(201,168,76,0.5); }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        .chat-badge { position: absolute; top: -4px; right: -4px; width: 18px; height: 18px; background: #ef4444; color: white; border-radius: 50%; font-size: 0.65rem; font-weight: 700; display: flex; align-items: center; justify-content: center; border: 2px solid var(--navy); }
        .modal-content { background: var(--midnight); border: 1px solid var(--glass-border); border-radius: 24px; overflow: hidden; }
        .chat-header { background: linear-gradient(135deg, rgba(201,168,76,0.15), rgba(26,58,110,0.3)); border-bottom: 1px solid var(--glass-border); padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 14px; }
        .chat-avatar { width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), var(--gold-light)); display: flex; align-items: center; justify-content: center; color: var(--navy); font-size: 1.1rem; flex-shrink: 0; }
        .chat-header h5 { color: white; font-weight: 600; margin: 0; font-size: 1rem; }
        .chat-header small { color: var(--muted); font-size: 0.75rem; }
        .online-dot { width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block; margin-right: 5px; animation: pulse-green 2s infinite; }
        @keyframes pulse-green { 0%,100%{opacity:1} 50%{opacity:0.4} }
        .chat-body { height: 380px; overflow-y: auto; padding: 1.5rem; background: rgba(0,0,0,0.2); display: flex; flex-direction: column; gap: 12px; }
        .chat-body::-webkit-scrollbar { width: 4px; }
        .chat-body::-webkit-scrollbar-track { background: transparent; }
        .chat-body::-webkit-scrollbar-thumb { background: rgba(201,168,76,0.3); border-radius: 10px; }
        .chat-bubble-bot, .chat-bubble-user { max-width: 80%; padding: 12px 16px; border-radius: 18px; font-size: 0.9rem; line-height: 1.6; }
        .chat-bubble-bot { background: rgba(255,255,255,0.06); border: 1px solid var(--glass-border); color: var(--text); border-bottom-left-radius: 6px; align-self: flex-start; }
        .chat-bubble-user { background: linear-gradient(135deg, rgba(201,168,76,0.25), rgba(201,168,76,0.1)); border: 1px solid rgba(201,168,76,0.3); color: var(--gold-light); border-bottom-right-radius: 6px; align-self: flex-end; }
        .chat-input-area { padding: 1rem 1.25rem; background: rgba(0,0,0,0.15); border-top: 1px solid var(--glass-border); }
        .chat-input-area .form-control { border-radius: 14px 0 0 14px !important; border-right: none !important; }
        .translate-btn { background: var(--gold-pale); border: 1.5px solid rgba(201,168,76,0.2); border-left: none; border-right: none; color: var(--gold); font-size: 0.8rem; padding: 0 14px; font-weight: 600; transition: all 0.3s; }
        .translate-btn:hover { background: rgba(201,168,76,0.2); color: var(--gold-light); }
        .chat-send-btn { background: linear-gradient(135deg, var(--gold), var(--gold-light)); border: none; color: var(--navy); padding: 0 18px; border-radius: 0 14px 14px 0; font-size: 0.9rem; }
        .learn-more-btn { background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--navy); border: none; border-radius: 10px; padding: 8px 18px; font-size: 0.82rem; font-weight: 700; cursor: pointer; margin-top: 8px; transition: all 0.2s; }
        .learn-more-btn:hover { opacity: 0.85; }
        .toast-container { position: fixed; bottom: 100px; right: 28px; z-index: 9999; }
        .custom-toast { background: rgba(11,22,41,0.95); border: 1px solid var(--glass-border); border-radius: 16px; padding: 14px 20px; color: var(--text); font-size: 0.88rem; min-width: 250px; box-shadow: 0 15px 40px rgba(0,0,0,0.4); animation: slideInRight 0.3s ease; }
        @keyframes slideInRight { from{transform:translateX(100%);opacity:0} to{transform:translateX(0);opacity:1} }
        .toast-icon { color: var(--gold); margin-right: 10px; }
        .emergency-bar { background: linear-gradient(90deg, rgba(239,68,68,0.15), rgba(239,68,68,0.05)); border: 1px solid rgba(239,68,68,0.3); border-radius: 14px; padding: 14px 20px; margin-bottom: 2rem; display: flex; align-items: center; gap: 14px; }
        .emergency-bar .pulse-icon { width: 38px; height: 38px; border-radius: 50%; background: rgba(239,68,68,0.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #f87171; font-size: 1rem; animation: pulse-border 2s infinite; }
        @keyframes pulse-border { 0%,100%{box-shadow:0 0 0 0 rgba(239,68,68,0.4)} 50%{box-shadow:0 0 0 10px rgba(239,68,68,0)} }
        footer { background: var(--midnight); border-top: 1px solid var(--glass-border); padding: 3rem 0 2rem; position: relative; z-index: 2; }
        .footer-brand { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; background: linear-gradient(135deg, var(--gold), var(--gold-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .footer-text { color: var(--muted); font-size: 0.85rem; margin-top: 0.5rem; }
        .footer-disclaimer { background: rgba(255,255,255,0.02); border: 1px solid var(--glass-border); border-radius: 12px; padding: 12px 18px; font-size: 0.8rem; color: var(--muted); margin-top: 1.5rem; text-align: center; }
        @keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
        .fade-in { animation: fadeUp 0.6s ease both; }
        .fade-in-1 { animation-delay: 0.1s; }
        .fade-in-2 { animation-delay: 0.2s; }
        .fade-in-3 { animation-delay: 0.3s; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--navy); }
        ::-webkit-scrollbar-thumb { background: rgba(201,168,76,0.3); border-radius: 10px; }
        .btn-translate-page { background: transparent; border: 1.5px solid var(--glass-border); color: var(--gold-light); font-size: 0.82rem; font-weight: 600; padding: 8px 16px; border-radius: 100px; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: all 0.3s; letter-spacing: 0.3px; }
        .btn-translate-page:hover { background: var(--gold-pale); border-color: var(--gold); color: var(--gold-light); }
        #translatorModal .modal-content { background: #0b1629; border: 1px solid var(--glass-border); border-radius: 24px; }
        .trans-modal-header { background: linear-gradient(135deg, rgba(201,168,76,0.15), rgba(201,168,76,0.04)); border-bottom: 1px solid var(--glass-border); padding: 1.4rem 1.75rem; display: flex; align-items: center; gap: 14px; }
        .trans-modal-icon { width: 42px; height: 42px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), var(--gold-light)); display: flex; align-items: center; justify-content: center; color: var(--navy); font-size: 1rem; flex-shrink: 0; }
        .trans-modal-body { padding: 2rem 1.75rem 1rem; }
        .lang-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 1.25rem; }
        .lang-chip { background: rgba(255,255,255,0.04); border: 1.5px solid rgba(201,168,76,0.18); border-radius: 12px; padding: 12px 8px; text-align: center; cursor: pointer; transition: all 0.25s; color: var(--muted); font-size: 0.84rem; font-weight: 500; }
        .lang-chip:hover { background: var(--gold-pale); color: var(--gold-light); border-color: var(--gold); }
        .lang-chip.selected { background: rgba(201,168,76,0.2); border-color: var(--gold); color: var(--gold-light); box-shadow: 0 0 0 3px rgba(201,168,76,0.12); }
        .lang-chip .lang-flag { font-size: 1.4rem; display: block; margin-bottom: 4px; }
        .trans-modal-footer { padding: 0 1.75rem 1.75rem; display: flex; gap: 10px; }
        .btn-trans-confirm { flex: 1; background: linear-gradient(135deg, var(--gold), var(--gold-light)); color: var(--navy); border: none; border-radius: 12px; padding: 13px; font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: all 0.3s; }
        .btn-trans-confirm:hover { opacity: 0.88; transform: translateY(-2px); }
        .btn-trans-cancel { background: rgba(255,255,255,0.05); color: var(--muted); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 13px 22px; font-size: 0.9rem; cursor: pointer; transition: all 0.2s; }
        .btn-trans-cancel:hover { background: rgba(255,255,255,0.08); color: var(--text); }
        .trans-status { background: rgba(201,168,76,0.08); border: 1px solid var(--glass-border); border-radius: 10px; padding: 10px 14px; font-size: 0.84rem; color: var(--muted); margin-bottom: 1rem; display: none; align-items: center; gap: 10px; }
        .trans-spinner { width: 16px; height: 16px; border: 2px solid rgba(201,168,76,0.3); border-top-color: var(--gold); border-radius: 50%; animation: spin 0.8s linear infinite; flex-shrink: 0; }
        @keyframes spin { to { transform: rotate(360deg); } }
        @media (max-width: 768px) { .hero h1 { font-size: 2.4rem; } .hero { padding: 120px 0 60px; } .lang-grid { grid-template-columns: repeat(2, 1fr); } }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<!-- ─── Navbar ─── -->
<nav class="navbar navbar-expand-lg" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#">⚖ Smart Legal</a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav" style="color:var(--gold)">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="fir.php">FIR</a></li>
                <li class="nav-item">
                    <button class="btn-translate-page" onclick="openTranslatorModal()" title="Translate this page">
                        <i class="fas fa-globe"></i> Translate Page
                    </button>
                </li>
                <li class="nav-item ms-2">
                    <a href="#form-section" class="btn-gold" style="font-size:0.82rem;padding:10px 22px">
                        <i class="fas fa-gavel"></i> Report Now
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ─── Hero ─── -->
<section class="hero text-center">
    <div class="container position-relative" style="z-index:2">
        <div class="hero-badge"><i class="fas fa-shield-alt"></i> India's Smart Legal Intelligence</div>
        <h1>Instant <span>Legal Guidance</span><br>for Every Citizen</h1>
        <p>Describe any incident and instantly get applicable IPC sections, legal explanations & punishments under Indian law — in your language.</p>
        <div class="hero-cta d-flex flex-wrap gap-3 justify-content-center">
            <a href="#form-section" class="btn-gold"><i class="fas fa-search"></i> Search IPC Sections</a>
            <a href="#how-it-works" class="btn-outline-gold"><i class="fas fa-play-circle"></i> See How It Works</a>
        </div>
        <div class="row mt-5 g-3 justify-content-center" style="max-width:700px;margin-left:auto;margin-right:auto">
            <div class="col-4"><div class="glass-card p-3 text-center"><div style="font-size:1.5rem">📚</div><div style="font-size:0.75rem;color:var(--muted);margin-top:4px">500+ IPC Sections</div></div></div>
            <div class="col-4"><div class="glass-card p-3 text-center"><div style="font-size:1.5rem">🌐</div><div style="font-size:0.75rem;color:var(--muted);margin-top:4px">Hindi & Marathi</div></div></div>
            <div class="col-4"><div class="glass-card p-3 text-center"><div style="font-size:1.5rem">⚡</div><div style="font-size:0.75rem;color:var(--muted);margin-top:4px">Instant Results</div></div></div>
        </div>
    </div>
</section>

<!-- ─── Stats Strip ─── -->
<div class="stats-strip">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3"><div class="stat-num" data-count="500">0</div><div class="stat-label">IPC Sections</div></div>
            <div class="col-6 col-md-3"><div class="stat-num" data-count="50">0</div><div class="stat-label">Crime Categories</div></div>
            <div class="col-6 col-md-3"><div class="stat-num" data-count="3">0</div><div class="stat-label">Languages</div></div>
            <div class="col-6 col-md-3"><div class="stat-num" data-count="24">0</div><div class="stat-label">Hrs Available</div></div>
        </div>
    </div>
</div>

<!-- ─── Main Form Section ─── -->
<section class="main-section" id="form-section">
    <div class="container">
        <div class="emergency-bar">
            <div class="pulse-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
                <strong style="color:#f87171;font-size:0.9rem">In immediate danger?</strong>
                <span style="color:var(--muted);font-size:0.85rem;margin-left:8px">Call <strong style="color:white">112</strong> (Police) • <strong style="color:white">1930</strong> (Cybercrime Helpline) • <strong style="color:white">181</strong> (Women Helpline)</span>
            </div>
        </div>

        <div class="row g-5">
            <!-- Form -->
            <div class="col-lg-8">
                <div class="glass-card fade-in">
                    <div class="card-gold-header d-flex align-items-center gap-3">
                        <div style="width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,var(--gold),var(--gold-light));display:flex;align-items:center;justify-content:center;color:var(--navy)">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <h4>Report the Incident</h4>
                    </div>
                    <div class="p-4 p-md-5">
                        <form action="search.php" method="POST" id="crimeForm">
                            <div class="mb-4">
                                <label class="form-label">Describe the crime in detail</label>
                                <!-- Voice language toggle -->
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span style="color:var(--muted);font-size:0.75rem">Speak in your language:</span>
                                    <div style="display:flex;gap:6px" id="voiceLangGroup">
                                        <button type="button" onclick="setVoiceLang(this,'en-IN')" class="vlang-btn active-vlang" data-lang="en-IN">🇬🇧 English</button>
                                        <button type="button" onclick="setVoiceLang(this,'hi-IN')" class="vlang-btn" data-lang="hi-IN">🇮🇳 Hindi</button>
                                        <button type="button" onclick="setVoiceLang(this,'mr-IN')" class="vlang-btn" data-lang="mr-IN">🇮🇳 Marathi</button>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 align-items-start">
                                    <textarea class="form-control flex-grow-1" name="crime_desc" id="crime_desc" rows="6"
                                              placeholder="Example: A person stole a mobile phone from a shop at night..." required
                                              oninput="updateCounter(this)"></textarea>
                                    <button type="button" class="mic-btn" id="micBtn" onclick="toggleVoiceInput()" title="Voice Input">
                                        <i class="fas fa-microphone"></i>
                                    </button>
                                </div>
                                <div class="char-counter" id="charCounter">0 / 1000 characters</div>
                            </div>
                            <div class="mb-4" id="recentSearchesContainer" style="display:none">
                                <label class="form-label" style="text-transform:none;font-size:0.78rem">Recent Searches</label>
                                <div class="d-flex flex-wrap gap-2" id="recentSearchesList"></div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Or filter by category</label>
                                    <!-- Hidden input — still sends category to search.php -->
                                    <input type="hidden" name="category" id="category" value="">
                                    <button type="button" class="filter-trigger-btn" onclick="openFilterPopup()" id="filterTriggerBtn">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="ficon"><i class="fas fa-sliders-h"></i></div>
                                            <span id="filterBtnLabel">-- Choose Category --</span>
                                        </div>
                                        <span class="filter-badge-pill d-none" id="filterBadgePill">0 selected</span>
                                    </button>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn-submit" onclick="saveSearch()">
                                        <i class="fas fa-search me-2"></i> Find Applicable Laws
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Quick Examples -->
                <div class="mt-4 fade-in fade-in-1">
                    <p style="color:var(--muted);font-size:0.82rem;text-transform:uppercase;letter-spacing:1px;margin-bottom:12px">Quick Fill Examples</p>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="quick-btn" onclick="fillExample('A person stole a mobile phone from a shop.')">📱 Mobile Theft</button>
                        <button class="quick-btn" onclick="fillExample('Someone threatened me and demanded money.')">💰 Extortion</button>
                        <button class="quick-btn" onclick="fillExample('A man cheated me of 50,000 rupees by fake investment.')">💸 Online Fraud</button>
                        <button class="quick-btn" onclick="fillExample('A person hit me with a stick and injured me.')">🥊 Assault</button>
                        <button class="quick-btn" onclick="fillExample('Someone hacked my account and transferred money.')">💻 Cybercrime</button>
                        <button class="quick-btn" onclick="fillExample('My landlord forcefully entered my home without permission.')">🏠 Trespass</button>
                    </div>
                </div>

                <!-- ─── Did You Know Card ─── -->
                <div class="mt-4 fade-in fade-in-2" id="didYouKnowWrap">
                    <div style="background:rgba(255,255,255,0.025);border:1px solid rgba(201,168,76,0.18);border-radius:20px;overflow:hidden">
                        <!-- Header -->
                        <div style="background:linear-gradient(135deg,rgba(201,168,76,0.15),rgba(201,168,76,0.04));border-bottom:1px solid rgba(201,168,76,0.15);padding:14px 20px;display:flex;align-items:center;justify-content:space-between">
                            <div style="display:flex;align-items:center;gap:10px">
                                <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--gold-light));display:flex;align-items:center;justify-content:center;color:var(--navy);font-size:0.85rem">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <span style="color:var(--gold-light);font-size:0.75rem;font-weight:700;letter-spacing:1.2px;text-transform:uppercase">Did You Know?</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:8px">
                                <button onclick="prevTip()" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:var(--muted);width:28px;height:28px;border-radius:8px;cursor:pointer;font-size:0.75rem;display:flex;align-items:center;justify-content:center;transition:all 0.2s" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.1)'">‹</button>
                                <span id="tipCounter" style="color:var(--muted);font-size:0.72rem">1 / 6</span>
                                <button onclick="nextTip()" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:var(--muted);width:28px;height:28px;border-radius:8px;cursor:pointer;font-size:0.75rem;display:flex;align-items:center;justify-content:center;transition:all 0.2s" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.1)'">›</button>
                            </div>
                        </div>
                        <!-- Tip Content -->
                        <div style="padding:20px 22px" id="tipContent">
                            <div style="display:flex;gap:16px;align-items:flex-start">
                                <div id="tipIcon" style="font-size:2.2rem;flex-shrink:0;line-height:1">⚖️</div>
                                <div>
                                    <div id="tipTitle" style="color:white;font-weight:700;font-size:0.95rem;margin-bottom:6px">You Have the Right to File an FIR</div>
                                    <div id="tipText" style="color:var(--muted);font-size:0.84rem;line-height:1.7">Any person can walk into any police station and file a First Information Report (FIR). The police cannot legally refuse to register it for a cognizable offence.</div>
                                    <div id="tipSection" style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.2);border-radius:100px;padding:4px 12px">
                                        <i class="fas fa-bookmark" style="color:var(--gold);font-size:0.65rem"></i>
                                        <span style="color:var(--gold-light);font-size:0.75rem;font-weight:600">Cr.P.C Section 154</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Progress dots -->
                        <div style="padding:0 22px 16px;display:flex;gap:5px" id="tipDots"></div>
                    </div>
                </div>

                <!-- ─── Helpline Quick Dial ─── -->
                <div class="mt-3 fade-in fade-in-3">
                    <div style="background:rgba(239,68,68,0.06);border:1px solid rgba(239,68,68,0.2);border-radius:16px;padding:14px 18px">
                        <div style="color:#f87171;font-size:0.7rem;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;margin-bottom:10px;display:flex;align-items:center;gap:6px">
                            <i class="fas fa-phone-alt" style="font-size:0.65rem"></i> Emergency Helplines
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px">
                            <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:8px;text-align:center">
                                <div style="color:#fca5a5;font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700">112</div>
                                <div style="color:#8a8070;font-size:0.68rem;margin-top:2px">Police</div>
                            </div>
                            <div style="background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.2);border-radius:10px;padding:8px;text-align:center">
                                <div style="color:#93c5fd;font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700">1930</div>
                                <div style="color:#8a8070;font-size:0.68rem;margin-top:2px">Cybercrime</div>
                            </div>
                            <div style="background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.2);border-radius:10px;padding:8px;text-align:center">
                                <div style="color:#6ee7b7;font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700">181</div>
                                <div style="color:#8a8070;font-size:0.68rem;margin-top:2px">Women</div>
                            </div>
                            <div style="background:rgba(251,191,36,0.08);border:1px solid rgba(251,191,36,0.2);border-radius:10px;padding:8px;text-align:center">
                                <div style="color:#fde68a;font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700">1064</div>
                                <div style="color:#8a8070;font-size:0.68rem;margin-top:2px">Anti-Corruption</div>
                            </div>
                            <div style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:8px;text-align:center">
                                <div style="color:#fca5a5;font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700">100</div>
                                <div style="color:#8a8070;font-size:0.68rem;margin-top:2px">Control Room</div>
                            </div>
                            <div style="background:rgba(201,168,76,0.08);border:1px solid rgba(201,168,76,0.2);border-radius:10px;padding:8px;text-align:center">
                                <div style="color:#f0c96e;font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700">1098</div>
                                <div style="color:#8a8070;font-size:0.68rem;margin-top:2px">Child Helpline</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar: IPC Quick Reference -->
            <div class="col-lg-4">
                <p style="color:var(--muted);font-size:0.78rem;text-transform:uppercase;letter-spacing:1.2px;margin-bottom:14px">
                    <i class="fas fa-bookmark me-2" style="color:var(--gold)"></i>IPC Quick Reference
                </p>
                <div class="d-flex flex-column gap-3" id="ipcRefList">
                    <!-- Populated by JS -->
                </div>
            </div>
        </div>

        <!-- ─── How It Works ─── -->
        <div class="mt-6 pt-5" id="how-it-works">
            <div class="section-title">How the System Works</div>
            <div class="gold-rule"></div>
            <div class="row g-4">
                <div class="col-md-3"><div class="step-card fade-in"><div class="step-num">1</div><div class="step-title">Describe Incident</div><div class="step-desc">Type or speak your incident in Hindi, Marathi or English. The system accepts natural language.</div></div></div>
                <div class="col-md-3"><div class="step-card fade-in fade-in-1"><div class="step-num">2</div><div class="step-title">AI Analysis</div><div class="step-desc">Our system analyzes the incident against the Indian Penal Code database intelligently.</div></div></div>
                <div class="col-md-3"><div class="step-card fade-in fade-in-2"><div class="step-num">3</div><div class="step-title">Get IPC Sections</div><div class="step-desc">Receive accurate IPC sections, legal definitions and applicable punishments instantly.</div></div></div>
                <div class="col-md-3"><div class="step-card fade-in fade-in-3"><div class="step-num">4</div><div class="step-title">Take Action</div><div class="step-desc">Use the information to file an FIR or consult with a legal professional confidently.</div></div></div>
            </div>
        </div>
                            <!-- ─── Nearby Police Stations ─── -->
        <div class="mt-5 pt-3">
            <div class="section-title">Nearby Police Stations</div>
            <div class="gold-rule"></div>
            <p style="color:var(--muted);font-size:0.85rem;text-transform:uppercase;letter-spacing:1.5px;margin-bottom:1.5rem">3 closest stations · based on your live location</p>

            <div class="text-center mb-4">
                <button onclick="detectPoliceLocation()" style="background:linear-gradient(135deg,var(--gold),var(--gold-light));color:var(--navy);font-weight:700;font-size:0.95rem;padding:14px 32px;border-radius:100px;border:none;display:inline-flex;align-items:center;gap:10px;cursor:pointer;transition:all 0.3s;letter-spacing:0.3px" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 15px 40px rgba(201,168,76,0.35)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                    <i class="fas fa-map-marker-alt"></i> Detect My Location
                </button>
            </div>

            <div id="policeLocationBar" style="display:none;margin-bottom:10px">
                <div style="background:rgba(255,255,255,0.04);border:1px solid var(--glass-border);border-radius:14px;padding:14px 20px;display:flex;align-items:center;justify-content:space-between;gap:12px">
                    <span style="color:var(--text);font-size:0.9rem;display:flex;align-items:center;gap:8px"><i class="fas fa-map-marker-alt" style="color:var(--gold)"></i> <span id="policeLocationText">Detecting...</span></span>
                    <button onclick="detectPoliceLocation()" style="background:none;border:1px solid var(--glass-border);color:var(--gold);font-size:0.78rem;padding:5px 14px;border-radius:100px;cursor:pointer;display:flex;align-items:center;gap:5px;font-weight:600;letter-spacing:0.5px">
                        <i class="fas fa-sync-alt"></i> REFRESH
                    </button>
                </div>
                <div id="policeStatusBar" style="display:none;background:rgba(201,168,76,0.08);border:1px solid var(--glass-border);border-radius:10px;padding:10px 18px;font-size:0.82rem;color:var(--gold-light);margin-top:8px;display:none;align-items:center;gap:8px">
                    <i class="fas fa-map-pin"></i> <span id="policeStatusText"></span>
                </div>
            </div>

            <div id="policeLoading" style="display:none;text-align:center;padding:40px 20px;color:var(--muted)">
                <div class="spinner-border mb-3" role="status" style="color:var(--gold);width:2rem;height:2rem"></div>
                <p>Finding police stations near you...</p>
            </div>

            <div id="policeStationsGrid" style="display:none">
                <div class="row g-4" id="policeCardsRow"></div>
            </div>
        </div>

    </div>
</section>

<script>
function detectPoliceLocation() {
    const loadingEl = document.getElementById('policeLoading');
    const gridEl = document.getElementById('policeStationsGrid');
    const locBar = document.getElementById('policeLocationBar');
    const statusBar = document.getElementById('policeStatusBar');
    const statusText = document.getElementById('policeStatusText');
    const locText = document.getElementById('policeLocationText');

    loadingEl.style.display = 'block';
    gridEl.style.display = 'none';
    locBar.style.display = 'block';
    statusBar.style.display = 'none';
    locText.textContent = 'Detecting...';

    if (!navigator.geolocation) {
        loadingEl.style.display = 'none';
        locText.textContent = 'Geolocation not supported by your browser.';
        return;
    }

    navigator.geolocation.getCurrentPosition(async (pos) => {
        const lat = pos.coords.latitude;
        const lng = pos.coords.longitude;

        try {
            const geoRes = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`);
            const geoData = await geoRes.json();
            const city = geoData.address.city || geoData.address.town || geoData.address.village || 'your area';
            const state = geoData.address.state || '';
            locText.textContent = `${geoData.address.suburb || geoData.address.neighbourhood || city}, ${state}`;
            statusText.textContent = `📍 Showing Police Stations in ${city.toUpperCase()}, ${state.toUpperCase()}`;
            statusBar.style.display = 'flex';
        } catch(e) {
            locText.textContent = `Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}`;
        }

        try {
            const overpassQuery = `[out:json][timeout:25];(node["amenity"="police"](around:5000,${lat},${lng});way["amenity"="police"](around:5000,${lat},${lng}););out body center 10;`;
            const res = await fetch(`https://overpass-api.de/api/interpreter?data=${encodeURIComponent(overpassQuery)}`);
            const data = await res.json();

            let stations = data.elements.map(el => {
                const sLat = el.lat || el.center?.lat;
                const sLng = el.lon || el.center?.lon;
                const dLat = (sLat - lat) * Math.PI / 180;
                const dLng = (sLng - lng) * Math.PI / 180;
                const a = Math.sin(dLat/2)**2 + Math.cos(lat*Math.PI/180)*Math.cos(sLat*Math.PI/180)*Math.sin(dLng/2)**2;
                const dist = 6371 * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                return {
                    name: el.tags?.name || el.tags?.["name:en"] || 'Police Station',
                    address: [el.tags?.["addr:street"], el.tags?.["addr:suburb"], el.tags?.["addr:city"]].filter(Boolean).join(', ') || 'Address not available',
                    phone: el.tags?.phone || el.tags?.contact_phone || null,
                    lat: sLat, lng: sLng, dist
                };
            }).filter(s => s.lat && s.lng).sort((a,b) => a.dist - b.dist).slice(0,3);

            renderPoliceCards(stations);
        } catch(e) {
            document.getElementById('policeCardsRow').innerHTML = `<div class="col-12 text-center" style="color:#ef4444;padding:20px"><i class="fas fa-exclamation-circle me-2"></i>Could not load stations. Please try again.</div>`;
            gridEl.style.display = 'block';
        }

        loadingEl.style.display = 'none';
        gridEl.style.display = 'block';

    }, () => {
        loadingEl.style.display = 'none';
        locText.textContent = 'Location access denied. Please allow location permission.';
    });
}

function renderPoliceCards(stations) {
    const row = document.getElementById('policeCardsRow');
    const icons = ['🥇','🏃','🚔'];
    if (!stations.length) {
        row.innerHTML = `<div class="col-12 text-center" style="color:var(--muted);padding:40px 0"><i class="fas fa-search fa-2x mb-3" style="color:var(--gold);opacity:0.5;display:block"></i>No police stations found within 5 km.</div>`;
        return;
    }
    const colClass = stations.length === 1 ? 'col-12 col-md-6 offset-md-3' : stations.length === 2 ? 'col-12 col-md-6' : 'col-12 col-md-6 col-lg-4';
    row.innerHTML = stations.map((s, i) => {
        const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(s.name + ' police station')}&center=${s.lat},${s.lng}`;
        return `
        <div class="${colClass}">
            <div class="example-card" style="position:relative;display:flex;flex-direction:column;gap:12px;height:100%">
                <div style="position:absolute;top:14px;right:14px;width:28px;height:28px;border-radius:50%;background:rgba(201,168,76,0.15);border:1px solid var(--glass-border);color:var(--gold-light);font-size:0.75rem;font-weight:700;display:flex;align-items:center;justify-content:center">#${i+1}</div>
                <div class="example-card-header" style="display:flex;align-items:center;gap:12px">
                    <span style="font-size:1.4rem">${icons[i]}</span>
                    <span>${s.name}</span>
                </div>
                <div class="example-card-body" style="display:flex;flex-direction:column;gap:10px;flex:1">
                    <p style="color:var(--muted);font-size:0.82rem;margin:0"><i class="fas fa-map-marker-alt me-1" style="color:var(--gold);font-size:0.75rem"></i>${s.address}</p>
                    <div style="display:flex;gap:8px;flex-wrap:wrap">
                        <span style="background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.25);color:var(--gold-light);font-size:0.75rem;padding:4px 12px;border-radius:100px;display:inline-flex;align-items:center;gap:5px;font-weight:600"><i class="fas fa-route"></i> ${s.dist.toFixed(1)} km</span>
                        <span style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#4ade80;font-size:0.75rem;padding:4px 12px;border-radius:100px;font-weight:600">● LIKELY OPEN</span>
                    </div>
                    <div style="display:flex;gap:10px;margin-top:auto;padding-top:6px">
                        <a href="${mapsUrl}" target="_blank" style="flex:1;background:linear-gradient(135deg,var(--gold),var(--gold-light));color:var(--navy);border:none;border-radius:12px;padding:10px;font-size:0.82rem;font-weight:700;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;transition:all 0.3s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
                            <i class="fas fa-map"></i> Directions
                        </a>
                        <a href="${s.phone ? 'tel:'+s.phone : 'tel:100'}" style="flex:1;background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#4ade80;border-radius:12px;padding:10px;font-size:0.82rem;font-weight:700;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;transition:all 0.3s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
                            <i class="fas fa-phone"></i> ${s.phone || 'Dial 100'}
                        </a>
                    </div>
                </div>
            </div>
        </div>`;
    }).join('');
}
</script>

<!-- ─── Footer ─── -->
<footer>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="footer-brand">⚖ Smart Legal</div>
                <div class="footer-text">Instant legal intelligence for every Indian citizen.</div>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <p style="color:var(--muted);font-size:0.85rem">© 2026 Smart Legal Assistance System</p>
            </div>
        </div>
        <div class="footer-disclaimer">
            <i class="fas fa-info-circle me-2" style="color:var(--gold)"></i>
            For Educational & Informational Purpose Only — Not a substitute for professional legal advice. Always consult a qualified advocate for legal matters.
        </div>
    </div>
</footer>

<!-- ─── Filter Overlay ─── -->
<div class="filter-overlay" id="filterOverlay" onclick="closeFilterPopup()"></div>

<!-- ─── Filter Popup ─── -->
<div class="filter-popup" id="filterPopup">

    <!-- Header -->
    <div class="fp-header">
        <div class="d-flex align-items-center gap-3">
            <div style="width:40px;height:40px;background:linear-gradient(135deg,var(--gold),var(--gold-light));border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--navy);font-size:1rem">
                <i class="fas fa-sliders-h"></i>
            </div>
            <div>
                <div style="color:white;font-weight:700;font-size:1rem">Smart Filter</div>
                <div style="color:var(--muted);font-size:0.75rem">Filter crimes by category, severity or offence type</div>
            </div>
        </div>
        <button class="fp-close" onclick="closeFilterPopup()"><i class="fas fa-times"></i></button>
    </div>

    <div style="padding:22px">

        <!-- ── Severity Filter ── -->
        <div class="fp-section">
            <div class="fp-section-title"><i class="fas fa-exclamation-circle" style="font-size:.7rem"></i> Filter by Severity</div>
            <div class="d-flex flex-wrap gap-2" id="sevGroup">
                <button class="sev-chip high" onclick="toggleSevFilter(this,'high')">
                    <span style="width:8px;height:8px;border-radius:50%;background:#f87171;display:inline-block"></span> Serious
                </button>
                <button class="sev-chip med" onclick="toggleSevFilter(this,'med')">
                    <span style="width:8px;height:8px;border-radius:50%;background:#fbbf24;display:inline-block"></span> Moderate
                </button>
                <button class="sev-chip low" onclick="toggleSevFilter(this,'low')">
                    <span style="width:8px;height:8px;border-radius:50%;background:#6ee7b7;display:inline-block"></span> Minor
                </button>
            </div>
        </div>

        <div class="fp-divider"></div>

        <!-- ── Offence Type Filter ── -->
        <div class="fp-section">
            <div class="fp-section-title"><i class="fas fa-balance-scale" style="font-size:.7rem"></i> Offence Type</div>
            <div class="d-flex flex-wrap gap-2" id="bailGroup">
                <button class="bail-chip active-both" id="bailBoth" onclick="setBail('both',this)">
                    <i class="fas fa-adjust" style="font-size:.75rem"></i> Both
                </button>
                <button class="bail-chip" id="bailYes" onclick="setBail('bailable',this)">
                    <span style="color:#6ee7b7">●</span> Bailable
                </button>
                <button class="bail-chip" id="bailNo" onclick="setBail('non-bailable',this)">
                    <span style="color:#f87171">●</span> Non-Bailable
                </button>
            </div>
        </div>

        <div class="fp-divider"></div>

        <!-- ── Crime Category Cards ── -->
        <div class="fp-section">
            <div class="fp-section-title"><i class="fas fa-layer-group" style="font-size:.7rem"></i> Crime Category</div>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px" id="catCardGrid">
                <div class="cat-filter-card" style="background:rgba(16,185,129,0.06);border-color:rgba(16,185,129,0.2)" onclick="toggleCatCard(this,'Theft')" data-cat="Theft">
                    <div class="cf-icon">🛍️</div><div class="cf-name">Theft</div><div class="cf-sec">Sec 378–382</div>
                </div>
                <div class="cat-filter-card" style="background:rgba(251,191,36,0.06);border-color:rgba(251,191,36,0.2)" onclick="toggleCatCard(this,'Extortion')" data-cat="Extortion">
                    <div class="cf-icon">💰</div><div class="cf-name">Extortion</div><div class="cf-sec">Sec 383–389</div>
                </div>
                <div class="cat-filter-card" style="background:rgba(251,191,36,0.06);border-color:rgba(251,191,36,0.2)" onclick="toggleCatCard(this,'Cheating')" data-cat="Cheating">
                    <div class="cf-icon">💸</div><div class="cf-name">Fraud</div><div class="cf-sec">Sec 415–420</div>
                </div>
                <div class="cat-filter-card" style="background:rgba(251,191,36,0.06);border-color:rgba(251,191,36,0.2)" onclick="toggleCatCard(this,'Assault')" data-cat="Assault">
                    <div class="cf-icon">🤛</div><div class="cf-name">Assault</div><div class="cf-sec">Sec 319–326</div>
                </div>
                <div class="cat-filter-card" style="background:rgba(59,130,246,0.08);border-color:rgba(59,130,246,0.2)" onclick="toggleCatCard(this,'Cybercrime')" data-cat="Cybercrime">
                    <div class="cf-icon">💻</div><div class="cf-name">Cybercrime</div><div class="cf-sec">IT Act §66</div>
                </div>
                <div class="cat-filter-card" style="background:rgba(239,68,68,0.07);border-color:rgba(239,68,68,0.2)" onclick="toggleCatCard(this,'Murder')" data-cat="Murder">
                    <div class="cf-icon">🔪</div><div class="cf-name">Murder</div><div class="cf-sec">Sec 302–308</div>
                </div>
                <div class="cat-filter-card" style="background:rgba(239,68,68,0.07);border-color:rgba(239,68,68,0.2)" onclick="toggleCatCard(this,'Rape')" data-cat="Rape">
                    <div class="cf-icon">⚠️</div><div class="cf-name">Sexual Offence</div><div class="cf-sec">Sec 376</div>
                </div>
                <div class="cat-filter-card" style="background:rgba(239,68,68,0.07);border-color:rgba(239,68,68,0.2)" onclick="toggleCatCard(this,'Kidnapping')" data-cat="Kidnapping">
                    <div class="cf-icon">🚨</div><div class="cf-name">Kidnapping</div><div class="cf-sec">Sec 359–368</div>
                </div>
                <div class="cat-filter-card" style="background:rgba(16,185,129,0.06);border-color:rgba(16,185,129,0.2)" onclick="toggleCatCard(this,'Trespass')" data-cat="Trespass">
                    <div class="cf-icon">🏠</div><div class="cf-name">Trespass</div><div class="cf-sec">Sec 441–462</div>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <div class="fp-footer">
        <button class="fp-clear-btn" onclick="clearFilterAll()">
            <i class="fas fa-times me-2"></i>Clear All
        </button>
        <button class="fp-apply-btn" onclick="applyFilterNow()">
            <i class="fas fa-check me-2"></i>Apply Filter & Search
        </button>
    </div>
</div>

<!-- ─── Page Translator Modal ─── -->
<div class="modal fade" id="translatorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:500px">
        <div class="modal-content">
            <div class="trans-modal-header">
                <div class="trans-modal-icon"><i class="fas fa-globe"></i></div>
                <div>
                    <h5 style="color:white;margin:0;font-size:1.05rem">Translate This Page</h5>
                    <small style="color:var(--muted)">Select a language and click Translate</small>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" style="filter:invert(1);opacity:0.5"></button>
            </div>
            <div class="trans-modal-body">
                <p style="color:var(--muted);font-size:0.82rem;margin-bottom:1rem">Choose your preferred language:</p>
                <div class="lang-grid" id="langGrid">
                    <div class="lang-chip" onclick="selectLang(this,'hi')"><span class="lang-flag">🇮🇳</span>Hindi</div>
                    <div class="lang-chip" onclick="selectLang(this,'mr')"><span class="lang-flag">🇮🇳</span>Marathi</div>
                    <div class="lang-chip" onclick="selectLang(this,'gu')"><span class="lang-flag">🇮🇳</span>Gujarati</div>
                    <div class="lang-chip" onclick="selectLang(this,'ta')"><span class="lang-flag">🇮🇳</span>Tamil</div>
                    <div class="lang-chip" onclick="selectLang(this,'te')"><span class="lang-flag">🇮🇳</span>Telugu</div>
                    <div class="lang-chip" onclick="selectLang(this,'kn')"><span class="lang-flag">🇮🇳</span>Kannada</div>
                    <div class="lang-chip" onclick="selectLang(this,'bn')"><span class="lang-flag">🇮🇳</span>Bengali</div>
                    <div class="lang-chip" onclick="selectLang(this,'pa')"><span class="lang-flag">🇮🇳</span>Punjabi</div>
                    <div class="lang-chip" onclick="selectLang(this,'ur')"><span class="lang-flag">🇵🇰</span>Urdu</div>
                    <div class="lang-chip" onclick="selectLang(this,'fr')"><span class="lang-flag">🇫🇷</span>French</div>
                    <div class="lang-chip" onclick="selectLang(this,'de')"><span class="lang-flag">🇩🇪</span>German</div>
                    <div class="lang-chip" onclick="selectLang(this,'en')"><span class="lang-flag">🇬🇧</span>English</div>
                </div>
                <div class="trans-status" id="transStatus">
                    <div class="trans-spinner"></div>
                    <span id="transStatusText">Translating page, please wait...</span>
                </div>
            </div>
            <div class="trans-modal-footer">
                <button class="btn-trans-cancel" data-bs-dismiss="modal">Cancel</button>
                <button class="btn-trans-confirm" id="transConfirmBtn" onclick="executePageTranslation()">
                    <i class="fas fa-language me-2"></i> Translate Now
                </button>
            </div>
        </div>
    </div>
</div>

<div class="toast-container" id="toastContainer"></div>

<!-- ─── Floating Chat Button ─── -->
<button class="floating-chat-btn" data-bs-toggle="modal" data-bs-target="#chatModal">
    <i class="fas fa-comments fa-lg"></i>
    <div class="chat-badge">1</div>
</button>

<!-- ─── Chat Modal ─── -->
<div class="modal fade" id="chatModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="chat-header">
                <div class="chat-avatar" style="background:linear-gradient(135deg,#c9a84c,#f0c96e);font-size:1.3rem">⚖</div>
                <div>
                    <h5>Nyaya — Legal AI Assistant</h5>
                    <small><span class="online-dot"></span>Online • IPC Expert • Greets in any language</small>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" style="filter:invert(1);opacity:0.6"></button>
            </div>
            <div class="chat-body" id="chatBody">
                <div class="chat-bubble-bot">
                    👋 Namaste! I'm <strong>Nyaya</strong>, your AI Legal Assistant.<br><br>
                    I can help you with:<br>
                    • Greetings and general questions<br>
                    • IPC sections and their descriptions<br>
                    • Crime explanations and punishments<br>
                    • Legal guidance in simple language<br><br>
                    Ask me anything — in <strong>English, Hindi or Marathi</strong>!
                </div>
            </div>
            <div class="chat-input-area">
                <div class="input-group">
                    <input type="text" id="chatInput" class="form-control"
                           placeholder="Ask Nyaya anything about law..."
                           onkeypress="if(event.key==='Enter')sendChatMessage()">
                    <button class="translate-btn" onclick="translateMessage()">
                        <i class="fas fa-language"></i> Translate
                    </button>
                    <button class="chat-send-btn" onclick="sendChatMessage()">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ═══════════════════════════════════════════════
// ALL ORIGINAL FUNCTIONS — 100% UNCHANGED
// ═══════════════════════════════════════════════
function fillExample(text) {
    document.getElementById('crime_desc').value = text;
    updateCounter(document.getElementById('crime_desc'));
    document.getElementById('crimeForm').scrollIntoView({ behavior: "smooth" });
}

// ═══════════════════════════════════════════════
// NYAYA — OFFLINE RULE-BASED LEGAL CHATBOT
// Works 100% without API key — answers in chat
// ═══════════════════════════════════════════════

// ── IPC Knowledge Base ──
const ipcKB = {
    '302': { name:'Murder', desc:'Whoever commits murder shall be punished. Murder means intentionally causing the death of another person.', punishment:'Death or Imprisonment for Life', fine:'No fixed fine limit', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '376': { name:'Rape', desc:'Sexual intercourse with a woman without her consent or against her will. Includes various forms of sexual assault.', punishment:'Minimum 10 years to Life Imprisonment', fine:'Fine as decided by Court', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '378': { name:'Theft', desc:'Whoever intending to take dishonestly any movable property out of the possession of any person without that person\'s consent.', punishment:'Up to 3 years imprisonment, or fine, or both', fine:'₹1,000 – ₹5,000 (approx.)', bailable:'Bailable', cognizable:'Cognizable' },
    '379': { name:'Theft (Punishment)', desc:'Punishment for theft — whoever commits theft shall be punished with imprisonment up to 3 years or fine or both.', punishment:'Up to 3 years imprisonment', fine:'₹1,000 – ₹5,000', bailable:'Bailable', cognizable:'Cognizable' },
    '380': { name:'Theft in Dwelling', desc:'Theft committed in any building, tent, or vessel used as a dwelling house — more serious than ordinary theft.', punishment:'Up to 7 years imprisonment + fine', fine:'As decided by Court', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '383': { name:'Extortion', desc:'Whoever intentionally puts any person in fear of injury and thereby induces that person to deliver property commits extortion.', punishment:'Up to 3 years imprisonment, or fine, or both', fine:'₹2,000 – ₹10,000', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '384': { name:'Extortion (Punishment)', desc:'Punishment for extortion. Whoever commits extortion shall be punished with imprisonment up to 3 years or fine or both.', punishment:'Up to 3 years imprisonment', fine:'₹2,000 – ₹10,000', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '415': { name:'Cheating', desc:'Whoever by deceiving any person fraudulently or dishonestly induces the deceived person to deliver any property commits cheating.', punishment:'Up to 1 year imprisonment, or fine, or both', fine:'As decided by Court', bailable:'Bailable', cognizable:'Non-Cognizable' },
    '420': { name:'Cheating & Fraud', desc:'Cheating and dishonestly inducing delivery of property. A more serious form of cheating involving property fraud.', punishment:'Up to 7 years imprisonment + fine', fine:'₹5,000 – ₹50,000', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '300': { name:'Murder (Definition)', desc:'Culpable homicide is murder if done with intention of causing death or causing such bodily injury as likely to cause death.', punishment:'Death or Life Imprisonment', fine:'No fixed fine', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '304': { name:'Culpable Homicide', desc:'Punishment for culpable homicide not amounting to murder — killing without full intention or in sudden fight.', punishment:'Up to 10 years or Life Imprisonment', fine:'As decided by Court', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '307': { name:'Attempt to Murder', desc:'Whoever does any act with intention or knowledge that if death were caused by that act would amount to murder.', punishment:'Up to 10 years imprisonment + fine', fine:'As decided by Court', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '319': { name:'Hurt', desc:'Whoever causes bodily pain, disease or infirmity to any person is said to cause hurt.', punishment:'Up to 1 year imprisonment, or fine up to ₹1000, or both', fine:'Up to ₹1,000', bailable:'Bailable', cognizable:'Non-Cognizable' },
    '323': { name:'Voluntarily Causing Hurt', desc:'Whoever except in the case provided by Section 334 voluntarily causes hurt, shall be punished.', punishment:'Up to 1 year imprisonment, or fine up to ₹1,000, or both', fine:'Up to ₹1,000', bailable:'Bailable', cognizable:'Non-Cognizable' },
    '324': { name:'Hurt by Dangerous Weapons', desc:'Whoever voluntarily causes hurt by means of any instrument for shooting, stabbing or cutting or any weapon.', punishment:'Up to 3 years imprisonment, or fine, or both', fine:'As decided by Court', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '354': { name:'Assault on Woman', desc:'Assault or criminal force on a woman with intent to outrage her modesty.', punishment:'1 to 5 years imprisonment + fine', fine:'As decided by Court', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '359': { name:'Kidnapping', desc:'Kidnapping is of two kinds — kidnapping from India and kidnapping from lawful guardianship.', punishment:'Up to 7 years + fine', fine:'As decided by Court', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '363': { name:'Kidnapping (Punishment)', desc:'Whoever kidnaps any person from India or from lawful guardianship shall be punished.', punishment:'Up to 7 years imprisonment + fine', fine:'As decided by Court', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '392': { name:'Robbery', desc:'When theft or extortion is committed with use of force or threat of force, it becomes robbery.', punishment:'Up to 10 years imprisonment + fine', fine:'As decided by Court', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '395': { name:'Dacoity', desc:'When five or more persons conjointly commit or attempt to commit robbery, every person is guilty of dacoity.', punishment:'Life imprisonment or up to 10 years + fine', fine:'As decided by Court', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '406': { name:'Criminal Breach of Trust', desc:'Whoever being entrusted with property dishonestly misappropriates or converts to his own use that property.', punishment:'Up to 3 years imprisonment, or fine, or both', fine:'As decided by Court', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '420': { name:'Cheating & Fraud', desc:'Cheating and dishonestly inducing delivery of property or valuable security.', punishment:'Up to 7 years imprisonment + fine', fine:'₹5,000 – ₹50,000', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '441': { name:'Criminal Trespass', desc:'Whoever enters into or upon property in possession of another with intent to commit offence or intimidate.', punishment:'Up to 3 months imprisonment, or fine up to ₹500, or both', fine:'Up to ₹500', bailable:'Bailable', cognizable:'Non-Cognizable' },
    '498a': { name:'Cruelty by Husband/Relatives', desc:'Husband or relative of husband subjecting a woman to cruelty — domestic violence law.', punishment:'Up to 3 years imprisonment + fine', fine:'As decided by Court', bailable:'Non-Bailable', cognizable:'Cognizable' },
    '500': { name:'Defamation', desc:'Whoever makes or publishes any imputation concerning any person intending to harm the reputation of that person.', punishment:'Up to 2 years imprisonment, or fine, or both', fine:'As decided by Court', bailable:'Bailable', cognizable:'Non-Cognizable' },
    '503': { name:'Criminal Intimidation', desc:'Whoever threatens another with any injury to his person, reputation or property to cause alarm to that person.', punishment:'Up to 2 years imprisonment, or fine, or both', fine:'As decided by Court', bailable:'Bailable', cognizable:'Non-Cognizable' },
    '506': { name:'Criminal Intimidation (Punishment)', desc:'Punishment for criminal intimidation — threatening someone to cause fear or force them to do something.', punishment:'Up to 2 years, or fine, or both (up to 7 years if death threat)', fine:'As decided by Court', bailable:'Bailable', cognizable:'Non-Cognizable' },
};

// ── Crime keyword → IPC sections mapping ──
const crimeMap = [
    { keys:['murder','kill','killed','death','shoot','shot','stab','stabbed','hत्या','मर्डर'], sections:['302','307','304'] },
    { keys:['rape','sexual assault','molest','molestation','outrage modesty','बलात्कार','यौन शोषण'], sections:['376','354'] },
    { keys:['theft','steal','stolen','stole','pickpocket','चोरी','मेरा फोन','phone chori','mobile chori'], sections:['378','379','380'] },
    { keys:['extortion','blackmail','threat money','ransom','धमकी पैसे','जबरदस्ती'], sections:['383','384','506'] },
    { keys:['fraud','cheat','cheating','fake','deceive','scam','धोखा','फर्जी','ठगी'], sections:['420','415','406'] },
    { keys:['assault','beat','hit','attack','hurt','punch','kicked','मारपीट','मारा','पिटाई'], sections:['323','324','354'] },
    { keys:['kidnap','abduct','missing','forcefully taken','अपहरण','किडनैप'], sections:['363','359'] },
    { keys:['robbery','loot','looted','snatched','snatch','लूट','छीनना'], sections:['392','395'] },
    { keys:['cybercrime','hacked','hack','online fraud','cyber','account hack','साइबर','हैक'], sections:['420','66-IT'] },
    { keys:['trespass','entered my house','break in','घर में घुसना','अतिक्रमण'], sections:['441','447'] },
    { keys:['domestic violence','wife beating','husband beat','cruelty','घरेलू हिंसा','दहेज'], sections:['498a','323'] },
    { keys:['defamation','false accusation','rumour','reputation','मानहानि'], sections:['500','499'] },
    { keys:['bribe','corruption','government officer','सरकारी रिश्वत','भ्रष्टाचार'], sections:['171b','PC Act'] },
];

// ── Greeting patterns ──
const greetings = {
    patterns: ['hello','hi','hey','namaste','namaskar','good morning','good evening','good afternoon','howdy','hola','नमस्ते','नमस्कार','हेलो'],
    responses: [
        '👋 Hello! I\'m <strong>Nyaya</strong>, your legal assistant.<br>Ask me about any IPC section or describe a crime — I\'ll explain the law directly here!',
        '🙏 Namaste! I\'m <strong>Nyaya</strong>.<br>You can ask me things like:<br>• "What is IPC 302?"<br>• "My phone was stolen"<br>• "What is punishment for fraud?"',
        '⚖️ Hello! <strong>Nyaya</strong> here — your legal guide.<br>Describe any crime or ask about any IPC section and I\'ll give you the answer right here in chat!'
    ]
};

// ── How are you / name patterns ──
function checkSmallTalk(q) {
    q = q.toLowerCase();
    if (/how are you|how r u|kaisa hai|kaise ho|aap kaisa/.test(q))
        return '😊 I\'m doing great, thank you for asking!<br>I\'m <strong>Nyaya</strong>, always ready to help you with Indian legal information. What legal question can I help you with today?';
    if (/your name|naam|kaun ho|who are you|tum kaun/.test(q))
        return '⚖️ My name is <strong>Nyaya</strong> — which means <em>"Justice"</em> in Sanskrit.<br>I\'m your AI-powered Indian Legal Assistant, expert in IPC sections, crime laws, and legal guidance.';
    if (/what can you do|help|kya kar sakte|tumse kya/.test(q))
        return '📚 I can help you with:<br>• <strong>IPC Sections</strong> — e.g. "What is IPC 302?"<br>• <strong>Crime queries</strong> — e.g. "my phone was stolen"<br>• <strong>Punishments & fines</strong> for any offence<br>• <strong>FIR guidance</strong> — how to file a complaint<br>• <strong>Bailable/Non-bailable</strong> offence info<br><br>Just ask naturally in English, Hindi or Marathi!';
    if (/fir|file complaint|police complaint|report crime|शिकायत|एफआईआर/.test(q))
        return '📋 <strong>How to File an FIR:</strong><br><br>1️⃣ Go to the nearest police station<br>2️⃣ Tell them the incident details<br>3️⃣ Police must register FIR under <strong>Cr.P.C Section 154</strong><br>4️⃣ They cannot refuse for a cognizable offence<br>5️⃣ Get a copy of FIR — it\'s your right<br><br>💡 <strong>Zero FIR</strong> — you can file at ANY police station regardless of location.<br><br>📞 If refused, call <strong>100</strong> or approach Superintendent of Police.';
    return null;
}

// ── Format IPC section reply ──
function formatSection(secNum, data) {
    const bailColor = data.bailable === 'Bailable' ? '#6ee7b7' : '#f87171';
    return `⚖️ <strong>IPC Section ${secNum} — ${data.name}</strong><br><br>
📖 <strong>Description:</strong><br>${data.desc}<br><br>
🔴 <strong>Punishment:</strong> ${data.punishment}<br>
💰 <strong>Fine:</strong> ${data.fine}<br>
<span style="color:${bailColor}">●</span> <strong>Offence Type:</strong> ${data.bailable} | ${data.cognizable}<br><br>
<button onclick="learnMoreClicked('${data.name}')" class="learn-more-btn"><i class="fas fa-search me-1"></i> Search Full Results</button><br><br>
<small style="color:var(--muted)">⚠️ For educational purposes only. Consult a qualified advocate for legal advice.</small>`;
}

// ── Main chat logic ──
function addBubble(type, html, isHTML = false) {
    const chatBody = document.getElementById('chatBody');
    const bubble = document.createElement('div');
    bubble.className = type === 'user' ? 'chat-bubble-user' : 'chat-bubble-bot';
    if (isHTML) bubble.innerHTML = html;
    else bubble.textContent = html;
    chatBody.appendChild(bubble);
    chatBody.scrollTop = chatBody.scrollHeight;
    return bubble;
}

function addTypingIndicator() {
    const chatBody = document.getElementById('chatBody');
    const b = document.createElement('div');
    b.className = 'chat-bubble-bot'; b.id = 'typingIndicator';
    b.innerHTML = `<span style="display:flex;gap:5px;align-items:center;padding:2px 0">
        <span style="width:8px;height:8px;border-radius:50%;background:var(--gold);animation:typingDot 1s infinite 0s;display:inline-block"></span>
        <span style="width:8px;height:8px;border-radius:50%;background:var(--gold);animation:typingDot 1s infinite 0.2s;display:inline-block"></span>
        <span style="width:8px;height:8px;border-radius:50%;background:var(--gold);animation:typingDot 1s infinite 0.4s;display:inline-block"></span>
    </span>`;
    chatBody.appendChild(b);
    chatBody.scrollTop = chatBody.scrollHeight;
}
function removeTypingIndicator() { const e=document.getElementById('typingIndicator'); if(e)e.remove(); }
(function(){ const s=document.createElement('style'); s.textContent='@keyframes typingDot{0%,80%,100%{transform:scale(0.6);opacity:0.4}40%{transform:scale(1);opacity:1}}'; document.head.appendChild(s); })();

function getNyayaReply(text) {
    const q = text.toLowerCase().trim();

    // 1. Greetings
    for (const g of greetings.patterns) {
        if (q.includes(g)) {
            return greetings.responses[Math.floor(Math.random() * greetings.responses.length)];
        }
    }

    // 2. Small talk
    const smallTalk = checkSmallTalk(q);
    if (smallTalk) return smallTalk;

    // 3. Direct IPC section query — e.g. "ipc 302", "section 302", "धारा 302"
    const secMatch = q.match(/(?:ipc|section|sec|धारा|आईपीसी)\s*(\d+[a-z]?)/i) || q.match(/^(\d{3}[a-z]?)$/);
    if (secMatch) {
        const num = secMatch[1].toLowerCase();
        if (ipcKB[num]) return formatSection(num.toUpperCase(), ipcKB[num]);
        return `🔍 IPC Section <strong>${num.toUpperCase()}</strong> is not in my quick database.<br>Click below to search it in our full law database!<br><br>
<button onclick="learnMoreClicked('IPC Section ${num}')" class="learn-more-btn"><i class="fas fa-search me-1"></i> Search Section ${num}</button>`;
    }

    // 4. Crime keyword matching
    for (const crime of crimeMap) {
        for (const key of crime.keys) {
            if (q.includes(key)) {
                const sections = crime.sections;
                let reply = `🔍 Based on your query, here are the applicable IPC sections:<br><br>`;
                sections.forEach(sec => {
                    if (ipcKB[sec]) {
                        const d = ipcKB[sec];
                        reply += `⚖️ <strong>Section ${sec} — ${d.name}</strong><br>`;
                        reply += `📖 ${d.desc}<br>`;
                        reply += `🔴 <strong>Punishment:</strong> ${d.punishment}<br>`;
                        reply += `💰 <strong>Fine:</strong> ${d.fine}<br><br>`;
                    } else if (sec === '66-IT') {
                        reply += `💻 <strong>IT Act Section 66 — Cybercrime</strong><br>`;
                        reply += `📖 Covers hacking, data theft, online fraud, identity theft.<br>`;
                        reply += `🔴 <strong>Punishment:</strong> Up to 3 years imprisonment + fine up to ₹5 lakh<br><br>`;
                    }
                });
                reply += `<button onclick="learnMoreClicked('${text.replace(/'/g, "\\'")}')" class="learn-more-btn"><i class="fas fa-search me-1"></i> Search Full Results</button><br><br>`;
                reply += `<small style="color:var(--muted)">⚠️ For educational purposes only. Consult a qualified advocate.</small>`;
                return reply;
            }
        }
    }

    // 5. Punishment / fine query
    if (/punishment|sentence|jail|prison|fine|सज़ा|जुर्माना|कितने साल/.test(q)) {
        return `⚖️ Punishments vary by crime under IPC:<br><br>
🔴 <strong>Serious (Non-Bailable):</strong><br>
• Murder (302) → Death or Life Imprisonment<br>
• Rape (376) → Min 10 years to Life<br>
• Robbery (392) → Up to 10 years<br><br>
🟡 <strong>Moderate:</strong><br>
• Fraud/Cheating (420) → Up to 7 years<br>
• Extortion (383) → Up to 3 years<br>
• Kidnapping (363) → Up to 7 years<br><br>
🟢 <strong>Minor (Bailable):</strong><br>
• Theft (379) → Up to 3 years<br>
• Hurt (323) → Up to 1 year<br>
• Trespass (441) → Up to 3 months<br><br>
Ask me about a specific crime for exact details!`;
    }

    // 6. Default — suggest using search
    return `🤔 I'm not sure about that specific query.<br><br>
You can ask me:<br>
• <strong>"What is IPC 302?"</strong> — for any section<br>
• <strong>"My phone was stolen"</strong> — describe a crime<br>
• <strong>"Punishment for murder"</strong> — for punishments<br>
• <strong>"How to file FIR"</strong> — for legal process<br><br>
Or use the main search to find applicable laws! 👇<br><br>
<button onclick="document.getElementById('chatModal').querySelector('.btn-close').click();document.getElementById('form-section').scrollIntoView({behavior:'smooth'})" class="learn-more-btn"><i class="fas fa-search me-1"></i> Go to Main Search</button>`;
}

function sendChatMessage() {
    const input = document.getElementById('chatInput');
    const text = input.value.trim();
    if (!text) return;

    addBubble('user', text);
    input.value = '';

    addTypingIndicator();

    // Simulate typing delay for natural feel
    setTimeout(() => {
        removeTypingIndicator();
        const reply = getNyayaReply(text);
        addBubble('bot', reply, true);
    }, 600 + Math.random() * 400);
}

function learnMoreClicked(problemText) {
    addBubble('user', 'Show me the full law results');
    addBubble('bot', `Redirecting to detailed legal results...<br><small style="color:var(--muted)">Please wait.</small>`, true);
    document.getElementById('crime_desc').value = problemText;
    setTimeout(() => { document.getElementById('crimeForm').submit(); }, 1200);
}

async function translateMessage() {
    const input = document.getElementById('chatInput');
    let text = input.value.trim();
    if (!text) return;
    const chatBody = document.getElementById('chatBody');
    const userBubble = document.createElement('div');
    userBubble.className = 'chat-bubble-user';
    userBubble.textContent = text;
    chatBody.appendChild(userBubble);
    chatBody.scrollTop = chatBody.scrollHeight;
    const loading = document.createElement('div');
    loading.className = 'chat-bubble-bot';
    loading.textContent = '🌐 Translating to English...';
    chatBody.appendChild(loading);
    chatBody.scrollTop = chatBody.scrollHeight;
    try {
        const res = await fetch(`https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=en&dt=t&q=${encodeURIComponent(text)}`);
        const data = await res.json();
        const translated = data[0][0][0];
        loading.remove();
        const botBubble = document.createElement('div');
        botBubble.className = 'chat-bubble-bot';
        botBubble.innerHTML = `
            ✅ Translated to English:<br>
            <strong>${translated}</strong><br><br>
            I have analyzed your problem. Just go through it.<br><br>
            <button onclick="learnMoreClicked('${translated.replace(/'/g,"\\'")}'"  class="learn-more-btn">
                <i class="fas fa-book-open me-1"></i> Learn More
            </button>`;
        chatBody.appendChild(botBubble);
        chatBody.scrollTop = chatBody.scrollHeight;
    } catch(e) {
        loading.textContent = '❌ Translation failed. Please type in English or try again.';
    }
    input.value = '';
}

document.getElementById('chatModal').addEventListener('shown.bs.modal', () => {
    document.getElementById('chatInput').focus();
    document.querySelector('.chat-badge').style.display = 'none';
});

// 1. Navbar scroll effect
window.addEventListener('scroll', () => {
    document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 60);
});

// 2. Character counter
function updateCounter(el) {
    const len = el.value.length, max = 1000;
    const counter = document.getElementById('charCounter');
    counter.textContent = `${len} / ${max} characters`;
    counter.className = 'char-counter' + (len > 900 ? ' danger' : len > 700 ? ' warn' : '');
}

// 3. Voice Input (Web Speech API)
let recognition = null;
let isRecording = false;
let selectedVoiceLang = 'en-IN'; // default English

function setVoiceLang(btn, lang) {
    selectedVoiceLang = lang;
    document.querySelectorAll('.vlang-btn').forEach(b => b.classList.remove('active-vlang'));
    btn.classList.add('active-vlang');
    const names = { 'en-IN':'English', 'hi-IN':'Hindi', 'mr-IN':'Marathi' };
    showToast('🎤', 'Voice language set to ' + names[lang]);
}

function toggleVoiceInput() {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (!SpeechRecognition) { showToast('❌', 'Voice input not supported in this browser.'); return; }

    if (isRecording) {
        recognition.stop();
        return;
    }

    recognition = new SpeechRecognition();
    recognition.lang = selectedVoiceLang;
    recognition.interimResults = true;   // show words AS you speak
    recognition.continuous = true;       // keep listening until manually stopped
    recognition.maxAlternatives = 1;

    const textarea = document.getElementById('crime_desc');
    const savedText = textarea.value;    // save what was already typed

    recognition.onstart = () => {
        isRecording = true;
        document.getElementById('micBtn').classList.add('recording');
        document.getElementById('micBtn').innerHTML = '<i class="fas fa-stop"></i>';
        const names = { 'en-IN':'English', 'hi-IN':'Hindi', 'mr-IN':'Marathi' };
        showToast('🎤', 'Listening in ' + names[selectedVoiceLang] + '... Speak now');
    };

    recognition.onresult = (e) => {
        let interim = '';
        let final = '';
        for (let i = e.resultIndex; i < e.results.length; i++) {
            const t = e.results[i][0].transcript;
            if (e.results[i].isFinal) {
                final += t + ' ';
            } else {
                interim += t;
            }
        }
        // Show interim (live preview) in textarea immediately
        textarea.value = savedText + (savedText && (final||interim) ? ' ' : '') + final + interim;
        updateCounter(textarea);
    };

    recognition.onerror = (e) => {
        if (e.error !== 'no-speech') {
            showToast('❌', 'Voice error: ' + e.error + '. Try again.');
        }
    };

    recognition.onend = () => {
        isRecording = false;
        document.getElementById('micBtn').classList.remove('recording');
        document.getElementById('micBtn').innerHTML = '<i class="fas fa-microphone"></i>';
        // Clean up trailing spaces
        textarea.value = textarea.value.trim();
        updateCounter(textarea);
        if (textarea.value) showToast('✅', 'Voice captured! Edit if needed.');
    };

    recognition.start();
}

// 4. Toast notifications
function showToast(icon, message) {
    const t = document.createElement('div');
    t.className = 'custom-toast';
    t.innerHTML = `<span class="toast-icon">${icon}</span>${message}`;
    document.getElementById('toastContainer').appendChild(t);
    setTimeout(() => { t.style.transition = 'opacity 0.4s'; t.style.opacity = '0'; setTimeout(() => t.remove(), 400); }, 3000);
}

// 5. Recent Searches (localStorage)
function saveSearch() {
    const text = document.getElementById('crime_desc').value.trim();
    if (!text) return;
    let searches = JSON.parse(localStorage.getItem('recentSearches') || '[]');
    searches = [text, ...searches.filter(s => s !== text)].slice(0, 5);
    localStorage.setItem('recentSearches', JSON.stringify(searches));
}

function loadRecentSearches() {
    const searches = JSON.parse(localStorage.getItem('recentSearches') || '[]');
    const container = document.getElementById('recentSearchesContainer');
    const list = document.getElementById('recentSearchesList');
    if (!searches.length) return;
    container.style.display = 'block';
    list.innerHTML = '';
    searches.forEach((s, i) => {
        const tag = document.createElement('span');
        tag.className = 'recent-tag';
        const short = s.length > 35 ? s.slice(0,35)+'…' : s;
        tag.innerHTML = `<i class="fas fa-clock" style="font-size:0.7rem;color:var(--gold)"></i>${short}<span class="close-x" onclick="removeRecentSearch(${i},event)">✕</span>`;
        tag.onclick = () => fillExample(s);
        list.appendChild(tag);
    });
}

function removeRecentSearch(i, e) {
    e.stopPropagation();
    let searches = JSON.parse(localStorage.getItem('recentSearches') || '[]');
    searches.splice(i, 1);
    localStorage.setItem('recentSearches', JSON.stringify(searches));
    loadRecentSearches();
}

// 6. Animated stat counters
function animateCounters() {
    document.querySelectorAll('[data-count]').forEach(el => {
        const target = +el.dataset.count;
        let current = 0;
        const step = Math.ceil(target / 40);
        const timer = setInterval(() => {
            current = Math.min(current + step, target);
            el.textContent = current + (target >= 100 ? '+' : target === 24 ? '/7' : '');
            if (current >= target) clearInterval(timer);
        }, 30);
    });
}

// 7. IPC Quick Reference sidebar
// ── ONLY CHANGE FROM ORIGINAL: removed "§" symbol, added "IPC Section" label ──
const ipcData = [
    { sec: '302', crime: 'Murder', punishment: 'Death or Life Imprisonment', fine: 'No fixed fine limit', sev: 'high',
      simple: 'When someone intentionally kills another person.' },
    { sec: '376', crime: 'Rape', punishment: 'Min 10 years to Life', fine: 'Fine as decided by Court', sev: 'high',
      simple: 'Forced sexual act on someone without their consent.' },
    { sec: '379', crime: 'Theft', punishment: 'Up to 3 years imprisonment', fine: '₹1,000 – ₹5,000 (approx.)', sev: 'low',
      simple: 'Taking someone\'s belongings secretly without permission.' },
    { sec: '383', crime: 'Extortion', punishment: 'Up to 3 years imprisonment', fine: '₹2,000 – ₹10,000 (approx.)', sev: 'med',
      simple: 'Scaring someone to forcefully take money or valuables from them.' },
    { sec: '420', crime: 'Cheating & Fraud', punishment: 'Up to 7 years imprisonment', fine: '₹5,000 – ₹50,000 (approx.)', sev: 'med',
      simple: 'Tricking someone with false promises to take their money or property.' },
];

function buildIPCRef() {
    const list = document.getElementById('ipcRefList');
    ipcData.forEach(item => {
        list.innerHTML += `
        <div class="ipc-ref-card">
            <div class="ipc-ref-header d-flex align-items-center justify-content-between">
                <div>
                    <div class="ipc-section-label">IPC Section</div>
                    <span class="ipc-section-num">Section ${item.sec}</span>
                </div>
                <span><span class="severity-dot sev-${item.sev}"></span><span style="font-size:0.72rem;color:var(--muted)">${item.sev==='high'?'Serious':item.sev==='med'?'Moderate':'Minor'}</span></span>
            </div>
            <div class="ipc-ref-body">
                <div class="ipc-crime">${item.crime}</div>
                <div style="color:var(--muted);font-size:0.78rem;margin:4px 0 6px;line-height:1.5">${item.simple}</div>
                <div class="ipc-punishment"><i class="fas fa-gavel me-1" style="font-size:0.7rem"></i>${item.punishment}</div>
                <div style="color:#f0c96e;font-size:0.75rem;margin-top:3px"><i class="fas fa-rupee-sign me-1" style="font-size:0.65rem"></i>Fine: ${item.fine}</div>
            </div>
        </div>`;
    });
}

// 8. Intersection Observer for fade-in
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting) { e.target.style.opacity='1'; e.target.style.transform='translateY(0)'; } });
}, { threshold: 0.1 });

document.querySelectorAll('.step-card,.example-card,.glass-card').forEach(el => {
    el.style.opacity = '0'; el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});

// 9. Category auto-fill (kept for programmatic use)
const categoryTemplates = {
    'Theft':      'A person stole property without consent from the owner.',
    'Extortion':  'Someone threatened me and demanded money under intimidation.',
    'Cheating':   'A person cheated me by making false promises and took money.',
    'Assault':    'A person physically attacked and hurt me with a weapon.',
    'Cybercrime': 'Someone hacked into my account and caused financial loss.',
    'Murder':     'A person intentionally killed another person.',
    'Rape':       'A person committed sexual assault without consent.',
    'Kidnapping': 'A person was abducted and taken away against their will.',
    'Trespass':   'Someone forcefully entered my property without permission.'
};

// Severity → fills description with keywords matching all crimes of that level
const severityDescriptions = {
    'high': 'murder kill death rape sexual assault kidnap abduct dacoity robbery armed violent serious life imprisonment',
    'med':  'extortion blackmail threat demand fraud cheat deceive cybercrime hack bribery corruption moderate offence',
    'low':  'theft steal mobile pickpocket trespass defamation hurt slap minor offence bailable fine'
};

// ── FILTER POPUP STATE ──
let fpSelectedCats = [];
let fpSelectedSev  = null;
let fpSelectedBail = 'both';

function openFilterPopup() {
    document.getElementById('filterOverlay').style.display = 'block';
    document.getElementById('filterPopup').style.display   = 'block';
    document.body.style.overflow = 'hidden';
}
function closeFilterPopup() {
    document.getElementById('filterOverlay').style.display = 'none';
    document.getElementById('filterPopup').style.display   = 'none';
    document.body.style.overflow = '';
}

function toggleCatCard(el, cat) {
    const idx = fpSelectedCats.indexOf(cat);
    if (idx > -1) {
        fpSelectedCats.splice(idx, 1);
        el.classList.remove('selected');
    } else {
        fpSelectedCats.push(cat);
        el.classList.add('selected');
    }
    // If a category is picked, clear severity (they are mutually exclusive)
    if (fpSelectedCats.length > 0) {
        fpSelectedSev = null;
        document.querySelectorAll('.sev-chip').forEach(b => b.classList.remove('active'));
    }
    updateFilterBadge();
}

function toggleSevFilter(btn, sev) {
    if (fpSelectedSev === sev) {
        fpSelectedSev = null;
        btn.classList.remove('active');
    } else {
        fpSelectedSev = sev;
        document.querySelectorAll('.sev-chip').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        // Clear category cards when severity selected
        fpSelectedCats = [];
        document.querySelectorAll('.cat-filter-card').forEach(c => c.classList.remove('selected'));
    }
    updateFilterBadge();
}

function setBail(val, btn) {
    fpSelectedBail = val;
    document.querySelectorAll('.bail-chip').forEach(b => {
        b.classList.remove('active-bail','active-non','active-both');
    });
    if (val === 'bailable')     btn.classList.add('active-bail');
    else if (val === 'non-bailable') btn.classList.add('active-non');
    else                        btn.classList.add('active-both');
    updateFilterBadge();
}

function updateFilterBadge() {
    const count = fpSelectedCats.length + (fpSelectedSev ? 1 : 0) + (fpSelectedBail !== 'both' ? 1 : 0);
    const badge = document.getElementById('filterBadgePill');
    if (count > 0) { badge.classList.remove('d-none'); badge.textContent = count + ' filter' + (count>1?'s':'') + ' active'; }
    else            { badge.classList.add('d-none'); }
}

function clearFilterAll() {
    fpSelectedCats = []; fpSelectedSev = null; fpSelectedBail = 'both';
    document.querySelectorAll('.cat-filter-card').forEach(c => c.classList.remove('selected'));
    document.querySelectorAll('.sev-chip').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.bail-chip').forEach(b => b.classList.remove('active-bail','active-non','active-both'));
    document.getElementById('bailBoth').classList.add('active-both');
    updateFilterBadge();
    // Reset form
    document.getElementById('category').value = '';
    document.getElementById('filterBtnLabel').textContent = '-- Choose Category --';
    document.getElementById('filterBtnLabel').style.color = '';
    document.getElementById('crime_desc').value = '';
    updateCounter(document.getElementById('crime_desc'));
    showToast('🗑️', 'All filters cleared.');
}

function applyFilterNow() {
    const desc = document.getElementById('crime_desc');
    const catInput = document.getElementById('category');
    const label = document.getElementById('filterBtnLabel');
    const parts = [];

    // ── SEVERITY MODE: fills description with severity keywords ──
    if (fpSelectedSev) {
        desc.value = severityDescriptions[fpSelectedSev];
        catInput.value = '';
        const sevLabel = fpSelectedSev === 'high' ? '🔴 Serious crimes' : fpSelectedSev === 'med' ? '🟡 Moderate crimes' : '🟢 Minor crimes';
        label.textContent = sevLabel;
        label.style.color = 'var(--gold-light)';
        parts.push(sevLabel);
        updateCounter(desc);
    }

    // ── CATEGORY MODE: sets category + auto-fills description ──
    if (fpSelectedCats.length > 0) {
        const firstCat = fpSelectedCats[0];
        catInput.value = firstCat;
        // Fill description if empty or was previously auto-filled
        if (!desc.value.trim() || Object.values(categoryTemplates).includes(desc.value.trim()) || Object.values(severityDescriptions).includes(desc.value.trim())) {
            desc.value = fpSelectedCats.map(c => categoryTemplates[c] || '').join(' ');
        }
        const catLabel = fpSelectedCats.join(', ');
        label.textContent = catLabel;
        label.style.color = 'var(--gold-light)';
        parts.push(catLabel);
        updateCounter(desc);
    }

    // ── BAIL FILTER: appended as keyword to description ──
    if (fpSelectedBail === 'bailable') {
        desc.value += (desc.value ? ' ' : '') + 'bailable offence fine';
        parts.push('Bailable only');
    } else if (fpSelectedBail === 'non-bailable') {
        desc.value += (desc.value ? ' ' : '') + 'non-bailable serious imprisonment';
        parts.push('Non-Bailable only');
    }

    if (parts.length === 0) {
        showToast('⚠️', 'Please select at least one filter.');
        return;
    }

    updateFilterBadge();
    closeFilterPopup();
    showToast('✅', 'Filter applied! Click "Find Applicable Laws" to search.');

    // Auto-submit after short delay
    setTimeout(() => { document.getElementById('crimeForm').submit(); }, 600);
}

// Init
// ─── Did You Know Tips Rotator ───
const legalTips = [
    { icon:'⚖️', title:'You Have the Right to File an FIR', text:'Any person can walk into any police station and file an FIR. The police cannot legally refuse to register it for a cognizable offence.', sec:'Cr.P.C Section 154' },
    { icon:'🛡️', title:'Zero FIR Can Be Filed Anywhere', text:'A Zero FIR can be filed at ANY police station regardless of where the crime occurred. The station then transfers it to the correct jurisdiction.', sec:'Supreme Court Directive' },
    { icon:'📱', title:'Cybercrime Can Be Reported Online', text:'You do not need to visit a police station for cybercrime. File your complaint directly at cybercrime.gov.in or call the helpline 1930.', sec:'IT Act Section 66' },
    { icon:'💬', title:'You Can Record Your Own Statement', text:'Under Section 164 of Cr.P.C, you can give your statement before a Magistrate which carries more legal weight than a police statement.', sec:'Cr.P.C Section 164' },
    { icon:'🏛️', title:'Free Legal Aid is Your Right', text:'Every Indian citizen who cannot afford a lawyer has the constitutional right to free legal aid provided by the State Legal Services Authority.', sec:'Article 39A, Constitution' },
    { icon:'🔒', title:'Arrested Person Has Rights Too', text:'An arrested person must be informed of the reason for arrest, has the right to consult a lawyer, and must be produced before a Magistrate within 24 hours.', sec:'Article 22, Constitution' },
];
let currentTip = 0, tipTimer = null;
function renderTip(idx) {
    const t = legalTips[idx];
    document.getElementById('tipIcon').textContent  = t.icon;
    document.getElementById('tipTitle').textContent = t.title;
    document.getElementById('tipText').textContent  = t.text;
    document.getElementById('tipSection').querySelector('span').textContent = t.sec;
    document.getElementById('tipCounter').textContent = (idx+1) + ' / ' + legalTips.length;
    const dots = document.getElementById('tipDots');
    dots.innerHTML = '';
    legalTips.forEach((_,i) => {
        const d = document.createElement('div');
        d.style.cssText = `width:${i===idx?20:6}px;height:6px;border-radius:3px;background:${i===idx?'var(--gold)':'rgba(201,168,76,0.25)'};transition:all 0.3s`;
        dots.appendChild(d);
    });
}
function nextTip() { currentTip=(currentTip+1)%legalTips.length; renderTip(currentTip); resetTipTimer(); }
function prevTip() { currentTip=(currentTip-1+legalTips.length)%legalTips.length; renderTip(currentTip); resetTipTimer(); }
function resetTipTimer() { clearInterval(tipTimer); tipTimer=setInterval(nextTip,5000); }
function initTips() { renderTip(0); tipTimer=setInterval(nextTip,5000); }

document.addEventListener('DOMContentLoaded', () => {
    animateCounters();
    buildIPCRef();
    loadRecentSearches();
    snapshotOriginals();
    initTips();
});

// ═══════════════════════════════════════════════
// PAGE TRANSLATOR FEATURE — FIXED & ROBUST
// ═══════════════════════════════════════════════
let selectedLangCode = '';
let selectedLangName = '';

function snapshotOriginals() {
    const walker = document.createTreeWalker(
        document.body, NodeFilter.SHOW_TEXT,
        {
            acceptNode(node) {
                const parent = node.parentElement;
                if (!parent) return NodeFilter.FILTER_REJECT;
                const tag = parent.tagName;
                if (['SCRIPT','STYLE','NOSCRIPT','OPTION'].includes(tag)) return NodeFilter.FILTER_REJECT;
                if (parent.closest('#translatorModal')) return NodeFilter.FILTER_REJECT;
                if (!node.textContent.trim()) return NodeFilter.FILTER_REJECT;
                return NodeFilter.FILTER_ACCEPT;
            }
        }
    );
    while (walker.nextNode()) {
        const node = walker.currentNode;
        const raw  = node.textContent;
        const text = raw.trim();
        if (text && !node._origText) {
            node._origText = text;
            // Store whitespace so we can restore it exactly after translation
            node._origWhitespace = {
                lead:  raw.match(/^\s*/)[0],
                trail: raw.match(/\s*$/)[0]
            };
        }
    }
    document.querySelectorAll('[placeholder]').forEach(el => {
        if (!el._origPlaceholder) {
            el._origPlaceholder = el.getAttribute('placeholder');
        }
    });
}

async function translateText(text, targetLang) {
    if (!text.trim()) return text;
    try {
        const url = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=${targetLang}&dt=t&q=${encodeURIComponent(text)}`;
        const res = await fetch(url);
        if (!res.ok) throw new Error('Network error');
        const data = await res.json();
        return data[0].map(chunk => chunk[0]).join('');
    } catch(e) { return text; }
}

function openTranslatorModal() {
    document.querySelectorAll('.lang-chip').forEach(c => c.classList.remove('selected'));
    selectedLangCode = '';
    selectedLangName = '';
    const status = document.getElementById('transStatus');
    status.style.display = 'none';
    const btn = document.getElementById('transConfirmBtn');
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-language me-2"></i> Translate Now';
    const modal = new bootstrap.Modal(document.getElementById('translatorModal'));
    modal.show();
}

function selectLang(el, code) {
    document.querySelectorAll('.lang-chip').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selectedLangCode = code;
    selectedLangName = el.querySelector('span')
        ? el.textContent.replace(el.querySelector('.lang-flag').textContent, '').trim()
        : el.textContent.trim();
}

async function executePageTranslation() {
    if (!selectedLangCode) { showToast('⚠️', 'Please select a language first.'); return; }
    const status = document.getElementById('transStatus');
    const confirmBtn = document.getElementById('transConfirmBtn');
    status.style.display = 'flex';
    confirmBtn.disabled = true;

    // Helper: collect all translatable text nodes
    function getTranslatableNodes() {
        const nodes = [];
        const walker = document.createTreeWalker(
            document.body, NodeFilter.SHOW_TEXT,
            { acceptNode(node) {
                if (!node._origText) return NodeFilter.FILTER_REJECT;
                if (!node.parentElement) return NodeFilter.FILTER_REJECT;
                const tag = node.parentElement.tagName;
                if (['SCRIPT','STYLE','NOSCRIPT','OPTION'].includes(tag)) return NodeFilter.FILTER_REJECT;
                if (node.parentElement.closest('#translatorModal')) return NodeFilter.FILTER_REJECT;
                return NodeFilter.FILTER_ACCEPT;
            }}
        );
        while (walker.nextNode()) nodes.push(walker.currentNode);
        return nodes;
    }

    // ── Restore to English first (always) ──
    // This ensures switching from Hindi → Marathi works correctly
    // by always going back to original English before translating to new language
    document.getElementById('transStatusText').textContent = 'Preparing translation...';
    getTranslatableNodes().forEach(node => {
        if (node._origText) {
            const leadWs = node._origWhitespace?.lead || '';
            const trailWs = node._origWhitespace?.trail || '';
            node.textContent = leadWs + node._origText + trailWs;
        }
    });
    document.querySelectorAll('[placeholder]').forEach(el => {
        if (el._origPlaceholder) el.setAttribute('placeholder', el._origPlaceholder);
    });

    // ── If English selected, we are done ──
    if (selectedLangCode === 'en') {
        bootstrap.Modal.getInstance(document.getElementById('translatorModal')).hide();
        showToast('✅', 'Page restored to English!');
        status.style.display = 'none';
        confirmBtn.disabled = false;
        confirmBtn.innerHTML = '<i class="fas fa-language me-2"></i> Translate Now';
        return;
    }

    // ── Translate to selected language ──
    const textNodes = getTranslatableNodes();
    const placeholderEls = [];
    document.querySelectorAll('[placeholder]').forEach(el => {
        if (el._origPlaceholder) placeholderEls.push(el);
    });

    const total = textNodes.length + placeholderEls.length;
    let done = 0;
    const updateProgress = () => {
        done++;
        const pct = Math.min(100, Math.round(done / total * 100));
        document.getElementById('transStatusText').textContent =
            `Translating to ${selectedLangName}... ${pct}%`;
    };

    const BATCH = 8;

    // Translate text nodes — always FROM _origText (original English)
    for (let i = 0; i < textNodes.length; i += BATCH) {
        const batch = textNodes.slice(i, i + BATCH);
        await Promise.all(batch.map(async node => {
            const translated = await translateText(node._origText, selectedLangCode);
            // Preserve original whitespace stored at snapshot time
            const lead  = node._origWhitespace?.lead  || '';
            const trail = node._origWhitespace?.trail || '';
            node.textContent = lead + translated + trail;
            updateProgress();
        }));
    }

    // Translate placeholders — always FROM _origPlaceholder
    for (let i = 0; i < placeholderEls.length; i += BATCH) {
        const batch = placeholderEls.slice(i, i + BATCH);
        await Promise.all(batch.map(async el => {
            const translated = await translateText(el._origPlaceholder, selectedLangCode);
            el.setAttribute('placeholder', translated);
            updateProgress();
        }));
    }

    bootstrap.Modal.getInstance(document.getElementById('translatorModal')).hide();
    showToast('🌐', `Page translated to ${selectedLangName}!`);
}
</script>
</body>
</html>

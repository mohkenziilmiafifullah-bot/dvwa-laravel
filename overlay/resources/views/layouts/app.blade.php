<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title') :: DVWA Laravel</title>
<style>
*{box-sizing:border-box}body{margin:0;font:15px/1.55 system-ui,Segoe UI,Arial,sans-serif;background:#0f172a;color:#e2e8f0}
header{background:#020617;padding:14px 24px;border-bottom:3px solid #16a34a}
header h1{margin:0;font-size:22px;letter-spacing:.5px}header span{color:#4ade80}
.wrap{display:flex;min-height:calc(100vh - 110px)}
nav{width:240px;background:#111c33;padding:14px 0;flex-shrink:0}
nav a{display:block;padding:9px 22px;color:#cbd5e1;text-decoration:none;border-left:3px solid transparent}
nav a:hover{background:#1e293b;border-left-color:#4ade80;color:#fff}
nav hr{border:0;border-top:1px solid #1e293b;margin:8px 0}
main{flex:1;padding:24px 32px;max-width:900px}
h2{margin-top:0;color:#4ade80}
input,select,textarea{background:#1e293b;color:#e2e8f0;border:1px solid #334155;border-radius:6px;padding:8px 10px;font:inherit;margin:4px 0 10px;min-width:260px}
button{background:#16a34a;color:#fff;border:0;border-radius:6px;padding:9px 18px;font:inherit;cursor:pointer}
button:hover{background:#15803d}
label{display:block;margin-top:6px}
.box{margin-top:16px;padding:12px 16px;border-radius:6px;border:1px solid #334155;background:#1e293b}
.box.ok{border-color:#16a34a;color:#86efac}.box.bad{border-color:#dc2626;color:#fca5a5}
pre{background:#020617;padding:12px;border-radius:6px;overflow:auto;white-space:pre-wrap}
.warn{background:#422006;border:1px solid #a16207;color:#fde68a;padding:10px 14px;border-radius:6px}
footer{padding:12px 24px;background:#020617;color:#94a3b8;font-size:13px}
a{color:#4ade80}
</style>
</head>
<body>
<header><h1>DVWA <span>Laravel</span> &mdash; Damn Vulnerable Web App</h1></header>
<div class="wrap">
<nav>
<a href="/">Home</a>
<a href="/setup">Setup / Reset DB</a>
<hr>
<a href="/vulnerabilities/brute">Brute Force</a>
<a href="/vulnerabilities/exec">Command Injection</a>
<a href="/vulnerabilities/csrf">CSRF</a>
<a href="/vulnerabilities/fi">File Inclusion</a>
<a href="/vulnerabilities/upload">File Upload</a>
<a href="/vulnerabilities/sqli">SQL Injection</a>
<a href="/vulnerabilities/sqli_blind">SQL Injection (Blind)</a>
<a href="/vulnerabilities/xss_r">XSS (Reflected)</a>
<a href="/vulnerabilities/xss_s">XSS (Stored)</a>
<hr>
<a href="/security">DVWA Security</a>
<a href="/logout">Logout</a>
</nav>
<main>@yield('content')</main>
</div>
<footer>Security Level: <b>{{ $level ?? 'low' }}</b> &nbsp;|&nbsp; User: <b>{{ session('dvwa_name') }}</b> &nbsp;|&nbsp; Hanya untuk latihan di localhost.</footer>
</body>
</html>

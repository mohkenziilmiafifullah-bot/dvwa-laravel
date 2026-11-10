@php
$plain = $plain ?? false;
$menu = [
  [['/', 'Home'], ['/instructions', 'Instructions'], ['/setup', 'Setup / Reset DB']],
  [['/vulnerabilities/brute', 'Brute Force'], ['/vulnerabilities/exec', 'Command Injection'], ['/vulnerabilities/csrf', 'CSRF'],
   ['/vulnerabilities/fi', 'File Inclusion'], ['/vulnerabilities/upload', 'File Upload'], ['/vulnerabilities/sqli', 'SQL Injection'],
   ['/vulnerabilities/sqli_blind', 'SQL Injection (Blind)'], ['/vulnerabilities/xss_r', 'XSS (Reflected)'], ['/vulnerabilities/xss_s', 'XSS (Stored)']],
  [['/security', 'DVWA Security'], ['/phpinfo', 'PHP Info'], ['/about', 'About']],
  [['/logout', 'Logout']],
];
$more = [
  'vulnerabilities/brute' => ['https://owasp.org/www-community/attacks/Brute_force_attack'],
  'vulnerabilities/exec' => ['https://owasp.org/www-community/attacks/Command_Injection'],
  'vulnerabilities/csrf' => ['https://owasp.org/www-community/attacks/csrf'],
  'vulnerabilities/fi' => ['https://en.wikipedia.org/wiki/File_inclusion_vulnerability'],
  'vulnerabilities/upload' => ['https://owasp.org/www-community/vulnerabilities/Unrestricted_File_Upload'],
  'vulnerabilities/sqli' => ['https://owasp.org/www-community/attacks/SQL_Injection'],
  'vulnerabilities/sqli_blind' => ['https://owasp.org/www-community/attacks/Blind_SQL_Injection', 'https://owasp.org/www-community/attacks/SQL_Injection'],
  'vulnerabilities/xss_r' => ['https://owasp.org/www-community/attacks/xss/'],
  'vulnerabilities/xss_s' => ['https://owasp.org/www-community/attacks/xss/'],
];
$links = $more[request()->path()] ?? [];
@endphp
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title') :: DVWA Laravel</title>
<style>
*{box-sizing:border-box}
body{margin:0;background:#e9e9e9;font:13px/1.5 Verdana,Arial,Helvetica,sans-serif;color:#000}
#page{width:940px;max-width:100%;margin:0 auto;background:#f4f4f4;min-height:100vh;box-shadow:0 0 0 1px #ddd}
#head{background:#2d2d2d;height:88px;display:flex;align-items:center;justify-content:center;border-bottom:4px solid #8dc63f}
#body{display:flex;padding:24px 16px 20px 16px;gap:22px;min-height:560px}
#menu{width:178px;flex-shrink:0}
#menu a{display:block;background:#c8c8c8;border:1px solid #9a9a9a;border-top-color:#e2e2e2;border-left-color:#e2e2e2;color:#111;font:bold 13px Arial,Helvetica,sans-serif;padding:3px 6px;margin-bottom:4px;text-decoration:none}
#menu a:hover{background:#d6d6d6}
#menu a.on{background:#8dc63f;color:#fff;border-color:#7ab02f}
#menu .gap{height:20px}
#main{flex:1;min-width:0}
h1,h2{font:bold 28px Arial,Helvetica,sans-serif;margin:0 0 14px;color:#111}
h3{font:bold 18px Arial,Helvetica,sans-serif;margin:22px 0 8px}
p{margin:8px 0}
a{color:#6aa121;font-weight:bold}
code{background:#e4e4e4;padding:1px 5px;border-radius:2px}
form{border:1px solid #000;padding:18px 22px;margin:16px 0;background:#f4f4f4}
label{display:block;margin-top:6px}
input,select,textarea{font:13px Arial,sans-serif;border:1px solid #999;padding:3px 4px;margin:2px 0 8px;background:#fff;min-width:170px}
input[type=file]{border:0;padding:0}
button{font:13px Arial,sans-serif;border:1px solid #777;background:#efefef;padding:2px 10px;margin-top:10px;cursor:pointer}
button:hover{background:#e0e0e0}
.box{margin:10px 0;padding:0}
.box.ok{color:#0a7a0a}.box.bad{color:#c00}
pre{background:#fff;border:1px solid #ccc;padding:8px;margin:10px 0;white-space:pre-wrap;overflow:auto;font:13px Consolas,monospace}
.warn{border:1px solid #c9a227;background:#fff8dc;padding:8px 12px}
#foot{text-align:center;font-size:12px;padding:10px;border-top:1px solid #ddd;color:#444}
#foot b{color:#000}
.logo-text{font:900 40px Arial Black,Arial,sans-serif;fill:#fff;letter-spacing:-2px}
.plain #body{justify-content:center}
.plain #main{max-width:420px}
@media(max-width:760px){#body{flex-direction:column}#menu{width:100%}}
</style>
</head>
<body>
<div id="page" class="{{ $plain ? 'plain' : '' }}">
<div id="head">
<svg width="140" height="76" viewBox="0 0 140 76" aria-label="DVWA">
<ellipse cx="72" cy="40" rx="58" ry="24" fill="none" stroke="#8dc63f" stroke-width="5" stroke-dasharray="250 70" transform="rotate(-16 72 40)"/>
<text x="70" y="52" text-anchor="middle" class="logo-text" font-size="40">DVWA</text>
</svg>
</div>
<div id="body">
@unless($plain)
<div id="menu">
@foreach($menu as $i => $group)
@if($i)<div class="gap"></div>@endif
@foreach($group as [$u, $label])
<a href="{{ $u }}" class="{{ request()->is($u === '/' ? '/' : ltrim($u, '/')) ? 'on' : '' }}">{{ $label }}</a>
@endforeach
@endforeach
</div>
@endunless
<div id="main">
@yield('content')
@if(count($links))
<h3>More Information</h3>
<ul>@foreach($links as $l)<li><a href="{{ $l }}" target="_blank" rel="noopener">{{ $l }}</a></li>@endforeach</ul>
@endif
</div>
</div>
@unless($plain)
<div id="foot">Username: <b>{{ session('dvwa_name') }}</b> &nbsp; Security Level: <b>{{ $level ?? 'low' }}</b> &nbsp; Locale: <b>id</b> &nbsp; SQLi DB: <b>MySQL</b><br>DVWA Laravel &mdash; hanya untuk latihan di localhost</div>
@endunless
</div>
</body>
</html>

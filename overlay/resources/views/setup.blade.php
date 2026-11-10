<!doctype html>
<html lang="id"><head><meta charset="utf-8"><title>Setup :: DVWA Laravel</title>
<style>body{margin:0;min-height:100vh;display:grid;place-items:center;background:#0f172a;color:#e2e8f0;font:15px system-ui,Segoe UI,Arial}
.card{background:#111c33;padding:32px;border-radius:12px;width:480px;border-top:4px solid #16a34a}
button{background:#16a34a;color:#fff;border:0;border-radius:6px;padding:10px 18px;font:inherit;cursor:pointer}
code{background:#020617;padding:2px 6px;border-radius:4px}a{color:#4ade80}.m{background:#1e293b;padding:10px;border-radius:6px;margin:12px 0}</style></head>
<body><div class="card"><h2 style="margin-top:0;color:#4ade80">Setup / Reset Database</h2>
<p>Database: <code>{{ $info['db'] }}</code><br>Jumlah user: <code>{{ $info['users'] }}</code><br>PHP: <code>{{ PHP_VERSION }}</code> ({{ PHP_OS_FAMILY }})</p>
@if($msg)<div class="m">{{ $msg }}</div>@endif
<form method="POST" action="/setup"><button>Reset data DVWA</button></form>
<p><a href="/">&larr; Kembali</a></p></div></body></html>

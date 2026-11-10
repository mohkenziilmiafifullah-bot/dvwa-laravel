<!doctype html>
<html lang="id"><head><meta charset="utf-8"><title>Login :: DVWA Laravel</title>
<style>body{margin:0;min-height:100vh;display:grid;place-items:center;background:#0f172a;color:#e2e8f0;font:15px system-ui,Segoe UI,Arial}
.card{background:#111c33;padding:32px;border-radius:12px;width:340px;border-top:4px solid #16a34a}
h1{margin:0 0 4px;font-size:22px}h1 span{color:#4ade80}p{color:#94a3b8;margin-top:0}
input{width:100%;background:#1e293b;color:#e2e8f0;border:1px solid #334155;border-radius:6px;padding:10px;margin:4px 0 12px;font:inherit}
button{width:100%;background:#16a34a;color:#fff;border:0;border-radius:6px;padding:11px;font:inherit;cursor:pointer}
.err{color:#fca5a5;margin-bottom:10px}a{color:#4ade80}</style></head>
<body><form class="card" method="POST" action="/login">
<h1>DVWA <span>Laravel</span></h1><p>Default: admin / password</p>
@if($error)<div class="err">{{ $error }}</div>@endif
<label>Username</label><input name="username" autofocus>
<label>Password</label><input type="password" name="password">
<button>Login</button>
<p style="margin-top:14px"><a href="/setup">Setup / Reset Database</a></p>
</form></body></html>

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/**
 * DVWA versi Laravel - SENGAJA RENTAN. Jalankan hanya di localhost untuk belajar.
 */
class DvwaController extends Controller
{
    /* ---------- helper ---------- */
    private function level(): string
    {
        return session('security', 'low');
    }

    private function page(string $view, array $data = [])
    {
        session(['user_token' => bin2hex(random_bytes(16))]);
        return view($view, $data + [
            'level' => $this->level(),
            'token' => session('user_token'),
            'out'   => null,
        ]);
    }

    private function tokenOk(Request $r): bool
    {
        $ok = hash_equals((string) session('user_token', ''), (string) $r->input('user_token', ''));
        session()->forget('user_token');
        return $ok;
    }

    private function esc(string $s): string
    {
        return substr(DB::getPdo()->quote($s), 1, -1);
    }

    private function me()
    {
        return DB::table('dvwa_users')->where('user_id', session('dvwa_user'))->first();
    }

    /* ---------- umum ---------- */
    public function login(Request $r)
    {
        if ($r->isMethod('post')) {
            $u = DB::table('dvwa_users')
                ->where('user', (string) $r->input('username'))
                ->where('password', md5((string) $r->input('password')))
                ->first();
            if ($u) {
                $r->session()->regenerate();
                session(['dvwa_user' => $u->user_id, 'dvwa_name' => $u->user, 'security' => 'low']);
                return redirect('/');
            }
            return view('login', ['error' => 'Login gagal. Coba lagi.']);
        }
        return view('login', ['error' => null]);
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }

    public function home()
    {
        return $this->page('home');
    }

    public function security(Request $r)
    {
        if ($r->isMethod('post')) {
            $l = $r->input('security');
            if (in_array($l, ['low', 'medium', 'high', 'impossible'], true)) {
                session(['security' => $l]);
            }
        }
        return $this->page('security');
    }

    public function setup(Request $r)
    {
        $msg = null;
        $info = ['db' => '-', 'users' => '-'];
        try {
            if ($r->isMethod('post')) {
                Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\DvwaSeeder', '--force' => true]);
                $msg = 'Database DVWA berhasil direset.';
            }
            $info['db'] = DB::connection()->getDatabaseName();
            $info['users'] = DB::table('dvwa_users')->count();
        } catch (\Throwable $e) {
            $msg = 'Error: ' . $e->getMessage();
        }
        return view('setup', ['msg' => $msg, 'info' => $info, 'level' => $this->level()]);
    }

    /* ---------- Brute Force ---------- */
    public function brute(Request $r)
    {
        if (!$r->has('Login')) {
            return $this->page('vuln.brute');
        }
        $level = $this->level();
        $user = (string) $r->query('username');
        $pass = (string) $r->query('password');
        $fail = fn (string $m) => $this->page('vuln.brute', ['out' => ['bad', $m]]);
        $ok = fn (string $m) => $this->page('vuln.brute', ['out' => ['ok', $m]]);

        if (in_array($level, ['high', 'impossible'], true) && !$this->tokenOk($r)) {
            return $fail('Token CSRF tidak valid.');
        }
        $hash = md5($pass);

        if ($level === 'impossible') {
            $row = DB::table('dvwa_users')->where('user', $user)->first();
            if ($row && $row->failed_login >= 3 && $row->last_login && strtotime($row->last_login) > time() - 900) {
                return $fail('Akun terkunci 15 menit karena terlalu banyak percobaan gagal.');
            }
            if ($row && hash_equals($row->password, $hash)) {
                DB::table('dvwa_users')->where('user_id', $row->user_id)->update(['failed_login' => 0]);
                return $ok("Selamat datang di area password, {$row->user}!");
            }
            if ($row) {
                DB::table('dvwa_users')->where('user_id', $row->user_id)
                    ->update(['failed_login' => DB::raw('failed_login + 1'), 'last_login' => now()]);
            }
            sleep(rand(2, 4));
            return $fail('Username dan/atau password salah.');
        }

        if ($level === 'high') {
            sleep(rand(0, 3));
        }
        $u = $level === 'low' ? $user : $this->esc($user); // low: rentan SQLi
        try {
            $rows = DB::select("SELECT * FROM dvwa_users WHERE user = '$u' AND password = '$hash'");
        } catch (\Throwable $e) {
            return $fail('SQL error: ' . $e->getMessage());
        }
        if (count($rows) === 1) {
            return $ok("Selamat datang di area password, {$rows[0]->user}!");
        }
        if ($level === 'medium') {
            sleep(2);
        }
        return $fail('Username dan/atau password salah.');
    }

    /* ---------- Command Injection ---------- */
    private function ping(string $t): string
    {
        $cmd = (PHP_OS_FAMILY === 'Windows' ? 'ping -n 4 ' : 'ping -c 4 ') . $t;
        return (string) shell_exec($cmd . ' 2>&1');
    }

    public function exec(Request $r)
    {
        $out = null;
        $level = $this->level();
        if ($r->isMethod('post') && $r->has('Submit')) {
            $target = (string) $r->input('ip');
            if ($level === 'impossible') {
                if (!$this->tokenOk($r)) {
                    $out = 'Token CSRF tidak valid.';
                } else {
                    $o = explode('.', $target);
                    if (count($o) === 4 && collect($o)->every(fn ($x) => ctype_digit($x) && (int) $x <= 255)) {
                        $out = $this->ping(implode('.', $o));
                    } else {
                        $out = 'ERROR: Masukkan alamat IP yang valid.';
                    }
                }
            } else {
                if ($level === 'medium') {
                    $target = str_replace(['&&', ';'], '', $target);
                } elseif ($level === 'high') {
                    $m = ['&' => '', ';' => '', '| ' => '', '-' => '', '$' => '', '(' => '', ')' => '', '`' => '', '||' => ''];
                    $target = str_replace(array_keys($m), array_values($m), $target);
                }
                $out = $this->ping($target);
            }
        }
        return $this->page('vuln.exec', ['out' => $out]);
    }

    /* ---------- CSRF ---------- */
    public function csrf(Request $r)
    {
        $level = $this->level();
        if (!$r->has('Change')) {
            return $this->page('vuln.csrf');
        }
        $bad = fn (string $m) => $this->page('vuln.csrf', ['out' => ['bad', $m]]);

        if ($level === 'medium' && stripos((string) $r->header('referer'), $r->getHost()) === false) {
            return $bad('Request tidak valid (Referer).');
        }
        if (in_array($level, ['high', 'impossible'], true) && !$this->tokenOk($r)) {
            return $bad('Token CSRF tidak valid.');
        }
        if ($level === 'impossible' && md5((string) $r->input('password_current')) !== $this->me()->password) {
            return $bad('Password saat ini salah.');
        }
        $new = (string) $r->input('password_new');
        if ($new === '' || $new !== (string) $r->input('password_conf')) {
            return $bad('Password baru tidak sama / kosong.');
        }
        DB::table('dvwa_users')->where('user_id', session('dvwa_user'))->update(['password' => md5($new)]);
        return $this->page('vuln.csrf', ['out' => ['ok', 'Password berhasil diganti.']]);
    }

    /* ---------- File Inclusion ---------- */
    public function fi(Request $r)
    {
        $level = $this->level();
        $page = (string) $r->query('page', '');
        $out = null;
        $err = null;
        if ($page !== '') {
            $base = resource_path('fi');
            if ($level === 'impossible') {
                if (in_array($page, ['file1.php', 'file2.php', 'file3.php'], true)) {
                    $out = file_get_contents("$base/$page");
                } else {
                    $err = 'ERROR: File tidak ditemukan!';
                }
            } else {
                if ($level === 'medium') {
                    $page = str_replace(['http://', 'https://', '../', '..\\'], '', $page);
                } elseif ($level === 'high' && !fnmatch('file*', $page)) {
                    $err = 'ERROR: File tidak ditemukan!';
                }
                if (!$err) {
                    chdir($base);
                    $out = @file_get_contents($page); // isi file hanya DITAMPILKAN, tidak dieksekusi
                    if ($out === false) {
                        $out = null;
                        $err = 'ERROR: File tidak ditemukan!';
                    }
                }
            }
        }
        return $this->page('vuln.fi', ['out' => $out, 'err' => $err]);
    }

    /* ---------- File Upload ---------- */
    public function upload(Request $r)
    {
        $level = $this->level();
        $out = null;
        if ($r->isMethod('post') && $r->has('Upload')) {
            $f = $r->file('uploaded');
            if (!$f || !$f->isValid()) {
                $out = ['bad', 'Pilih file terlebih dahulu.'];
            } else {
                $dir = public_path('hackable/uploads');
                if (!is_dir($dir)) {
                    @mkdir($dir, 0777, true);
                }
                $name = basename($f->getClientOriginalName());
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $why = null;

                if ($level === 'medium') {
                    if (!in_array($f->getClientMimeType(), ['image/jpeg', 'image/png'], true) || $f->getSize() >= 100000) {
                        $why = 'Hanya JPEG/PNG di bawah 100KB.';
                    }
                } elseif ($level === 'high') {
                    if (!in_array($ext, ['jpg', 'jpeg', 'png'], true) || @getimagesize($f->getPathname()) === false || $f->getSize() >= 100000) {
                        $why = 'Hanya gambar JPG/PNG asli di bawah 100KB.';
                    }
                } elseif ($level === 'impossible') {
                    if (!$this->tokenOk($r)) {
                        $why = 'Token CSRF tidak valid.';
                    } elseif (!in_array($ext, ['jpg', 'jpeg', 'png'], true) || @getimagesize($f->getPathname()) === false || $f->getSize() >= 100000) {
                        $why = 'Hanya gambar JPG/PNG asli di bawah 100KB.';
                    } else {
                        $png = $ext === 'png';
                        $name = md5(uniqid('', true)) . ($png ? '.png' : '.jpg');
                        $img = function_exists('imagecreatefrompng')
                            ? ($png ? @imagecreatefrompng($f->getPathname()) : @imagecreatefromjpeg($f->getPathname()))
                            : false;
                        if ($img) { // re-encode: membuang payload tersembunyi
                            $png ? imagepng($img, "$dir/$name") : imagejpeg($img, "$dir/$name");
                            $out = ['ok', "hackable/uploads/$name berhasil diunggah."];
                        } else {
                            $f->move($dir, $name);
                            $out = ['ok', "hackable/uploads/$name berhasil diunggah."];
                        }
                    }
                }

                if ($why) {
                    $out = ['bad', $why];
                } elseif (!$out) {
                    $f->move($dir, $name);
                    $out = ['ok', "hackable/uploads/$name berhasil diunggah."];
                }
            }
        }
        return $this->page('vuln.upload', ['out' => $out]);
    }

    /* ---------- SQL Injection ---------- */
    public function sqli(Request $r)
    {
        return $this->runSqli($r, false);
    }

    public function sqliBlind(Request $r)
    {
        return $this->runSqli($r, true);
    }

    private function runSqli(Request $r, bool $blind)
    {
        $level = $this->level();
        $id = $r->input('id');
        $rows = null;
        $msg = null;

        if ($r->has('Submit') && $id !== null) {
            $id = (string) $id;
            try {
                if ($level === 'impossible') {
                    if (!$this->tokenOk($r)) {
                        $msg = 'Token CSRF tidak valid.';
                    } elseif (!ctype_digit($id)) {
                        $msg = 'ID tidak valid.';
                    } else {
                        $rows = DB::select('SELECT first_name, last_name FROM dvwa_users WHERE user_id = ? LIMIT 1', [(int) $id]);
                    }
                } else {
                    $sql = match ($level) {
                        'low'    => "SELECT first_name, last_name FROM dvwa_users WHERE user_id = '$id'",
                        'medium' => 'SELECT first_name, last_name FROM dvwa_users WHERE user_id = ' . $this->esc($id),
                        default  => "SELECT first_name, last_name FROM dvwa_users WHERE user_id = '$id' LIMIT 1",
                    };
                    $rows = DB::select($sql);
                }
            } catch (\Throwable $e) {
                if ($blind) {
                    $rows = [];
                } else {
                    $msg = 'SQL error: ' . $e->getMessage();
                }
            }
            if ($blind && $rows !== null) {
                $msg = count($rows) > 0 ? 'User ID ADA di database.' : 'User ID TIDAK ADA di database.';
                $rows = null;
            }
        }
        return $this->page('vuln.sqli', ['blind' => $blind, 'rows' => $rows, 'msg' => $msg, 'id' => $id]);
    }

    /* ---------- XSS Reflected ---------- */
    public function xssR(Request $r)
    {
        $level = $this->level();
        $name = $r->query('name');
        $out = null;
        if ($name !== null && $name !== '') {
            $name = (string) $name;
            if ($level === 'medium') {
                $name = str_replace('<script>', '', $name);
            } elseif ($level === 'high') {
                $name = preg_replace('/<(.*)s(.*)c(.*)r(.*)i(.*)p(.*)t/i', '', $name);
            } elseif ($level === 'impossible') {
                if (!$this->tokenOk($r)) {
                    return $this->page('vuln.xss_r', ['out' => 'Token CSRF tidak valid.']);
                }
                $name = htmlspecialchars($name);
            }
            $out = "Hello $name";
        }
        return $this->page('vuln.xss_r', ['out' => $out]);
    }

    /* ---------- XSS Stored ---------- */
    public function xssS(Request $r)
    {
        $level = $this->level();
        if ($r->isMethod('post')) {
            if ($r->has('btnClear')) {
                DB::table('guestbook')->delete();
            } elseif ($r->has('btnSign')) {
                $msg = trim((string) $r->input('mtxMessage'));
                $name = trim((string) $r->input('txtName'));
                $allowed = true;
                if ($level === 'medium') {
                    $msg = htmlspecialchars(strip_tags($msg));
                    $name = str_replace('<script>', '', $name);
                } elseif ($level === 'high') {
                    $msg = htmlspecialchars(strip_tags($msg));
                    $name = preg_replace('/<(.*)s(.*)c(.*)r(.*)i(.*)p(.*)t/i', '', $name);
                } elseif ($level === 'impossible') {
                    $allowed = $this->tokenOk($r);
                    $msg = htmlspecialchars($msg);
                    $name = htmlspecialchars($name);
                }
                if ($allowed && $msg !== '' && $name !== '') {
                    DB::table('guestbook')->insert([
                        'comment' => mb_substr($msg, 0, 300),
                        'name'    => mb_substr($name, 0, 100),
                    ]);
                }
            }
        }
        $entries = DB::table('guestbook')->orderByDesc('comment_id')->get();
        return $this->page('vuln.xss_s', ['entries' => $entries]);
    }
}

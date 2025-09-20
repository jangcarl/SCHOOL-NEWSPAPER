<?php
require_once __DIR__ . '/../includes/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  $db = (new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS));
  $stmt = $db->prepare('SELECT * FROM users WHERE email=? AND role="writer"');
  $stmt->execute([$_POST['email']]);
  $u = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($u && password_verify($_POST['password'], $u['password'])) {
    $_SESSION['user'] = $u;
    header('Location: index.php');
    exit;
  }
  $err = 'Invalid credentials';
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Writer Login - <?= APP_NAME ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --bg-beige: #f9f4ee;
      --accent-purple: #6b21a8;
      --muted-purple: #9f7aea;
    }

    body {
      background: var(--bg-beige);
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
    }

    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    }

    .header-emoji {
      font-size: 26px
    }

    .badge {
      background: var(--muted-purple);
      color: white;
      padding: 4px 8px;
      border-radius: 999px;
      font-weight: 600;
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6">
  <div class="w-full max-w-md p-6 card">
    <h2 style="color:var(--accent-purple)" class="text-xl font-bold">Writer Login</h2>
    <?php if (!empty($err)): ?>
      <div class="mt-3 p-2 rounded bg-red-50 text-red-700"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>
    <form method="post" class="mt-4 space-y-3">
      <input name="email" type="email" required placeholder="Email" class="w-full p-2 border rounded" />
      <input name="password" type="password" required placeholder="Password" class="w-full p-2 border rounded" />
      <div class="flex items-center justify-between">
        <button class="px-4 py-2 rounded" style="background:var(--accent-purple);color:white">Login</button>
        <a href="register.php" style="color:var(--muted-purple)">Register</a>
      </div>
    </form>
  </div>
</body>

</html>
<?php require_once __DIR__ . '/classloader.php';
require_once __DIR__ . '/classes/Article.php';
$a = (new Article())->get($_GET['id']); ?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($a['title']) ?> - <?= APP_NAME ?></title>
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

<body class="min-h-screen p-6">
  <div class="max-w-3xl mx-auto card p-6">
    <h1 style="color:var(--accent-purple)" class="text-2xl font-bold"><?= htmlspecialchars($a['title']) ?></h1>
    <div class="text-sm text-gray-500">by <?= htmlspecialchars($a['author_name']) ?> •
      <?= htmlspecialchars($a['created_at']) ?>
    </div>
    <?php if ($a['image']): ?><img src="<?= htmlspecialchars($a['image']) ?>"
        class="w-full mt-4 rounded" /><?php endif; ?>
    <div class="mt-4"><?= nl2br(htmlspecialchars($a['content'])) ?></div>
  </div>
</body>

</html>
<?php require_once __DIR__ . '/classloader.php';
require_once __DIR__ . '/classes/Article.php';
require_once __DIR__ . '/includes/navbar.php'; ?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Writer - <?= APP_NAME ?></title>
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
  <div class="max-w-6xl mx-auto">
    <div class="grid grid-cols-3 gap-6">
      <div class="card p-4">
        <h3 style="color:var(--accent-purple)">Post Article</h3>
        <form method="post" action="core/handleForms.php" enctype="multipart/form-data" class="mt-3 space-y-2">
          <input name="title" required placeholder="Title" class="w-full p-2 border rounded" />
          <textarea name="body" required placeholder="Write here..." class="w-full p-2 border rounded"></textarea>
          <input type="file" name="image" accept="image/*" class="w-full" />
          <input type="hidden" name="author_id" value="1" />
          <div class="flex items-center justify-between">
            <button name="post_article" class="px-3 py-2 rounded"
              style="background:var(--accent-purple);color:white">Publish</button>
            <a href="articles_submitted.php" style="color:var(--muted-purple)">Your submissions</a>
          </div>
        </form>
      </div>

      <div class="card p-4 col-span-2">
        <h3 style="color:var(--accent-purple)">Recent Articles</h3>
        <div class="mt-3 space-y-3">
          <?php foreach ((new Article())->all() as $a): ?>
            <div class="p-3 border rounded">
              <div class="flex items-center justify-between">
                <div>
                  <h4 class="font-semibold"><?= htmlspecialchars($a['title']) ?></h4>
                  <div class="text-sm text-gray-500">by <?= htmlspecialchars($a['author_name']) ?></div>
                </div>
                <a href="view_article.php?id=<?= $a['id'] ?>" style="color:var(--muted-purple)">View</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</body>

</html>
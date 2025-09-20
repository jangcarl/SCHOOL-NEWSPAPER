<?php /* placeholder - teacher's original file name preserved. Implement as needed. */
require_once __DIR__ . '/classloader.php'; require_once __DIR__ . '/classes/Article.php'; require_once __DIR__ . '/classes/User.php'; require_once __DIR__ . '/includes/navbar.php'; ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin - <?=APP_NAME?></title>
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
        <?php include __DIR__ . '/includes/navbar.php'; ?>
        <div class="grid grid-cols-3 gap-6">
            <div class="card p-4">
                <h3 style="color:var(--accent-purple)">Articles (quick manage)</h3>
                <ul class="mt-3">
                    <?php $am = new Article(); foreach($am->all() as $a): ?>
                    <li class="p-2 border-b">
                        <strong><?=htmlspecialchars($a['title'])?></strong>
                        <div class="text-sm text-gray-500"><?=htmlspecialchars($a['author_name'])?></div>
                        <form method="post" action="core/handleForms.php" class="mt-2">
                            <input type="hidden" name="article_id" value="<?= $a['id'] ?>" />
                            <input type="hidden" name="admin_id" value="1" />
                            <button name="delete_article" class="px-2 py-1 rounded text-sm"
                                style="background:#ef4444;color:white">Delete</button>
                        </form>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="card p-4 col-span-2">
                <h3 style="color:var(--accent-purple)">Grant Edit Access</h3>
                <form method="post" action="core/handleForms.php" class="flex gap-2 items-center mt-3">
                    <select name="article_id" class="p-2 border rounded" required>
                        <option value="">Select article</option>
                        <?php $am = new Article(); foreach($am->all() as $a): ?><option value="<?= $a['id'] ?>">
                            <?= htmlspecialchars($a['title']) ?></option><?php endforeach; ?>
                    </select>
                    <select name="writer_id" class="p-2 border rounded" required>
                        <option value="">Select writer</option>
                        <?php $um = new User(); foreach($um->allWriters() as $w): ?><option value="<?= $w['id'] ?>">
                            <?= htmlspecialchars($w['name']) ?></option><?php endforeach; ?>
                    </select>
                    <input type="hidden" name="admin_id" value="1" />
                    <button name="grant_access" class="px-3 py-2 rounded"
                        style="background:var(--accent-purple);color:white">Grant</button>
                </form>

                <h3 class="mt-6" style="color:var(--accent-purple)">All Articles</h3>
                <div class="mt-3 space-y-3">
                    <?php foreach((new Article())->all() as $a): ?>
                    <div class="p-3 border rounded">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold"><?=htmlspecialchars($a['title'])?></h4>
                                <div class="text-sm text-gray-500">by <?=htmlspecialchars($a['author_name'])?></div>
                            </div>
                            <a href="../writer/view_article.php?id=<?= $a['id'] ?>"
                                style="color:var(--muted-purple)">View</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
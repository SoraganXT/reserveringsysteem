<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/header.php';
require_role('owner');

if (!$business) {
    echo '<div class="container">No active business found.</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = (float) ($_POST['price'] ?? 0);
        $stock = (int) ($_POST['stock_qty'] ?? 0);
        $categoryId = (int) ($_POST['category_id'] ?? 0);

        if ($name === '') {
            $errors[] = 'Product name is required.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO products (business_id, category_id, name, description, price, stock_qty, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, 1, NOW(), NOW())');
            $stmt->execute([$business['id'], $categoryId, $name, $description, $price, $stock]);
        }
    }

    if ($action === 'stock') {
        $productId = (int) ($_POST['product_id'] ?? 0);
        $stock = (int) ($_POST['stock_qty'] ?? 0);
        $stmt = $pdo->prepare('UPDATE products SET stock_qty = ?, updated_at = NOW() WHERE id = ? AND business_id = ?');
        $stmt->execute([$stock, $productId, $business['id']]);
    }
}

$categories = $pdo->prepare('SELECT * FROM categories WHERE business_id = ? ORDER BY name');
$categories->execute([$business['id']]);
$categoryList = $categories->fetchAll();

$products = $pdo->prepare('SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.business_id = ? ORDER BY p.name');
$products->execute([$business['id']]);
$productList = $products->fetchAll();
?>
<section class="container">
    <div class="section-title">
        <h2>Products</h2>
        <a class="button secondary" href="/dashboard/index.php">Back to dashboard</a>
    </div>

    <?php if ($errors): ?>
        <div class="card" style="border-left: 4px solid #ef4444;">
            <?php foreach ($errors as $error): ?>
                <p><?= e($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card form-grid">
        <h3>Add product</h3>
        <form method="post" class="form-grid">
            <input type="hidden" name="action" value="add">
            <div>
                <label for="name">Name</label>
                <input id="name" name="name" required>
            </div>
            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="2"></textarea>
            </div>
            <div>
                <label for="price">Price</label>
                <input id="price" name="price" type="number" step="0.01">
            </div>
            <div>
                <label for="stock_qty">Stock quantity</label>
                <input id="stock_qty" name="stock_qty" type="number" min="0">
            </div>
            <div>
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id">
                    <option value="0">Uncategorized</option>
                    <?php foreach ($categoryList as $category): ?>
                        <option value="<?= e($category['id']); ?>"><?= e($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="button" type="submit">Add product</button>
        </form>
    </div>

    <table class="table" style="margin-top: 24px;">
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Update stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productList as $product): ?>
                <tr>
                    <td><?= e($product['name']); ?></td>
                    <td><?= e($product['category_name'] ?? ''); ?></td>
                    <td><?= e($product['stock_qty']); ?></td>
                    <td>
                        <form method="post" class="form-grid" style="grid-template-columns: 1fr auto; align-items: end;">
                            <input type="hidden" name="action" value="stock">
                            <input type="hidden" name="product_id" value="<?= e($product['id']); ?>">
                            <input name="stock_qty" type="number" min="0" value="<?= e($product['stock_qty']); ?>">
                            <button class="button secondary" type="submit">Save</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

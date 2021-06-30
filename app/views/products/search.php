<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="grid-galeria">
    <?php foreach ($data['products'] as $product) : ?>
        <div>
            <a href="<?= URLROOT; ?>/products/detail/<?= $product->id; ?>">
                <img src="<?= URLROOT; ?>/public/img/<?= $product->filename; ?>" alt="<?= $product->alt; ?>">
                <h4 class="card-title"><?= $product->name; ?> </h4>
                <p class="card-text"><?= number_format($product->price, 2); ?></p>
            </a>
        </div>
    <?php endforeach; ?>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
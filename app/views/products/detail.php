<?php require APPROOT . '/views/inc/header.php'; ?>
<br>
<div class="show-product">
    <div class="product-img">
        <img src="<?= URLROOT; ?>/public/img/<?= $data['product']->filename; ?>" alt="<?= $data['product']->alt; ?>">
    </div>
    <div class="product-text">
        <h3><?= $data['product']->name; ?></h4>
            <p class="price"><?= number_format($data['product']->price, 2); ?> €</p>
            <form action="<?= URLROOT; ?>/carts/add/<?= $data['product']->id; ?>" method="post">
                <input type="hidden" name="id" value="<?= $data['product']->id; ?>" />
                <input type="hidden" name="name" value="<?= $data['product']->name; ?>" />
                <input type="hidden" name="price" value="<?= $data['product']->price; ?>" />
                <input type="hidden" name="filename" value="<?= $data['product']->filename; ?>" />
                <input type="hidden" name="quantity" value="1" />
                <button class="boton-comprar boton-acceder" type="submit" value="add">AÑADIR</button>
            </form>
            <p class="description"><?= $data['product']->description; ?></p>
    </div>
</div>
<div class="reviews">
    <h3>Opiniones de nuestros usuarios</h3>
    <?php if (!empty($data['reviews'])) {
        foreach ($data['reviews'] as $review) : ?>
            <div class="review-card">
                <div class="review-title">
                    <h4><?= $review->title; ?></h4>
                    <p class="author"><?= $review->name; ?>,
                        <?php echo date('d-m-Y', strtotime($review->date)); ?></p>
                </div>
                <p class="review-text"><?= $review->text; ?></p>
            </div>
        <?php endforeach; ?>
    <?php } else { ?>
        <p>Aún no disponemos de ninguna valoración</p>
    <?php } ?>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
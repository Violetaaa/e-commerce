<?php 
if(!isLogged()){
    echo '<script>var loggedIn = false; </script>';
}
require APPROOT . '/views/inc/header.php'; ?>
<h2 class="user-title">Tus opiniones</h2>
<br>
<div>
    <?php
    if (isset($data['reviews'])) {
        foreach ($data['reviews'] as $review) : ?>
            <div class="review-card">
                <h4 class="review-product"><?= $review->name; ?></h4>
                <div class="review-title">
                    <h4><?= $review->title; ?></h4>
                    <p class="author">, <?php echo date('d-m-Y', strtotime($review->date)); ?></p>
                </div>
                <p class="review-text"><?= $review->text; ?></p>
                <br>
            </div>
    <?php endforeach;
    } ?>
    <div>
        <p><?php if (isset($data['errorReviews'])) {
                echo $data['errorReviews'];
            } ?></p>
    </div>
    <div>
        <p><?php if (isset($data['errorAdd'])) {
                echo $data['errorAdd']; ?></p>
    <?php } else { ?>
        <div class="add-comment cart-options">
            <a href="<?php echo URLROOT; ?>/reviews/add">Añadir comentario</a>
        </div>
    <?php } ?>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php require APPROOT . '/views/inc/header.php'; ?>
<h2 class="user-title">Tus opiniones</h2>
<!-- añadir comentario-->
<div class="add-comment">
    <h3>Añade un comentario</h3>
    <form action="<?php echo URLROOT; ?>/reviews/add" method="post">
        <div>
            <input type="text" placeholder="Título" name="title" class="<?php echo (!empty($data['error_title'])) ? 'error2' : ''; ?>" value="<?= htmlspecialchars($data['title']) ?>">
            <div class="error-review">
                <?= $data['error_title']; ?>
            </div>
        </div>
        <div>
            <textarea name="text" placeholder="Comentario" class="<?php echo (!empty($data['errorText'])) ? 'error2' : ''; ?>" value="<?= htmlspecialchars($data['text']) ?>"></textarea>
            <div class="error-review">
                <?= $data['errorText']; ?>
            </div>
        </div>
        <div class="grid-galeria">
        </div>
        <div>
            <label for="text">Productos</label>
            <select name="product_id">
                <option value="0">Selecciona una opción</option>
                <?php foreach ($data['products'] as $product) : ?>
                    <option value="<?= $product->id ?>"><?= $product->name; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="error-review">
                <?= $data['errorProduct']; ?>
            </div>
        </div>
        <button type="submit" class="send-comment enviar-form" value="Submit">ENVIAR</button>
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
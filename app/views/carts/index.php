<?php require APPROOT . '/views/inc/header.php'; ?>
<h2 class="cart-title">Resumen de la compra</h2>
<div class="cart">
  <!-- carrito vacío -->
  <?php if ((!count($_SESSION['cart'])) > 0) { ?>
    <div class="empty-cart">
      <img src="<?= URLROOT; ?>/public/img/empty-cart.svg" alt="carrito vacío">
      <h4><?php echo 'No tienes ningún artículo en la cesta'; ?></h4>
      <a href="<?= URLROOT ?>">Continúa comprando <i class="fas fa-chevron-right"></i></a>
    </div>
    <!-- carrito con productos -->
  <?php } else {
  ?>
    <div class="full-cart">
      <table>
        <?php foreach ($data['products'] as $product) : ?>
          <tr>
            <td>
              <div class="container-img-cart">
                <img src="<?= URLROOT; ?>/public/img/<?= $product['filename']; ?>">
              </div>
            </td>
            <td><?= $product['name']; ?></td>
            <td>
              <a href="<?= URLROOT; ?>/carts/decreaseQuantity/<?= $product['id']; ?>"><i class="fas fa-minus"></i></a>
              <?= $product['quantity']; ?>
              <a href="<?= URLROOT; ?>/carts/increaseQuantity/<?= $product['id']; ?>"><i class="fas fa-plus"></i></a>
            </td>
            <td><?= number_format($product['price'] * $product['quantity'], 2); ?> €</td>
            <td>
              <a href="<?= URLROOT; ?>/carts/delete/<?= $product['id']; ?>"><i class="far fa-times-circle"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
      <!-- botones y total  -->
      <div class="cart-options">
        <a href="<?= URLROOT ?>">Volver</a>
        <form class="empty" action="<?= URLROOT; ?>/carts/empty" method="post">
          <button type="submit" value="vaciar">Vaciar</button>
        </form>
        <h3>TOTAL <?= number_format($data['totalPrice'], 2) ?>€</h3>
      </div>

      <form class="buy" action="<?= URLROOT; ?>/carts/placeOrder" method="post">
        <button type="submit" value="comprar">comprar <i class="fas fa-chevron-right"></i>
        </button>
      </form>
    </div>
    <!-- cierre claúsula ELSE -->
  <?php } ?>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
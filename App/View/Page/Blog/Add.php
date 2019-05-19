<?php self::startBlock( 'title' ) ?>Форма добавления блога<?php self::endBlock( )?>

<?php self::startBlock( 'content' ) ?>
<h1>Форма добавления блога </h1>

<form action="" method="post">
  <?= ( ( isset( $a_error[ 'token' ] ) ) ? '<div class="alert alert-danger">' . $a_error['token'] . '</div>' : '' ); ?>
  <div class="row">
    <div class="col-md-3">
      <label for="note">Название товара</label>
      <input type="text" name="blog_title" id="blog_title" class="text" value="<?= ( ( isset( $a_data[ 'blog_title' ] ) ) ? $a_data[ 'blog_title' ] : '' ); ?>">
      <?= ( ( isset( $a_error[ 'blog_title' ] ) ) ? '<div class="alert alert-danger">' . $a_error[ 'blog_title' ] . '</div>' : '' ); ?>
    </div>

    <div class="col-md-12">
      <label for="note">Описание</label>
      <textarea class="textarea" name="blog_text" id="blog_text"><?= ( ( isset( $a_data[ 'blog_text' ] ) ) ? $a_data[ 'blog_text' ] : '' ); ?></textarea>
      <?= ( ( isset( $a_error[ 'blog_text' ] ) ) ? '<div class="alert alert-danger">' . $a_error[ 'blog_text' ] . '</div>' : '' ); ?>
    </div>
  </div>

  <input type="hidden" name="token" value="<?= self::getToken(  ) ?>">
  <div class="col-md-12">
    <input class="btn" name="submit_blog_add" type="submit" value="Добавить">
  </div>
</form>

<?php self::endBlock(  )?>

<?php self::setLayout( 'Main' ) ?>


<?php self::startBlock( 'title' ) ?>Форма добавления блога<?php self::endBlock( )?>

<?php self::startBlock( 'content' ) ?>
<h1>Форма добавления блога </h1>

<?php View\RenderForm::getForm('add') -> renderForm() ?>

<?php self::endBlock(  )?>

<?php self::setLayout( 'Main' ) ?>


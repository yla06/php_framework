<?php

if (version_compare( PHP_VERSION, '5.4.0', '<' ) )
   exit( 'Версия PHP не позволяет запустить скрипт. Обновите PHP до версии 5.4 и выше' );

define( 'EVRIKA_DEBUG', true );// віс помилки будуть показуватись, якщо false то ні

require_once '../Core/Bootstrap.php';

\Controller\FrontController::init();


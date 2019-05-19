
<html>
    <head>
        <title><?php self::startBlock( 'title' ) ?>Test<?php self::endBlock( 'title' ) ?></title>
        <link rel="stylesheet" href="/css/admin.css">
    </head>
    <body>
        <header>Admin Header</header>
        <section id="content">
            <?php self::declareBlock( 'content' )?>
        </section>    
        <footer>Footer</footer>
    </body>    
</html>

<html>
    <head>
        <title><?php self::startBlock( 'title' ) ?>Test<?php self::endBlock( 'title' ) ?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/main.css">
        
    </head>
    <body>
        <header>Header</header>
        <section id="content">
            <?php self::declareBlock( 'content' )?>
        </section>    
        <footer>Footer</footer>
    </body>    
</html>

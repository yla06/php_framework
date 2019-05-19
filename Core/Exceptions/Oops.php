<DOCTYPE html>
    <head>
        <meta charset="utf-8" />
        <title>Oops</title>
    </head>
    <body>
        <div>
            <p>
                Сталася технічна помилка
            </p>
            <?php if ( defined( 'EVRIKA_DEBUG' ) and EVRIKA_DEBUG ): ?>
      <fieldset>
        <legend>Error</legend>
        <?= $desc ?>
      </fieldset>
      <fieldset>
        <legend>File</legend>
        <?= $file ?>
      </fieldset>
      <fieldset>
        <legend>Line</legend>
        <?= $line ?>
      </fieldset>
      <fieldset>
        <legend>Trace</legend>
        <pre><?php print_r( $trace ) ?></pre>
      </fieldset>
      <?php endif ?>
    </div>
</body>
</html>

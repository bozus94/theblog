<div class="paginacion">
    <ul>
        <!-- boton de pagina anterior -->
        <?php if (paginaActual() == 1) : ?>
            <li class="disable">&laquo;</li>
        <?php else : ?>
            <li><a href="<?php echo $nombre_pagina; ?>?pagina=<?php echo paginaActual() - 1; ?>&buscar=<?php echo $consultaBD['busqueda'] ?> ">&laquo;</a></li>
        <?php endif; ?>

        <!-- paginas del blog -->
        <?php for ($i = 1; $i <= $numero_paginas; $i++) : ?>
            <?php if (paginaActual() === $i) : ?>
                <li class="activo"><?php echo $i; ?></li>
            <?php else :  ?>
                <li><a href="<?php echo $nombre_pagina; ?>?pagina=<?php echo $i; ?>&buscar=<?php echo $consultaBD['busqueda'] ?>"> <?php echo $i; ?></a></li>
            <?php endif;  ?>
        <?php endfor; ?>

        <!-- boton de siguiente pagina  -->
        <?php if (paginaActual() == $numero_paginas) : ?>
            <li class="disable">&raquo;</li>
        <?php else : ?>
            <li><a href="<?php echo $nombre_pagina; ?>?pagina=<?php echo paginaActual() + 1; ?>&buscar=<?php echo $consultaBD['busqueda'] ?> ">&raquo;</a></li>
        <?php endif; ?>
    </ul>
</div>
<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $propiedad->titulo; ?></h1>

    <picture>
        <img loading="lazy" src="imagenes/<?php echo $propiedad->imagen; ?>" alt="imagen de la propiedas">
    </picture>

    <div class="resumen-propiedad">
        <p class="precio">$<?php echo $propiedad->precio; ?></p>

        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono" src="build/img/icono_wc.svg" alt="icono wc">
                <p><?php echo $propiedad->wc; ?></p>
            </li>

            <li>
                <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                <p><?php echo $propiedad->estacionamiento; ?></p>
            </li>

            <li>
                <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                <p><?php echo $propiedad->habitaciones; ?></p>
            </li>
        </ul>

        <p>
            <?php echo $propiedad->descripcion; ?>
        </p>
    </div>
</main>
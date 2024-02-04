document.addEventListener("DOMContentLoaded", function() {

    eventListeners();
    darkMode();
})

// Dark Mode 
function darkMode() {
    // Identificamos la preferencia del usuario.
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    // console.log(prefiereDarkMode.matches);

    if(prefiereDarkMode.matches) { // Si tiene el modo oscuro en su pc = true
        document.body.classList.add('dark-mode'); // Activa el modo oscuro de la página.
    } else { // Si no tiene modo oscuro o si lo desactiva = false
        document.body.classList.remove('dark-mode'); // Desactivamos el modo oscuro.
    }

    // Hace que cambie el modo de la página de manera sin necesidad de recargar.
    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches) { 
            document.body.classList.add('dark-mode'); 
        } else { 
            document.body.classList.remove('dark-mode');
        }
    });

    const botonDarkMode = document.querySelector(".dark-mode-boton");

    botonDarkMode.addEventListener("click", activarDarkMode)
}

function activarDarkMode() {
    document.body.classList.toggle("dark-mode"); // Agrega la clase si no la tiene o en caso contrario la quita.
        // if(document.body.classList.contains("dark-mode")) {
        //     document.body.classList.remove("dark-mode")
        // } else {
        //     document.body.classList.add("dark-mode");
        // }
}

// Navegación Resposive.
function eventListeners() {
    const mobileMenu = document.querySelector(".mobile-menu");

    mobileMenu.addEventListener("click", nevagacionResposive);
}

function nevagacionResposive()  {
    const navegacion = document.querySelector(".navegacion");

    if(navegacion.classList.contains("mostrar")) {
        navegacion.classList.remove("mostrar");
    } else {
        navegacion.classList.add("mostrar");
    }
}
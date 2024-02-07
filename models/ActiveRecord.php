<?php

namespace Model;

class ActiveRecord {

    // Base de datos.
    protected static $db;
    protected static $columnasDB = [];

    protected static $tabla = "";

    // Errores.
    protected static $errores = [];
    
    // Definir la conexión a la BD
    public static function setDB($database) {
        self::$db = $database;
    }

    public function guardar() {
        if(!is_null($this->id)) {
            // Actualizar.
            $this->actualizar();
        } else {
            // Crear nuevo objeto.
            $this->crear();
        }
    }

    public function crear() {

        // Sanitizar los atributos.
        $atributos = $this->sanitizarAtributos();   

        // Insertar en la base de datos.
        $query = "INSERT INTO " . static::$tabla . " ( "; 
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ')";
        
        // Insertar en la BD.
        $resultado = self::$db->query($query);

        if($resultado) {
            // Redireccionar al usuario una vez creada la propiedad.
            header('Location: /admin?resultado=1');
        }
    }
    
    public function actualizar() {
        // Sanitizar los datos.
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "$key='$value'";
        }

        // Insertar en la base de datos
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(',', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";       
        $query .= " LIMIT 1 "; 

        $resultado = self::$db->query($query);

        if($resultado) {
            // Redireccionar al usuario una vez creada la propiedad.
            header('Location: /admin?resultado=2');
        }
    }

    // Eliminar un registro.
    public function eliminar() {
        // Eliminar el archivo.
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id);
        $restultado = self::$db->query($query);

        if($restultado) {
            // Elimina la imagen.
            $this->eliminarImagen();

            header('Location: /admin?resultado=3');
        }
    }

    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {

            if($columna == 'id') continue; // Ignoramos la columna 'id' y pasamos a la siguiente.

            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value); // Sanitizamos los valores ingresados.
        }
        return $sanitizado;
    }

    // Subida de archivos.
    public function setImagen($imagen) {
        // Elimina la imagen previa.
        if(!is_null($this->id)) { // 'isset' revisa que exista y que tambien tenga un valor.
            $this->eliminarImagen();
        }

        // Asignar al atributo de imagen el nombre de la imagen.
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Eliminar imagen.
    public function eliminarImagen() {
        // Comprobar si existe el archivo.
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);

        if($existeArchivo) {
            unlink(CARPETA_IMAGENES .  $this->imagen); // Si existe elimina la imagen previa.
        }
    }
    
    // Validación.
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {
        static::$errores = []; // Limpiamos los errores que haigan para después volverlos a llenar con los nueves errores.
        return static::$errores;
    }

    // Lista todas las propiedades.
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla; // Este módificador de acceso buscará la tabla de la clase que se esté llamando.

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Obtener una propiedad.
    public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad; // Este módificador de acceso buscará la tabla de la clase que se esté llamando.

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Busca un registro por su ID.
    public static function find($id) {
        $query = "SELECT * FROM ". static::$tabla . " WHERE id = $id"; // Realizamos la consulta

        $resultado = self::consultarSQL($query);

        return array_shift($resultado); // Esta función retorna el primer resultado de un arreglo.
    }

    public static function consultarSQL($query) {
        // Consultar a la base de datos.
        $resultado = self::$db->query($query);

        // Iterar los resultados.
        $array = [];
        while($registo = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registo);
        }

        // Liberar memoria.
        $resultado->free();

        // Retornar los resultados.
        return $array;
    }


    public static function crearObjeto($registo) {
        $objeto = new static; // Crear nuevo objeto de la clase que se esté heredando.

        foreach($registo as $key => $value) {
            if(property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Sincroniza el objeto en memoria con los nuevos cambios del usuario.
    public function sincronizar( $args = [] ) {
        
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) { // '$this' hace referencia al objeto actual.
                $this->$key = $value;
            }
        }
    }


}
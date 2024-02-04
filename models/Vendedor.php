<?php

namespace Model;

class Vendedor extends ActiveRecord {

    protected static $tabla = "vendedores";
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    // Atributos
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    // Constructor
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar() {
        // Validación del formulario.
        if(!$this->nombre) {
            self::$errores[] = "Debes de añadir un nombre";
        }

        if(!$this->apellido) {
            self::$errores[] = "Debes de añadir un apellido";
        }

        if(!$this->telefono) {
            self::$errores[] = "El número de teléfono es obligatorio";
        }

        // Expreción regular para que no se ingresen otros datos que no sean números en el campo de teléfono.
        // Expreción regular = Es una forma de buscar un patrón dentro de un texto.
        if(!preg_match('/[0-9]{10}/', $this->telefono)){ // Estamos indicando que se ingresarán números entre el 0 y 9, y que no seran mas de 10.
            self::$errores[] = "Formato Inválido";
        } 

        return self::$errores;
    }
}
<?php
class baseDatos{
    var $a_conexion;
    var $a_servidor;
    var $a_user;
    var $a_pwd;
    var $a_baseDatos;
    var $a_bloqRegistros;
    var $a_numRegistros;
    var $error;
    function __construct(){
        $this->a_pwd="12345";//Para acceder a cualquier elemto de la calse se usa $this->
        $this->a_user="Jon";
        $this->a_baseDatos="gasto";
        $this->a_servidor="localhost";
    }
    function open(){
        $this->a_conexion = mysqli_connect($this->a_servidor, $this->a_user,$this->a_pwd,$this->a_baseDatos);
    }
    function close(){
        mysqli_close($this->a_conexion);       
    }
    function query($query){
        try{
            $this->open();
            $this->a_bloqRegistros = mysqli_query($this->a_conexion, $query);
            if(strpos(strtoupper($query), "SELECT") !== false)
                $this->a_numRegistros = mysqli_affected_rows($this->a_conexion);
            $this->close();
        } catch (Exception $e) {
            $this->error = "Error al ejecutar la consulta: " . $e->getMessage();
        }
    }
    function campos(&$campos){
        $campos = array();
        for($campoN=0; $campoN < mysqli_num_fields($this->a_bloqRegistros); $campoN++){
            $campo = mysqli_fetch_field_direct($this->a_bloqRegistros, $campoN);
            $tabla=$campo->table;
            array_push($campos, $campo->name);
        }
        return $tabla;
    }

    function getRecord($query){
        $this->open();
        $this->a_bloqRegistros = mysqli_query($this->a_conexion, $query);
        $this->a_numRegistros = mysqli_num_rows( $this->a_bloqRegistros);
        $this->close();
        return mysqli_fetch_object($this->a_bloqRegistros);
    }
}
$oDB=new baseDatos();


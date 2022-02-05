<?php

use Mpdf\Tag\VarTag;

class Categoria{
	private $id;
	private $nombre;
	private $db;
	// Gestion de Categorias
	private $valor_almacen;
	private $nprod;
	// Fin Gestion de Categorias

	public function __construct() {
		$this->db = Database::connect();
	}
	
	// Gestion de Categorias
	public function checkProductos(){
		$control = false;
		$query =  $this->db->query("SELECT id FROM productos WHERE categoria_id = '{$this->getId()}';");
		if($query->num_rows == 0){
			$control = true;
		}
		return $control;
	}

	public function delete(){
		$sql = "DELETE FROM categorias WHERE id={$this->id}";
		$delete = $this->db->query($sql);
		
		$result = false;
		if($delete){
			$result = true;
		}
		return $result;
	}
	// Fin Gestion de Categorias

	function getId() {
		return $this->id;
	}

	function getNombre() {
		return $this->nombre;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setNombre($nombre) {
		$this->nombre = $this->db->real_escape_string($nombre);
	}

	public function getAll(){
		$categorias = $this->db->query("SELECT * , (SELECT sum(stock*precio) FROM productos WHERE categoria_id = c.id) AS 'valor_almacen' FROM categorias c ORDER BY id DESC ");
		//while ($cat = $categorias->fetch_object()) {
		//	$cat->nprod = self::nprod($cat->id);
		//}
		return $categorias;
	}

	public function nprod($id){
		$nprod = $this->db->query("SELECT COUNT(id) as 'num' FROM productos WHERE categoria_id = " .$id."");
		$res = $nprod->fetch_array()[0];
		return $res;
	}
	
	public function getOne(){
		$categoria = $this->db->query("SELECT * FROM categorias WHERE id={$this->getId()}");
		return $categoria->fetch_object();
	}
	
	public function save(){
		if($this->getId() != null){
			$sql = "UPDATE categorias SET nombre='{$this->getNombre()}' WHERE id='{$this->getId()}';";
		}else{
			$sql = "INSERT INTO categorias VALUES(NULL, '{$this->getNombre()}');";
		}

		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
}
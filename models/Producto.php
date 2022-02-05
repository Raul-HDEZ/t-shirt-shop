<?php

class Producto{
	private $id;
	private $categoria_id;
	private $nombre;
	private $descripcion;
	private $precio;
	private $stock;
	private $oferta;
	private $fecha;
	private $imagen;

	private $db;
	
	public function __construct() {
		$this->db = Database::connect();
	}
	
	function getId() {
		return $this->id;
	}

	function getCategoria_id() {
		return $this->categoria_id;
	}

	function getNombre() {
		return $this->nombre;
	}

	function getDescripcion() {
		return $this->descripcion;
	}

	function getPrecio() {
		return $this->precio;
	}

	function getStock() {
		return $this->stock;
	}

	function getOferta() {
		return $this->oferta;
	}

	function getFecha() {
		return $this->fecha;
	}

	function getImagen() {
		return $this->imagen;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setCategoria_id($categoria_id) {
		$this->categoria_id = $categoria_id;
	}

	function setNombre($nombre) {
		$this->nombre = $this->db->real_escape_string($nombre);
	}

	function setDescripcion($descripcion) {
		$this->descripcion = $this->db->real_escape_string($descripcion);
	}

	function setPrecio($precio) {
		$this->precio = $this->db->real_escape_string($precio);
	}

	function setStock($stock) {
		$this->stock = $this->db->real_escape_string($stock);
	}

	function setOferta($oferta) {
		$this->oferta = $this->db->real_escape_string($oferta);
	}

	function setFecha($fecha) {
		$this->fecha = $fecha;
	}

	function setImagen($imagen) {
		$this->imagen = $imagen;
	}

	public function getAll(){
		$productos = $this->db->query("SELECT * FROM productos ORDER BY id DESC");
		return $productos;
	}
	
	public function getAllCategory(){
		$sql = "SELECT p.*, c.nombre AS 'catnombre' FROM productos p "
				. "INNER JOIN categorias c ON c.id = p.categoria_id "
				. "WHERE p.categoria_id = {$this->getCategoria_id()} "
				. "ORDER BY id DESC";
		$productos = $this->db->query($sql);
		return $productos;
	}
	
	public function getRandom($limit){
		$productos = $this->db->query("SELECT * FROM productos ORDER BY RAND() LIMIT $limit");
		return $productos;
	}

	public function getPaginacion($limit, $offset){
		$productos = $this->db->query("SELECT * FROM productos LIMIT $limit OFFSET $offset");
		return $productos;
	}
	
	public function getOne(){
		$producto = $this->db->query("SELECT * FROM productos WHERE id = {$this->getId()}");
		return $producto->fetch_object();
	}
	
	public function save(){
		$sql = "INSERT INTO productos VALUES(NULL, {$this->getCategoria_id()}, '{$this->getNombre()}', '{$this->getDescripcion()}', {$this->getPrecio()}, {$this->getStock()}, '{$this->getOferta()}', CURDATE(), '{$this->getImagen()}');";
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function edit(){
		$sql = "UPDATE productos SET nombre='{$this->getNombre()}', descripcion='{$this->getDescripcion()}', precio={$this->getPrecio()}, stock={$this->getStock()}, oferta='{$this->getOferta()}', categoria_id={$this->getCategoria_id()}  ";
		
		if($this->getImagen() != null){
			$sql .= ", imagen='{$this->getImagen()}'";
		}
		
		$sql .= " WHERE id={$this->id};";
		
		
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function delete(){
		$sql = "DELETE FROM productos WHERE id={$this->id}";
		$delete = $this->db->query($sql);
		
		$result = false;
		if($delete){
			$result = true;
		}
		return $result;
	}

	// Gestion de Productos

	public function getVentas(){
		$ventas = $this->db->query("SELECT sum(unidades) FROM lineas_pedidos");
		$num = $ventas->fetch_assoc();
		return $num['sum(unidades)'];
	}

	public function getMasVendido(){
		$mas_vendido = $this->db->query("SELECT producto_id, SUM(`unidades`)as total FROM `lineas_pedidos` Group BY `producto_id` ORDER BY total DESC");
		$id = $mas_vendido->fetch_assoc();
		$id = $id['producto_id'];
		$resultado = self::getName($id);
		return $resultado;
	}
	
	public function getSinVentas(){
		$sin_ventas = $this->db->query("SELECT * FROM productos WHERE `id` NOT IN (SELECT `producto_id` from lineas_pedidos) ");
		return $sin_ventas;
	}

	public function getSinStock(){
		$sin_stock = $this->db->query("SELECT * FROM productos WHERE stock=0");
		return $sin_stock;
	}

	public function getName($id){
		$name = $this->db->query("SELECT nombre FROM productos WHERE id=$id");
		$name = $name->fetch_assoc();
		return $name['nombre'];
	}

	// Funcion extra

	public function getDashboardVentas(){
		$ventas = $this->db->query("SELECT producto_id, SUM(`unidades`)as total FROM `lineas_pedidos` Group BY `producto_id`");
		$arr = $ventas->fetch_all();
		for ($i=0; $i < count($arr); $i++) { 
			$arr[$i][0] = self::getDashboardNombre($arr[$i][0]);
		}
		return $arr;
	}

	public function getDashboardNombre($id){
		$nombre = $this->db->query("SELECT nombre FROM productos WHERE id=$id");
		$var = $nombre->fetch_all();
		return $var[0][0];
	}
	
}
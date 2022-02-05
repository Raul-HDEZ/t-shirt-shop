<?php
require_once 'models/Usuario.php';
require_once 'models/Pedido.php';

class usuarioController{
	
	public function index(){
		echo "Controlador Usuarios, Acción index";
	}
	
	public function registro(){
		require_once 'views/usuario/registro.php';
	}

	//Gestion de usuarios
	public function gestion(){
		Utils::isAdmin();
		
		$usuario = new Usuario();
		$usuarios = $usuario->getAll();
		
		require_once 'views/usuario/gestion.php';
	}
	

	//Crear Usuario
	public function crear(){
		Utils::isAdmin();
		require_once 'views/usuario/crear.php';
	}

	public function save(){
		if(isset($_POST)){
			
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
			$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
			$email = isset($_POST['email']) ? $_POST['email'] : false;
			$password = isset($_POST['password']) ? $_POST['password'] : false;
			
			if($nombre && $apellidos && $email && $password){
				$usuario = new Usuario();
				$usuario->setNombre($nombre);
				$usuario->setApellidos($apellidos);
				$usuario->setEmail($email);
				$usuario->setPassword($password);

				

				$save = $usuario->save();
				if($save){
					$_SESSION['register'] = "complete";
				}else{
					$_SESSION['register'] = "failed";
				}
			}else{
				$_SESSION['register'] = "failed";
			}
		}else{
			$_SESSION['register'] = "failed";
		}
		header("Location:".base_url.'usuario/registro');
	}

	//agregue esta
	public function saveAdmin(){
		if(isset($_POST)){
			
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
			$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
			$email = isset($_POST['email']) ? $_POST['email'] : false;
			$password = isset($_POST['password']) ? $_POST['password'] : false;

			$rol = isset($_POST['rol']) ? $_POST['rol'] : false;
			
			if($nombre && $apellidos && $email && $password &&$rol){
				$usuario = new Usuario();
				$usuario->setNombre($nombre);
				$usuario->setApellidos($apellidos);
				$usuario->setEmail($email);
				$usuario->setPassword($password);
				$usuario->setRol($rol);

				// se agrega Guardar la imagen
				if(isset($_FILES['imagen'])){
					$file = $_FILES['imagen'];
					$filename = $file['name'];
					$mimetype = $file['type'];

					if($mimetype == "image/jpg" || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif'){

						if(!is_dir('uploads/images')){
							mkdir('uploads/images', 0777, true);
						}

						$usuario->setImagen($filename);
						move_uploaded_file($file['tmp_name'], 'uploads/images/'.$filename);
					}
				}
				if(isset($_GET['id'])){
					$id = $_GET['id'];
					$usuario->setId($id);
					
					$save = $usuario->edit();
				}else{
					$save = $usuario->save();
				}

				if($save){
					$_SESSION['register'] = "complete";
				}else{
					$_SESSION['register'] = "failed";
				}
			}else{
				$_SESSION['register'] = "failed";
			}
		}else{
			$_SESSION['register'] = "failed";
		}
		header("Location:".base_url.'usuario/crear');
	}
	
	public function login(){
		if(isset($_POST)){
			// Identificar al usuario
			// Consulta a la base de datos
			$usuario = new Usuario();
			$usuario->setEmail($_POST['email']);
			$usuario->setPassword($_POST['password']);
			
			$identity = $usuario->login();
			
			if($identity && is_object($identity)){
				$_SESSION['identity'] = $identity;
				
				if($identity->rol == 'admin'){
					$_SESSION['admin'] = true;
				}
				
			}else{
				$_SESSION['error_login'] = 'Identificación fallida !!';
			}
		
		}
		header("Location:".base_url);
	}
	
	public function logout(){
		if(isset($_SESSION['identity'])){
			unset($_SESSION['identity']);
		}
		
		if(isset($_SESSION['admin'])){
			unset($_SESSION['admin']);
		}

		//Se borra el carrito cuando el ususario cierra sesion
		if(isset($_SESSION['carrito'])){
			unset($_SESSION['carrito']);
		}
		
		session_destroy();
		header("Location:".base_url);
	}

	//Editar Usuario
	public function editar(){
		Utils::isAdmin();
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$edit = true;
			
			$usuario = new Usuario();
			$usuario->setId($id);
			
			$user= $usuario->getOne();
			
			require_once 'views/usuario/crear.php';
			
		}else{
			header('Location:'.base_url.'usuario/gestion');
		}
	}


	//Funcion Eliminar Usuario
	public function eliminar(){
		Utils::isAdmin();
		
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$usuario = new Usuario();
			$usuario->setId($id);

			$pedidosCheck = $usuario->checkPedidos();
			if($pedidosCheck){
				$delete = $usuario->delete();
				if($delete){
					$_SESSION['delete'] = 'complete';
				}else{
					$_SESSION['delete'] = 'failed';
				}
			}else{
				$_SESSION['delete'] = 'failed';
			}
		}else{
			$_SESSION['delete'] = 'failed';
		}
		
		header('Location:'.base_url.'Usuario/gestion');
	}

	// Gestion de Usuarios

	public function editarUsuario(){
		Utils::isIdentity();
		$usuario = new Usuario();
		$usuario_id = $_SESSION['identity']->id;
		$usuario->setId($usuario_id);
		$usu = $usuario->getOne();


		require_once './views/usuario/editardatos.php';
	}

	public function guardarcambios(){
		if(isset($_POST)){
			//$_SESSION['modificaciones'] = [];
			$arrMod = [];

			$nombre = empty($_POST['nombre']) ?  false : $_POST['nombre'];
			$apellidos = empty($_POST['apellidos']) ? false : $_POST['apellidos'];
			$email = empty($_POST['email']) ? false : $_POST['email'];
			$direccion = empty($_POST['direccion']) ? false : $_POST['direccion'];
			$password = empty($_POST['password']) ? false : $_POST['password'];
			$conection = new Usuario();
			$usuario_id = $_SESSION['identity']->id;
			$conection->setId($usuario_id);
			$usuario = $conection->getOne($usuario_id);

			if($nombre && $nombre != $usuario->nombre){ $arrMod['nombre'] =$nombre; }
			if($apellidos && $apellidos != $usuario->apellidos){ $arrMod['apellidos'] = $apellidos; }
			if($email && $email != $usuario->email){
				if($conection->checkEmail($email)){ $arrMod["email"] = $email; }
			}
			if($direccion && $direccion != $usuario->direccion){ $arrMod['direccion'] =$direccion; }
			if($password && !empty($_POST['passwordN1']) && !empty($_POST['passwordN2'])){
				if(password_verify($password, $usuario->password)  &&  $_POST['passwordN1'] == $_POST['passwordN2']){
					$conection->setPassword($_POST['passwordN1']);
					$arrMod['password'] = $conection->getPassword($email);
				}
			}	
			$save = $conection->updateUsuario($arrMod);

			if($save){
				$_SESSION['userMod'] = "complete";

				// Guardo los datos nuevos en la sesion 
				$usuario = new Usuario();
				$usuario->setId($_SESSION['identity']->id);
				$usuario->setEmail($_POST['email']);
				$usuario->setPassword($_POST['password']);
				$identity = $usuario->getOne();
				var_dump($identity);
				$_SESSION['identity'] = $identity;
			}else{
				$_SESSION['userMod'] = "failed";
			}
		}else{
			$_SESSION['userMod'] = "failed";
		}
		header("Location:".base_url."");
	}

}
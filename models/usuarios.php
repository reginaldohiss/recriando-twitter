<?php
class usuarios extends model {

	private $uid;

	public function __construct($id = '') {
		parent::__construct();

		if(!empty($id)) {
			$this->uid = $id;
		}
	}
	
	public function isLogged() {

		if(isset($_SESSION['twlg']) && !empty($_SESSION['twlg'])) {
			return true;
		} else {
			return false;
		}

	}

	public function usuarioExiste($email) {

		$sql = "SELECT * FROM usuarios WHERE email = '$email'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}

	}

	public function inserirUsuario($nome, $email, $senha) {

		$sql = "INSERT INTO usuarios SET nome = '$nome', email = '$email', senha = '$senha'";
		$this->db->query($sql);

		$id = $this->db->lastInsertId();

		return $id;
	}

	public function fazerLogin($email, $senha) {

		$sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$sql = $sql->fetch();

			$_SESSION['twlg'] = $sql['id'];

			return true;
		} else {
			return false;
		}	

	}

	public function getNome() {

		if(!empty($this->uid)) {

			$sql = "SELECT nome FROM usuarios WHERE id = '".($this->uid)."'";
			$sql = $this->db->query($sql);

			if($sql->rowCount() > 0) {
				$sql = $sql->fetch();
				return $sql['nome'];
			}			

		}

	}

	public function countSeguidos() {
		
		$sql = "SELECT * FROM relacionamentos WHERE id_seguidor = '".($this->uid)."'";
		$sql = $this->db->query($sql);

		return $sql->rowCount();

	}

	public function countSeguidores() {
		$sql = "SELECT * FROM relacionamentos WHERE id_seguido = '".($this->uid)."'";
		$sql = $this->db->query($sql);

		return $sql->rowCount();
	}

	public function getUsuarios($limite) {
		$array = array();

		$sql = "SELECT
		*,
		(select count(*) from relacionamentos where relacionamentos.id_seguidor = '".($this->uid)."' AND relacionamentos.id_seguido = usuarios.id  ) as seguido
		FROM usuarios WHERE id != '".($this->uid)."' LIMIT $limite";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getSeguidos() {
		$array = array();

		$sql = "SELECT id_seguido FROM relacionamentos WHERE id_seguidor = '".($this->uid)."'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$sql = $sql->fetchAll();
			foreach($sql as $seg) {
				$array[] = $seg['id_seguido'];
			}
		}

		return $array;
	}

}
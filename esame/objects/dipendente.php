<?php
	
	
	class Dipendente {
		//proprietà
		private $nome = "";
		private $cognome = "";
		private $telefono = "";
		private $cf = "";
		private $mail = "";
		private $ruolo = "";

		//costruttore
		public function __construct($nome,$cognome,$telefono, $cf, $mail, $ruolo)
		{
			//inizializzazione della proprietà $name
			$this->nome = $nome;
			$this->cognome = $cognome;
			$this->telefono = $telefono;
			$this->cf = $cf;
			$this->mail = $mail;
			$this->ruolo = $ruolo;
		}
		//metodi
		public function getNome() {
			//$this rappresenta l'oggetto che sarà costruito a runtime
			return $this->nome;
		}
		public function getCognome() {
			//$this rappresenta l'oggetto che sarà costruito a runtime
			return $this->cognome;
		}
		public function getTelefono() {
			//$this rappresenta l'oggetto che sarà costruito a runtime
			return $this->telefono;
		}
		public function getCf() {
			//$this rappresenta l'oggetto che sarà costruito a runtime
			return $this->cf;
		}
		public function getMail() {
			//$this rappresenta l'oggetto che sarà costruito a runtime
			return $this->mail;
		}
		public function getRuolo() {
			//$this rappresenta l'oggetto che sarà costruito a runtime
			return $this->ruolo;
		}
	}
	
	
?>
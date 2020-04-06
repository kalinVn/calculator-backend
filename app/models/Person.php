<?php
	namespace app\models;
	
	class Person{
		public $id;
		public $typePerson;
		public $transactions = [];
		public $operationPerWeek = 0;

		public function __construct($typePerson, $id) {
			$this->id = $id;
			$this->typePerson = $typePerson;
		}
		
		
		public function __setId($id){
			$this->id = $id;
		}
		
		
		public function __getId($id){
			return $this->id;
		}
		
		
		public function __setTypePerson($typePerson){
			$this->id = $id;
		}
		
		public function __getTypePerson($typePerson){
			return $this->typePerson;
		}
		
		public function addTransation($transActionData){
			
			array_push($this->transactions, $transActionData );
			
		}
		
		public function getTransation($transActionData){
			return $this->transactions;
		}



	}
	
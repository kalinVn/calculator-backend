<?php
	
	use app\models\Person as Person;
	
	class PersonTest extends \PHPUnit\Framework\TestCase {
		
		private $person;
		
		public function setUp() : void{
			$this->person = new Person('legal', 5);
		}
		
		public function testPersonId() {
			$this->assertEquals($this->person->id, 5);
		}
		
		public function testPersonType() {
			$this->assertEquals($this->person->typePerson, 'legal');
		}
		
		public function testTransactions() {
			$testTransactions = [];
			$testTransactions[] = [
				'EUR', 
				200.00, 
				2016-01-05
			];
			$this->person->addTransation($testTransactions);
			$this->assertEquals($this->person->transactions[0], $testTransactions);
			$this->assertEquals(count($this->person->transactions), 1);
		}
		
		
		
	}
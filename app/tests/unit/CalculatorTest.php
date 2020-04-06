<?php
	
	use app\models\Calculator as Calculator;
	use app\Config\Registry as Registry;
	class CalculatorTest extends \PHPUnit\Framework\TestCase {
		
		private $calculator;
		public $data;
		public function setUp() : void{
			$this->calculator = new Calculator();
			$this->data = [];
			$this->data[] = [
				"date" => "2014-12-31" ,
				"id" =>  4 ,
				"typePerson" => "natural",
				"typeDeal" => "cash_out" ,
				"amount" => 1200.00,
				"currency" => "EUR",
			];
			$this->amount = $this->data[0]['amount'];
			$this->currency = $this->data[0]['currency'];
			$this->typeDeal =  "cashOut";
			$this->typePerson = $this->data[0]['typePerson'];
			$this->id = $this->data[0]['id'];
		}
		
		public function testCalculate() {
			$commisions = $this->calculator::calculate($this->data);
			$value = (float)$commisions[0];
			$count =  count( $this->data[0] );
			$this->assertCount(6, $this->data[0] );
		}
		
		public function testCashIn() {
			$reflClass = new ReflectionClass ($this->calculator);
			$privateMethod = $reflClass->getMethod ('cashIn');
			$privateMethod->setAccessible(true);
			$commision = $privateMethod->invoke ($reflClass, $this->amount, $this->currency);
			$this->assertEquals(0.36, $commision);
		}
	
		
		public function testCashOut() {
			$reflClass = new ReflectionClass ($this->calculator);
			$privateMethod = $reflClass->getMethod ('cashOut');
			$privateMethod->setAccessible(true);
			$person = new app\models\Person($this->data[0]['typePerson'],$this->id );
			$person->addTransation($this->data[0]);
			$commision = $privateMethod->invoke ($reflClass, $this->amount, $this->currency, $person );
			$this->assertEquals(0.60, (float)$commision);
		}
		
		
		
		
		
		
	}
<?php
	
	/**
		*Load csv file and and  calculate 
	*/

	namespace app\controllers;
	use app\models\Calculator as Calculator;
	use app\loaders\CsvLoader as CsvLoader;
	use app\models\Person as Person;
	use app\Config\Registry as Registry;
	use app\views\Response as Response;
	
	class App {
		public function init() {
			$data = CsvLoader::load();
			$model = Calculator::calculate($data);
			Response::render($model);
		}
	}
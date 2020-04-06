<?php
	namespace app\loaders;
	use app\validators\Validator as Validator;
	
	class CsvLoader {

		public  function load(){
			$file = file("input.csv");
			$data  = [];
		
			foreach($file as $key => $line){
				list($date, $id, $typePerson, $typeDeal, $amount, $currency) = explode(",", $line);
				$data[$key] = [
					'date' => trim((string)$date),
					"id" => trim((int)$id),
					'typePerson' => trim((string)$typePerson),
					'typeDeal' => trim((string)$typeDeal),
					'amount' => trim((float)$amount),
					'currency' => trim((string)$currency),
				];
			
			}
			foreach($data as  $values){
				foreach($values as  $key=>$value){
					$validate = Validator::validate($key, $value);
				}
			}
			
			return $data;
		}
	}
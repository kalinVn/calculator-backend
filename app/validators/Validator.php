<?php
	namespace app\validators;
	use app\exceptions\CsvException as CsvException;
	class Validator{	
		
		/**
			*Validate data array values from csv file
			*@param string $value
			*@param int|string $string
			*@return bool
		*/
		public static function validate($key, $value){
			$CsvException = new CsvException();
			$regex = '';
			switch ($key){
				case "date":
					$regex = '/^([0-9]{4})(-)((([0]{1})(([1-9]{1})))|(([1-2]{1})([0-9]{1}))|(([3]{1})([0-1]{1})))(-)((([3]{1})([0-1]))|([0-2]{1})([0-9]{1}))$/';
					break;
				case "currency":
					$regex = '/^([A-Z]{0,})$/';
					break;
				case "id":
					$regex = '/^([0-9]{0,})$/';
					break;
				case "typePerson" :
					$regex = '/^([A-Za-z\_]{0,})$/';
					break;
				case "typeDeal" :
					$regex = '/^([A-Za-z\_]{0,})$/';
					break;
				case "amount" :
					$regex = '/^([0-9\.]{0,})$/';
					break;
			}
			if(!(bool)preg_match($regex, $value)){
				throw new CsvException("CSV file cannot be read. "."Field ".$key." not vlid");
			}
			return (bool)preg_match($regex, $value);
		
		}	
	}
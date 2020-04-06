<?php
	namespace app\views;
	
	class Response {
		
		public function render($model){
		
			foreach($model as  $key => $value){
				$comission = $value[0];
				$currency = $value[1];
				$comission = self::ceilByCurrency($currency, $comission);
				echo $comission.PHP_EOL;
			
			}
			
		}
		
		private static function ceilByCurrency($currency, $comission){
			if($currency == "JPY" ){
				$comission = number_format(ceil($comission) , 0,  '.', '');
			}else{
				$comission = number_format(ceil(round($comission * 10 ) ) / 10 , 2,  '.', '');
			}
			return $comission;
		}
		
		
	}
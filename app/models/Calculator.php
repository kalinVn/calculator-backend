<?php
	namespace app\models;
	use app\config\Registry as Registry;
	const FREE_SUM_CHARGE = 1000;
	
	class Calculator {

		public static function calculate($data){
			Registry::setData("currency", [
				"EUR" => 1,
				"USD" => 1.1497,
				"JPY" => 129.53
			]);
			$persons = [];
			$personsId = [];
			$model = [];
			foreach($data as $value){
				$transActionData = [];
				$typePerson = $value['typePerson'];
				$id = intval($value['id']);
				$typeDeal = $value['typeDeal'];
				$currency = $value['currency'];
				$amount = $value['amount'];
				$date = $value['date'];
				$transActionData['currency'] = $currency;
				$transActionData['amount'] = $amount;
				$transActionData['date'] = $date;
				if(!in_array($id, $personsId)){
					$persons[$id] = new Person($typePerson, $id);
					$person = $persons[$id];
					if($typeDeal == 'cash_out'){
						$person->addTransation($transActionData);
					}
					array_push($personsId, $id );
					
				}else{
					if($typeDeal == 'cash_out'){
						$persons[$id]->addTransation($transActionData);
					}
					$person = $persons[$id];
				}
				$commission = self::getComission($amount, $typeDeal, $currency, $person);
				$model[] = [$commission, $currency];
				
				
			}
			return $model;
		
		}
		
		private static function getComission($amount, $typeDeal, $currency, $person) {
			if($typeDeal == "cash_in"){
				$comission = self::cashIn($amount, $currency);
				return $comission;
			}else{
				$commission = self::cashOut($amount, $currency, $person);
				return $commission;
			}

		}
		
		private static function calculateCommission($amount, $currency, $percent, $maxSum, $minSum) {
			if($maxSum > 0){
				$amount = self::convertCurrency($amount, $currency);
				$comission = ($percent/100 ) * $amount > $maxSum  ? $maxSum : ($percent/100 ) * $amount;
			}else if($minSum > 0){
				$amount = self::convertCurrency($amount, $currency);
				$comission = ($percent/100 ) * $amount < $minSum ? $minSum : ($percent/100 ) * $amount;
			}else {
				$comission = ($percent/100 ) * $amount;
			}
			return $comission;
		}
		
		private static function cashIn($amount, $currency) {
			
			$percent = 0.03;
			$maxSum = 5;
			$comission = self::calculateCommission($amount, $currency, $percent, $maxSum, 0);
			return $comission;
		}
		
		private static function cashOut($amount, $currency, $person) {
			
			if($person->typePerson == "legal"){
				$percent = 0.3;
				$minSum = 0.5;
				$comission = self::calculateCommission($amount, $currency, $percent, 0, $minSum);
				return $comission;

			}else{
				$operationPerWeek=0;
				$sumWeek = 0;
				$execuded = 0;
				$weekArr = 0;
				foreach($person->transactions as  $key => $transaction){
					if($key < count($person->transactions) - 1){
						$timestampCurrentTransaction = strtotime($transaction['date']);
						$timestampDayTransaction = strtotime($person->transactions[count($person->transactions) -1]['date']);
						$diffDays = abs($timestampCurrentTransaction - $timestampDayTransaction) / (60*60*24);
						$weekArr = self::weekOfYear($transaction['date'], $person->transactions[count($person->transactions) -1]['date']);
						if($diffDays <= 7 && count($weekArr) - 1 <= 0){
							$operationPerWeek++;
							$transaction['amount'] = self::convertCurrency($transaction['amount'], $transaction['currency']);
							$sumWeek += $transaction['amount'];	
							if($sumWeek > FREE_SUM_CHARGE ){
								$execuded = true;
							}
						}
						
					}else{
						$transaction['amount'] = self::convertCurrency($transaction['amount'], $transaction['currency']);
						$sumWeek += $transaction['amount'];
						if($sumWeek <= FREE_SUM_CHARGE){
							$execuded = false;
							$sumComission = $operationPerWeek <= 3 ? 0 :  $transaction['amount'];
							$execuded = $operationPerWeek <= 3 ? false : true;
						}
						else if($sumWeek > FREE_SUM_CHARGE){
							$sumComission = $execuded ?  $transaction['amount'] : $sumWeek - FREE_SUM_CHARGE;
							$execuded = true;
						}
						$comission =  self::calculateCommission($sumComission, $currency, 0.3, 0, 0);
						$currency = Registry::getData('currency')[$currency];
						$comission = $currency * $comission;
						return $comission;
					}
					
				}
			}
		}
		
		
		
		private static function convertCurrency($amount, $currency) {
			switch ($currency) {
				case "USD":
					return $amount / 1.1497;
				case "JPY":
					return $amount / 129.53;
				default:
					return $amount;
			}
		}
		
		private static function weekOfYear($startDate, $endDate){
			$startDate = date("Y-m-d", strtotime($startDate));
			$endDate = date("Y-m-d", strtotime($endDate));
			$yearEndDay = 31;
			$weekArr = [];
			$startYear = date("Y", strtotime($startDate));
			$endYear = date("Y", strtotime($endDate));

			if($startYear != $endYear) {
				$newStartDate = $startDate;
				for($i = $startYear; $i <= $endYear; $i++) {
					if($endYear == $i) {
						$newEndDate = $endDate;
					} else {
						$newEndDate = $i."-12-".$yearEndDay;
					}
					$startWeek = date("W", strtotime($newStartDate));
					$endWeek = date("W", strtotime($newEndDate));
					if($endWeek == 1){
						$endWeek = date("W", strtotime($i."-12-".($yearEndDay-7)));
					}
					$tempWeekArr = range($startWeek, $endWeek);
					$newStartDate = date("Y-m-d", strtotime($newEndDate . "+1 days"));
				}
			} else {
				$startWeek = date("W", strtotime($startDate));
				$endWeek = date("W", strtotime($endDate));
				$endWeekMonth = date("m", strtotime($endDate));
				if($endWeek == 1 && $endWeekMonth == 12){
					$endWeek = date("W", strtotime($endYear."-12-".($yearEndDay-7)));
				}
				$weekArr = range($startWeek, $endWeek);
			}
			$weekArr = array_fill_keys($weekArr, 0);
			return $weekArr;
		}
		
	}
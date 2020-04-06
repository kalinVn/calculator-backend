<?php
	namespace app\config;
	
	class Registry {
	
		private static $data = [];
		private function __construct(){
			
		}
		
		public static function setData($key, $val){
			self::$data[$key] = $val;
		}
		
		public static function getData($key){
			return self::$data[$key];
		
		}
	}
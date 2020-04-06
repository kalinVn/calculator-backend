# Calculator-backend

	Class App  
		Load csv file from class Loader (Loader return array ). 
		Get comissions array from calculate method from Calculate class that return calculated comissions array .
		Render array with Response class.

	Class Calculator 
		Method calculate parameter data is array passed in App class
		Declarate personsId array.
		Loop data array and for every one iteration  check personsId array.If dont exist id from data array in personsId array we create
		new Person class.If type is 'cash_out' we push date , amount and currency in Person->transactions array.Else we just push date,amount
		and currency from existing Person clas in Person->transactions array.After these conditions we check if parameter type is "cash_in" we
		call cashIn method in Calculator class which call calculateCommission method.If parameter type is "cash_out" ,we call cashOut method 
		witch loop person transactions array given from calculate method and calculate difrent between days , number week in year ,execuded
		sum.Based on this characters we calculate comission in cash_out method.
	Class Validator 
    In Loader class for every one field  call Validator validate method which use Regex expresions to validate field.
	
	Class Response render  display, rounding and ceil array value comissions from given comissions array in App class from Calculator calculate method
	
	Class Loader load csv file and explode and push fields from csv file in array and return array.

 
Test program 
vendor/bin/phpunit

Run program
php index.php

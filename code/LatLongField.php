<?php

class LatLongField extends TextField {
	
	private $js_input_selector = '$(that).val()';
	
	public function Field($properties = array()) {
		
		$this->addExtraClass('text'); // for styling...
		$this->setAttribute('data-selector', $this->getInputSelector());
		if(!$this->RightTitle()) 
			$this->setRightTitle('Type an address (eg. "49 Oxford Street, London") and click "Search"');
		
		return parent::Field($properties = array());
	}

	public function FieldHolder($properties = array()) {
		
		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::css(THIRDPARTY_DIR . '/jquery-ui-themes/smoothness/jquery-ui.css');
		Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery-ui/jquery-ui.js');
		
		Requirements::javascript('latlongfield/javascript/jquery.locationpicker.js');
		Requirements::javascript('latlongfield/javascript/latlongfield.js');
		Requirements::css('latlongfield/css/latlongfield.css');
		
		return parent::FieldHolder($properties = array());
	}
	
	/**
	 * Allow setting a custom js/jquery input selection for the address fields
	 * Javascript code which should return a string when evaluated, 'that' being the original field
	 */
	public function getInputSelector(){
		return $this->js_input_selector;
	}
	
	public function setInputSelector($val){
		$this->js_input_selector = $val;
	}
	
	
	/*
	 * Calculate the distance between two geo coordinates in KM
	 */
	public static function calCulateDistance($fromcoordinate, $tocoordinate, $decimals=0){
		// Create procedure if not exists;
		$exists = DB::query("SELECT IF( 
			EXISTS (
				SELECT 1 FROM Information_schema.Routines
				WHERE SPECIFIC_NAME = 'calc_distance' 
				AND ROUTINE_TYPE='FUNCTION'
				), 
			'function exists', 'not found')");
//		Debug::dump($exists->numRecords( ));
		if(array_shift( $exists->first() ) == 'not found'){
			Debug::dump('DEFINING');
			DB::query("CREATE FUNCTION calc_distance 
					(lat1 DECIMAL(10,6), long1 DECIMAL(10,6), lat2 DECIMAL(10,6), long2 DECIMAL(10,6))
					RETURNS DECIMAL(10,6)
					RETURN (6353 * 2 * ASIN(SQRT( 
							POWER(SIN((lat1 - abs(lat2)) * pi()/180 / 2),2) + COS(lat1 * pi()/180 ) 
							* COS( abs(lat2) *  pi()/180) * POWER(SIN((long1 - long2) *  pi()/180 / 2), $decimals) 
						)))");
		}
		$query_result = DB::query("SELECT ROUND(calc_distance($fromcoordinate,$tocoordinate), 0)");
		$result = array_shift( $query_result->first() );
//		Debug::dump("Distance between Eiffel Tower (48.858278,2.294254) and Big Ben (51.500705,-0.124575)
//			".DB::query("SELECT ROUND(calc_distance(51.500705,-0.124575,48.858278,2.294254), 2)")." KM");
		//Debug::dump("Distance Eiffel Tower (48.858278,2.294254) - Big Ben (51.500705,-0.124575): $result KM");
		return $result;
	}
	
}
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
	
}
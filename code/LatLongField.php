<?php

class LatLongField extends TextField {
	
	public function Field($properties = array()) {
		$this->addExtraClass('text'); // for styling...
		if(!$this->RightTitle()) $this->setRightTitle('Type an address (eg. "49 Oxford Street, London") and click "Search"');
		return parent::Field();
	}

	public function FieldHolder() {
		
		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::css(THIRDPARTY_DIR . '/jquery-ui-themes/smoothness/jquery-ui.css');
		Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery-ui/jquery-ui.js');
		
		Requirements::javascript('latlongfield/javascript/jquery.locationpicker.js');
		Requirements::javascript('latlongfield/javascript/latlongfield.js');
		Requirements::css('latlongfield/css/latlongfield.css');
		$html = parent::FieldHolder();
		return $html; 
	}
	
	
}
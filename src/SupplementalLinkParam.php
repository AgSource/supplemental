<?php
namespace agsource\supplemental;

/*
*
* Contains properties and methods specific supplemental data links for various sections of the website.
* 
* Supplemental links can be added to any level of the content hierarchy (column data, column headers, blocks, pages or sections).
* They are links to content that is designed to be deliver within another pages as an overlay or callout
* 
* @author: ctranel
* @date: May 9, 2014
*
*/

class SupplementalLinkParam
{
	/**
	 * link id
	 * @var int
	 **/
	protected $id;

	/**
	 * param name
	 * @var string
	 **/
	protected $name;
	
	/**
	 * param db field name
	 * @var string
	 **/
	protected $value_db_field_name;

	/**
	 * static param value
	 * @var string
	 **/
	protected $value;

	/**
	 * __construct
	 *
	 * @param: string name
	 * @param: string value
	 * @param: string field name from which value is derived
	 * @return void
	 * @author ctranel
	 **/
	public function __construct($name, $value, $value_db_field_name){
		$this->name = $name;
		$this->value_db_field_name = $value_db_field_name;
		$this->value = $value;
	}

	public function toArray(){
		$ret = [
            'name' => $this->name,
            'value_db_field_name' => $this->value_db_field_name,
            'value' => $this->value,
		];
		return $ret;
	}

	/* -----------------------------------------------------------------
	 *  returns url text for parameter

	 *  returns url text for parameter

	 *  @since: version
	 *  @author: ctranel
	 *  @date: Oct 28, 2014
	 *  @param bool is external link (uses '?' before param and '&' between k => v pairs)
	 *  @param bool is first param (needed for external links)
	 *  @return: string
	 *  @throws: 
	 * -----------------------------------------------------------------*/
	 public function urlText($external, $is_first_param) {
 		$param_text = '';
 		$value = $this->value;
 		if(isset($this->value_db_field_name) && !empty($this->value_db_field_name)){
 			$value = '{' . $this->value_db_field_name . '}';
 		}
	 	if($external){
			$param_text .= $is_first_param ? '?' : '&';
			$param_text .= $this->name. '=' . $value;
		}
		else{
			$param_text .= '/' . $value;
		}
		return $param_text;
	}
	
	/* -----------------------------------------------------------------
	 *  Factory function, takes a dataset and returns an object storage of Supplemental_link objects
	 *  @author: ctranel
	 *  @date: Oct 28, 2014
	 *  @return: string
	 *  @throws: 
	 * -----------------------------------------------------------------*/
	 public static function datasetToObjects($dataset) {
	 	$ret = [];
		if(isset($dataset) && is_array($dataset)){
			foreach($dataset as $r){
				$ret[] = new SupplementalLinkParam(
					$r['name'],
					$r['value'],
					$r['value_db_field_name']
				);
			}
		}
		return $ret;
	}
}
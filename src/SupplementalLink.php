<?php
namespace agsource\supplemental;

require_once('SupplementalLinkParam.php');

/**
* Contains properties and methods specific supplemental data links for various sections of the website.
* 
* Supplemental links can be added to any level of the content hierarchy (column data, column headers, blocks, pages or sections).
* They are links to content that is designed to be deliver within another pages as an overlay or callout
* 
* @author: ctranel
* @date: May 9, 2014
*
*/

class SupplementalLink
{
	/**
	 * link id
	 * @var int
	 **/
	protected $id;

	/**
	 * link site_url
	 * @var string
	 **/
	protected $site_url;

	/**
	 * link href
	 * @var string
	 **/
	protected $href;

	/**
	 * link title
	 * @var string
	 **/
	protected $title;

	/**
	 * link rel
	 * @var string
	 **/
	protected $rel;

	/**
	 * link class
	 * @var string
	 **/
	protected $a_class;

	/**
	 * array of supplemental_link_param objects
	 * @var SupplementalLinkParam[]
	 **/
	protected $params;

	/**
	 * __construct
	 *
	 * @param: string href
	 * @param: string rel
	 * @param: string title
	 * @param: string class
	 * @param: SupplementalLinkParams[]
	 * @return void
	 * @author ctranel
	 **/
	public function __construct($site_url, $id, $href, $rel, $title, $class, $params = null){
        $this->id = $id;
		$this->site_url = $site_url;
		$this->href = $href;
		$this->rel = $rel;
		$this->title = $title;
		$this->a_class = $class;
		$this->params = $params;
	}
	
	/* -----------------------------------------------------------------
	 *  toArray

	 *  returns array representation of object

	 *  @author: ctranel
	 *  @date: 6/22/2016
	 *  @return: array
	 *  @throws:
	 * -----------------------------------------------------------------*/
	public function toArray(){
		$ret = [
            'site_url' => $this->site_url,
            'href' => $this->href,
            'rel' => $this->rel,
            'title' => $this->title,
            'a_class' => $this->a_class,
		];
		if(isset($this->params) && is_array($this->params) && !empty($this->params)){
			$params = [];
			foreach($this->params as $p){
				$params[] = $p->toArray();
			}
			$ret['params'] = $params;
			unset($params);
		}
		return $ret;
	}

	/* -----------------------------------------------------------------
	 *  returns full anchor tag text

	 *  returns full anchor tag text

	 *  @since: version
	 *  @author: ctranel
	 *  @date: Oct 28, 2014
	 *  @return: string
	 *  @throws: 
	 * -----------------------------------------------------------------*/
	 public function anchorTag() {
		$ret = '<a';
		$param_text = '';
		if(isset($this->href) && !empty($this->href)){
			$external = (strpos($this->href, $this->site_url) === false && strpos($this->href, 'http') !== false);
			if(isset($this->params)){
				foreach($this->params as $p){
					$param_text .= $p->urlText($external, $param_text === '');
				}
				if(strpos($this->href, 'http') === false){
					$ret .= ' href="' . $this->site_url . $this->href . $param_text . '"';
				}
				else{
					$ret .= ' href="' . $this->href . $param_text . '"';
				}
			}
		}
	 	if(isset($this->a_class) && !empty($this->a_class)){
			$ret .= ' class="' . $this->a_class . '"';
		}
		if(isset($this->rel) && !empty($this->rel)){
			$ret .= ' rel="' . $this->rel . '"';
		}
		if(isset($this->title) && !empty($this->title)){
			$ret .= ' title="' . $this->title . '"';
		}
		$ret .= '>';
		$ret .= (isset($this->title) && !empty($this->title)) ? $this->title : 'title';
		$ret .= '</a>';
		return $ret;
	 }

	/* -----------------------------------------------------------------
	 *  Factory function, takes a dataset and returns supplemental link objects

	 *  Factory function that takes a dataset array and returns object storage of 
	 *  supplemental link objects

	 *  @since: version
	 *  @author: ctranel
	 *  @date: Oct 28, 2014
	 *  @param: array of dataset
	 *  @return: array of Supplemental_link objects
	 *  @throws: 
	 * -----------------------------------------------------------------*/
	 public static function datasetToObjects($site_url, $dataset, \supplemental_model $supplemental_datasource) {
	 	$ret = [];
		if(isset($dataset) && is_array($dataset)){
			foreach($dataset as $r){
				$param_data = $supplemental_datasource->getLinkParams($r['id']);
				$params = SupplementalLinkParam::datasetToObjects($param_data);
				$ret[] = new SupplementalLink(
					$site_url,
					$r['id'],
					$r['a_href'],
					$r['a_rel'],
					$r['a_title'],
					$r['a_class'],
					$params
				);
			}
		}

		return $ret;
	}

	/* -----------------------------------------------------------------
	 *  Factory function, takes a dataset and returns supplemental link objects

	 *  Factory function that takes a dataset array and returns object storage of 
	 *  supplemental link objects

	 *  @author: ctranel
	 *  @date: Feb 17, 2015
	 *  @param: supplemental_model $datasource
	 *  @return: void
	 *  @throws: 
	 * -----------------------------------------------------------------*/
	 public function setParams(\supplemental_model $datasource) {
		$param_data = $datasource->getLinkParams($this->id);
		$this->params = SupplementalLinkParam::datasetToObjects($param_data);
	}
}
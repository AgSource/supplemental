<?php
namespace myagsource\Supplemental\Content;

require_once(APPPATH . 'libraries/Supplemental/Content/Supplemental.php');
require_once(APPPATH . 'libraries/Supplemental/Content/SupplementalLink.php');
require_once(APPPATH . 'libraries/Supplemental/Content/SupplementalComment.php');

use \myagsource\Supplemental\Content\Supplemental;
use \myagsource\Supplemental\Content\SupplementalLink;
use \myagsource\Supplemental\Content\SupplementalComment;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Supplemental acts as a factory for supplemental links and supplemental comments.
* 
* @author: ctranel
* @date: February 13, 2015
*
*/

class SupplementalFactory
{
	/**
	 * supplemental_datasource
	 * @var object
	 **/
	protected $datasource;

	/**
	 * site_url
	 * @var string
	 **/
	protected $site_url;

	/**
	 * __construct
	 *
	 * @param: array supplementalLink objects
	 * @param: array supplementalComment objects
	 * @return void
	 * @author ctranel
	 **/
	public function __construct(\supplemental_model $datasource, $site_url)
	{
		$this->datasource = $datasource;
		$this->site_url = $site_url;
	}
	
	/* -----------------------------------------------------------------
	 *  Factory for supplemental objects for pages

	 *  Factory for supplemental objects for pages

	 *  @since: version
	 *  @author: ctranel
	 *  @date: Oct 28, 2014
	 *  @param: int
	 *  @param: string site url
	 *  @return: Supplemental object
	 *  @throws: 
	 * -----------------------------------------------------------------*/
	public function getPageSupplemental($page_id) {
		$links = $this->datasource->getLinks(2, $page_id);
		$supplemental_links = SupplementalLink::datasetToObjects($this->site_url, $links, $this->datasource);
	
		$comments = $this->datasource->getComments(2, $page_id);
		$supplemental_comments = SupplementalComment::datasetToObjects($comments);
		$supp = new Supplemental($supplemental_links, $supplemental_comments);
		return $supp;
	}

	/* -----------------------------------------------------------------
	 *  Factory for supplemental objects for blocks
	
	*  Factory for supplemental objects for blocks
	
	*  @since: version
	*  @author: ctranel
	*  @date: Oct 28, 2014
	*  @param: int
	*  @param: string site url
	*  @return: Supplemental object
	*  @throws:
	* -----------------------------------------------------------------*/
	public function getBlockSupplemental($block_id) {
		$links = $this->datasource->getLinks(1, $block_id);
		$supplemental_links = SupplementalLink::datasetToObjects($this->site_url, $links, $this->datasource);
	
		$comments = $this->datasource->getComments(1, $block_id);
		$supplemental_comments = SupplementalComment::datasetToObjects($comments);

		$supp = new Supplemental($supplemental_links, $supplemental_comments);
		return $supp;
	}

	/* -----------------------------------------------------------------
	 *  getHeaderGrpSupplemental
	
	*  Factory for supplemental objects for table headers
	
	*  @since: version
	*  @author: ctranel
	*  @date: March 13, 12015
	*  @param: int field id
	*  @param: string href (anchor tag property)
	*  @param: string rel (anchor tag property)
	*  @param: string title (anchor tag property)
	*  @param: string class (anchor tag property)
	*  @param: string comment to be displayed
	*  @return: Supplemental object
	*  @throws:
	* -----------------------------------------------------------------*/
	public function getHeaderGrpSupplemental($header_grp_id) {
		if(!isset($header_grp_id)){
			return null;
		}

		$links = $this->datasource->getLinks(7, $header_grp_id);
		$supplemental_links = isset($links) ? SupplementalLink::datasetToObjects($this->site_url, $links, $this->datasource) : null;

		$comments = $this->datasource->getComments(7, $header_grp_id);
		$supplemental_comments = isset($comments) ? SupplementalComment::datasetToObjects($comments) : null;
		
		if(isset($supplemental_links) || isset($supplemental_comments)){
		    return new Supplemental($supplemental_links, $supplemental_comments);
        }
		return null;
	}

    /* -----------------------------------------------------------------
 *  Factory for supplemental objects for column headers

*  Factory for supplemental objects for column headers

*  @since: version
*  @author: ctranel
*  @param: int block id
*  @return: array of Supplemental objects
*  @throws:
* -----------------------------------------------------------------*/
    public function getColHeaderSupplementalByBlock($block_id) {
        $ret = [];

        $data = $this->datasource->getHeaderSuppByBlock($block_id);

        foreach($data AS $d) {
            $supplemental_links = [];
            $supplemental_comments = [];

            // Links
            $tmp = new SupplementalLink($this->site_url, $d['supp_id'], $d['a_href'], $d['a_rel'], $d['a_title'], $d['a_class']);
            $tmp->setParams($this->datasource);
            $supplemental_links[] = $tmp;

            //Create and return object
            $ret[$d['db_field_name']] = new Supplemental($supplemental_links, $supplemental_comments);
        }

        return $ret;
    }

/* -----------------------------------------------------------------
 *  Factory for supplemental objects for column data

*  Factory for supplemental objects for column data

*  @since: version
*  @author: ctranel
*  @param: int block id
*  @return: array of Supplemental objects
*  @throws:
* -----------------------------------------------------------------*/
    public function getColDataSupplementalByBlock($block_id) {
        $ret = [];

        $data = $this->datasource->getDataSuppByBlock($block_id);

        foreach($data AS $d) {
            $supplemental_links = [];
            $supplemental_comments = [];

            // Links
            $tmp = new SupplementalLink($this->site_url, $d['supp_id'], $d['a_href'], $d['a_rel'], $d['a_title'], $d['a_class']);
            $tmp->setParams($this->datasource);
            $supplemental_links[] = $tmp;

            //Create and return object
            $ret[$d['db_field_name']] = new Supplemental($supplemental_links, $supplemental_comments);
        }

        return $ret;
    }

    /* -----------------------------------------------------------------
     *  getControlSupplementalByForm

    *  Factory for supplemental objects for column data

    *  @since: version
    *  @author: ctranel
    *  @param: int form id
    *  @return: array of Supplemental objects
    *  @throws:
    * -----------------------------------------------------------------*/
    public function getControlSupplementalByForm($form_id) {
        $ret = [];

        $data = $this->datasource->getControlSuppByForm($form_id);
        foreach($data AS $d) {
            $supplemental_links = [];
            $supplemental_comments = [];

            // Links
            $tmp = new SupplementalLink($this->site_url, $d['supp_id'], $d['a_href'], $d['a_rel'], $d['a_title'], $d['a_class']);
            $tmp->setParams($this->datasource);
            $supplemental_links[] = $tmp;

            //Create and return object
            $ret[$d['db_field_name']] = new Supplemental($supplemental_links, $supplemental_comments);
        }

        return $ret;
    }

}
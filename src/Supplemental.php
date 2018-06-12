<?php
namespace agsource\supplemental;

require_once('../iSupplemental.php');
require_once('SupplementalLink.php');
require_once('SupplementalComment.php');

use \agsource\supplemental\SupplementalLink;
use \agsource\supplemental\SupplementalComment;
use \agsource\supplemental\iSupplemental;

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

class Supplemental implements iSupplemental
{
	/**
	 * supplemental link objects
	 * @var Array of SupplementalLink objects
	 **/
	protected $links;

	/**
	 * supplemental comment objects
	 * @var Array of Supplemental_comment objects
	 **/
	protected $comments;

	/**
	 * __construct
	 *
	 * @param: Array of supplementalLink objects
	 * @param: Array of supplementalComment objects
	 * @return void
	 * @author ctranel
	 **/
	public function __construct($links, $comments)
	{
		$this->links = $links;
		$this->comments = $comments;
	}

    public function toArray(){
        $ret = [];
       if(isset($this->links) && is_array($this->links) && !empty($this->links)){
            $links = [];
            foreach($this->links as $l){
                $links[] = $l->toArray();
            }
            $ret['links'] = $links;
            unset($links);
        }
        if(isset($this->comments) && is_array($this->comments) && !empty($this->comments)){
            $comments = [];
            foreach($this->comments as $c){
                $comments[] = $c->toArray();
            }
            $ret['comments'] = $comments;
            unset($comments);
        }
        return $ret;
    }


    /* -----------------------------------------------------------------
     * getContent

    *  Factory for supplemental objects for blocks

    *  @author: ctranel
    *  @date: Oct 28, 2014
    *  @return: Array of strings
    *  @throws:
    * -----------------------------------------------------------------*/

	public function getContent(){
		$arr_supplemental = [];
		if (isset($this->links) && is_object($this->links)){
			foreach($this->links as $s){
				$arr_supplemental['links'][] = $s->anchorTag();
			}
		}
		if (isset($this->comments) && is_object($this->comments)){
			foreach($this->comments as $s){
				$arr_supplemental['comments'][] = $s->comment();
			}
		}
		return $arr_supplemental;
	}
}
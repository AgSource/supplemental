<?php
namespace agsource\supplemental;

require_once('iSupplementalDatasource.php');

interface iSupplementalFactory
{
	/**
	 * __construct
	 *
	 * @param: iSupplementalDatasource
	 * @param: string site url
	 * @return void
	 **/
	function __construct(iSupplementalDatasource $datasource, $site_url);
	
	/* -----------------------------------------------------------------
	 *  Factory for supplemental objects for pages
	 *
	 *  @param: int
	 *  @return: agsource/supplemental/iSupplemental
	 * -----------------------------------------------------------------*/
	function getPageSupplemental($page_id);

	/* -----------------------------------------------------------------
	 *  Factory for supplemental objects for blocks
	 *
	*  @param: int block id
	*  @return: agsource/supplemental/iSupplemental
	* -----------------------------------------------------------------*/
	function getBlockSupplemental($block_id);

	/* -----------------------------------------------------------------
	 *  getHeaderGrpSupplemental
	 *
	*  @param: int header group id
	*  @return: agsource/supplemental/iSupplemental
	* -----------------------------------------------------------------*/
	function getHeaderGrpSupplemental($header_grp_id);

    /* -----------------------------------------------------------------
    *  Factory for supplemental objects for column headers
     *
    *  @param: int block id
    *  @return: array of agsource/supplemental/iSupplemental
    * -----------------------------------------------------------------*/
    function getColHeaderSupplementalByBlock($block_id);

    /* -----------------------------------------------------------------
    *  Factory for supplemental objects for column data
    *
    *  @param: int block id
    *  @return: array of agsource/supplemental/iSupplemental
    * -----------------------------------------------------------------*/
    function getColDataSupplementalByBlock($block_id);

    /* -----------------------------------------------------------------
     *  getControlSupplementalByForm
     *
    *  @param: int form id
    *  @return: array of Supplemental objects
    * -----------------------------------------------------------------*/
    function getControlSupplementalByForm($form_id);
}
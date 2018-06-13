<?php
namespace agsource\supplemental;

interface iSupplementalDatasource{
 	/* -----------------------------------------------------------------
	 *  getComments

	 *  Retrieves comments from database where this is not a corresponding link 
	 *  (i.e., show one or the other, and links have precendence)

	 *  @param: int content_type_id
	 *  @param: int content_id
	 *  @return: array of data or null
	 *  @throws: 
	 * -----------------------------------------------------------------*/
	function getComments($content_type_id, $content_id);
	
	/* -----------------------------------------------------------------
	 *  getLinks
	
	*  Retrieves comments from database based
	
	*  @param: int content_type_id
	*  @param: int content_id
	*  @return: array of data or null
	*  @throws:
	* -----------------------------------------------------------------*/
	function getLinks($content_type_id, $content_id);
	
	/* -----------------------------------------------------------------
	 *  getComment

	 *  Retrieves comment from database based

	 *  @param: int comment_id
	 *  @return: string comment text
	 *  @throws: 
	 * -----------------------------------------------------------------*/
	function getComment($comment_id);
 	
	/* -----------------------------------------------------------------
	 *  getLinkParams
	
	*  Retrieves comments from database based
	
	*  @param: int supplemental_link_id
	*  @return: array of data or null
	*  @throws:
	* -----------------------------------------------------------------*/
	function getLinkParams($supplemental_link_id);

     /* -----------------------------------------------------------------
      *  getDataSuppByBlock($block_id)

     *  Retrieves comments from database based

     *  @param: int block_id
     *  @return: array of data or null
     *  @throws:
     * -----------------------------------------------------------------*/
     function getDataSuppByBlock($block_id);

     /* -----------------------------------------------------------------
     *  getHeaderSuppByBlock($block_id)

    *  Retrieves comments from database based

    *  @param: int block_id
    *  @return: array of data or null
    *  @throws:
    * -----------------------------------------------------------------*/
     function getHeaderSuppByBlock($block_id);

     /* -----------------------------------------------------------------
     *  getControlSuppByForm($block_id)

    *  Retrieves comments from database based

    *  @param: int form_id
    *  @return: array of data or null
    *  @throws:
    * -----------------------------------------------------------------*/
     function getControlSuppByForm($form_id);
 }
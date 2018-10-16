<?php

if (!defined("AC_INCLUDE_PATH")) die("Error: AC_INCLUDE_PATH is not defined.");

include_once(AC_INCLUDE_PATH.'classes/HTMLByGuidelineRpt.class.php');
include_once(AC_INCLUDE_PATH.'classes/DAO/GuidelinesDAO.class.php');
include_once(AC_INCLUDE_PATH.'classes/DAO/UserLinksDAO.class.php');

class CSVWebServiceOutput {

	var $aValidator;                  // from parameter. instance of AccessibilityValidator
	var $userLinkID;                  // from parameter. user_links.user_link_id
	var $guidelineIDs;                // from parameter. array of guideline IDs

// XXX
	var $report;                     // instance of HTMLByGuidelineRpt. Generate error detail

	var $numOfErrors;                 // number of errors
	var $numOfLikelyProblems;         // number of likely problems
	var $numOfFailLikelyProblems;     // number of likely problems with fail decision or no decision
	var $numOfPotentialProblems;      // number of potential problems
	var $numOfFailPotentialProblems;  // number of potential problems with fail decision or no decision
	var $numOfNoDecision;             // number of problems with choice "no decision"

	var $guidelineStr;                // used to replace $html_main.{GUIDELINE}. Generated by setGuidelineStr()
	var $summaryStr;                  // used to replace $html_main.{SUMMARY}. Generated by setSummaryStr()
	var $mainStr;                     // main output. Generated by setMainStr()

	/**
	* Constructor
	* @access  public
	* @param   $aValidator : a instance of AccessibilityValidator. Call $aValidator->validate(); before pass in the instance
	*          $guidelineIDs: array of guideline IDs
	* @return  web service html output
	* @author  Cindy Qi Li
	*/
	function __construct($aValidator, $userLinkID, $guidelineIDs)
	{
		$this->aValidator = $aValidator;
		$this->guidelineIDs = $guidelineIDs;
		$this->userLinkID = $userLinkID;

// XXX. FIXME. why do we only use the first guideline ID?
		$this->report = new HTMLByGuidelineRpt($aValidator->getValidationErrorRpt(), $guidelineIDs[0], $userLinkID);

		$this->report->setUri($this->aValidator->getUri());

		$this->report->setAllowSetDecisions('true');
		$this->report->generateRpt();

	}

	/**
	* return main report
	* @access  public
	* @param   none
	* @return  return main report
	* @author  Cindy Qi Li
	*/
	public function getWebServiceOutput()
	{
		return $this->report->getCsvData($this->uri);
	}
}
?>

<?php

/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once ("DB.php");
require_once ("config.inc");
require_once ("classes/CSVBean.php");

/**
 * CSVファイルで出力
 */
class CSVAction
{

  var $bean;

  function CSVAction($bean)
  {
    $this->bean = $bean;
  }

  function execute()
  {

    global $cfg;

    ## Connect to DB
    $dbh = DB :: connect($cfg['dsn']);
    if (DB :: isError($dbh))
    {
      trigger_error("Cannot connect: " . DB :: errorMessage($dbh), E_USER_ERROR);
    }

    ## Get the lastest index number
    $query = 'SELECT r_address  FROM `record` WHERE r_noerror = 0 AND r_group_id=' . $this->bean->getGroupID();
    $result = $dbh->query($query);
    
    if (DB :: isError($result))
    {
      trigger_error($query . " : " . DB :: errorMessage($result), E_USER_ERROR);
    }

    ## Mail processor
    $return = '';
    while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
    {
      $return .= '"'.$row['r_address'].'"'."\n";
    }
    
    return $return;
    
  }
}

?>
<?Php
class inducks_tools
{
	public $db_coa;
	function __construct()
	{
		require 'config_db_coa.php';
		$this->db_coa = new PDO("mysql:host=$coa_db_host;dbname=$coa_db_name",$coa_db_user,$coa_db_pass);
		if($this->db_coa===false)
			trigger_error("Unable to open coa database",E_USER_ERROR);
	}
	function validate_code($code,$mode='issue') //Check if a story or issue code is valid
	{
		if($mode=='issue')
			$st_issuecode=$this->db_coa->prepare("SELECT issuecode FROM inducks_issue WHERE issuecode=?");
		elseif($mode=='publication')
			$st_issuecode=$this->db_coa->prepare("SELECT publicationcode FROM inducks_publication WHERE publicationcode=?");
		else
			trigger_error("Invalid mode: $mode",E_USER_ERROR);
		$st_issuecode->execute(array($code));
		if($st_issuecode->rowCount()>0)
			return true;
		else
			return false;
	}
	function stories($issue) //Get stories in an issue
	{
		$st_issue=$this->db_coa->prepare("SELECT * FROM coa.inducks_entry,coa.inducks_storyversion WHERE issuecode=? AND coa.inducks_entry.storyversioncode=coa.inducks_storyversion.storyversioncode AND (inducks_storyversion.kind='n' OR inducks_storyversion.kind='k') ORDER BY position;");
		$st_issue->execute(array($issue));
		if($st_issue->rowCount()==0)
		{
			trigger_error("Issue not found: {$issue}");
			return false;
		}
		return $st_issue->fetchAll(PDO::FETCH_ASSOC);
	}
	function stories_bbcode($issue)
	{
		$stories=$this->stories($issue);
		if($stories===false)
			return false;
		$bbcode='';
		foreach($stories as $story)
		{
			$bbcode.="[*][url=http://coa.inducks.org/story.php?c=".urlencode($story['storycode'])."]{$story['title']} ({$story['storycode']})[/url]\n";
		}
		return $bbcode;
	}
}

<script type="text/javascript">
jQuery(document).ready(function () {
			jQuery("#ct_accordion_1-menu").ctAccordion({
				defaultExpanded: ".expanded",
				event:"click",
				speed:"normal",
				easing:"linear",
				oneOpenAtTime:1,
			});
			});
</script>
	
<?php 
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
if(isset($_POST['submit_yr']))
{
$yrsmatc = $_POST['year_matchyrs'];
$yrtoget = "&ymdets=".$yrsmatc;
}
else
{
$yrtoget = "";
}
?>
<div align="right">
<form action="" method="POST">
Go to year:<input type="number" name="year_matchyrs" value="" required maxlength="4" size="4" />
<input type="submit" name="submit_yr" value="submit" />
</form></div>
<?php
global $wpdb;
$table = MBC_TABLE_PREFIX."mblogicricket";
$sql_stmt = "SELECT * from $table where id=1";
$sqlvals = $wpdb->get_results($sql_stmt);
$a = $sqlvals[0]->apikey;
$tables = $wpdb->prefix . "posts";
$sql_stmts = "SELECT * from $tables where `post_content` LIKE '%[mblogi_cricket_fullscore]%' AND post_status = 'publish'";
$sqlvalss = $wpdb->get_results($sql_stmts);
$as = $sqlvalss[0]->post_name;
$idedhak = $sqlvalss[0]->ID;
$sturl = get_permalink( $idedhak );
$chvar = 0;
$url = "http://cricketapi.mblogi.com/yearseriesjson.php?api=".$a.$yrtoget;
$json = file_get_contents($url);
$json = json_decode($json,true);
if($json['errormsg'])
{
echo $json['errormsg'];
}
else
{
echo "<ul id='ct_accordion_1-menu' class='skin-classic'>";
foreach($json as $json)
{
?>
<li  ><a href='#' >
<?php print $json[0]['series']."</a>"; ?>
<ul ><li <?php if($chvar == 0){ echo "class='expanded'" ;} ?>  ><table border="0" ><thead><th style="width:20%">Date</th><th style="width:40%">Match Details</th><th style="width:40%">Result</th></thead>
<?php
for($i=1;$i<count($json);$i++)
{ 
print "<tr><td>".$json[$i]['date']."</td><td>".$json[$i]['teamone']." vs ".$json[$i]['teamtwo']." (".$json[$i]['desc'].")</td><td><a href='".$sturl."?mid=".$json[$i]['mid']."' >".$json[$i]['result']."</a></td></tr>";
}
?>
</table>
</li>
</ul>
<?php $chvar = 1; ?>
</li>
<?php
}
echo "</ul>";
}
?>
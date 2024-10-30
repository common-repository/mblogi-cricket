<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
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
$url = "http://cricketapi.mblogi.com/currseriesjson.php?api=".$a;
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
<?php print "<li><a href='#'>".$json[0]['series']."</a><ul>";  ?>
<li <?php if($chvar == 0){ echo "class='current-menu-item'" ;} ?> ><table class="mbcthiy"><thead><th style="width:20%">Date</th><th style="width:40%">Match Details</th><th style="width:40%">Result</th></thead>
<?php
for($i=1;$i<count($json);$i++)
{ ?>
  		<tr> <?php
print "<td>".$json[$i]['date']."</td><td>";
if($json[$i]['teamone'] != null) { echo $json[$i]['teamone']." vs ".$json[$i]['teamtwo']." (".$json[$i]['desc'].")"; } else { echo $json[$i]['desc']; }
echo "</td><td>";
if($json[$i]['result'] != null){ echo  "<a href='".$sturl."?mid=".$json[$i]['mid']."' >".$json[$i]['result']."</a>"; } else { echo "To be played"; }
echo "</td></tr>";
}
?>
</table>
</li>
<?php $chvar = 1; ?>
</ul>
</li>
<?php
}
echo "</ul>";
}
?>
<script type="text/javascript">
		jQuery(document).ready(function () {
			jQuery("#ct_accordion_1-menu").ctAccordion({
				event:"click",
				speed:"normal",
				easing:"linear",
				oneOpenAtTime:1,
				defaultExpanded:'.current-menu-item'
			});});
	</script>
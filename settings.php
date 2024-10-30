<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
global $wpdb;
$table = MBC_TABLE_PREFIX."mblogicricket";
echo "<div class='wrap'>";
echo "<div id='icon-options-general' class='icon32'><br /></div><h2>MBlogi Cricket Settings</h2>";
if(isset($_POST['save']))
{
$mkey = $_POST['Mblogikey'];
$wpdb->query("UPDATE $table SET `apikey`='$mkey' WHERE `id`=1");
}
$str = "SELECT * FROM $table WHERE id=1";
	$res = $wpdb->get_results($str);
	$mblogikey = $res[0]->apikey;
echo "<form action='' method='post'>";
echo "<div width='50%'><table border='0' class='form-table'>";
echo "<tr valign='top'>";
echo "<td scope='row'>MBlogi cricket API Key</td><td><input name='Mblogikey' type='text' value='$mblogikey' class='regular-text' /></td>";
echo "</tr>";
echo "<tr><td></td><td>You must enter a valid MBlogi Cricket API key here. If you need an API key, you can <a href='http://cric.mblogi.com/mblogi-cricket-api/' target='_blank'>create one here</a> </td> </tr>";
echo "<tr>";
echo "<td>&nbsp;</td><td><input type='submit' name='save' value='save' /></td>";
echo "</tr>";
echo "</table> </div>";
echo "</form>";
echo "</div></div>";
?>
<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
global $wpdb;
$table = $wpdb->prefix . "mblogicricket";
$sql_stmt = "SELECT * from $table where id=1";
$sqlvals = $wpdb->get_results($sql_stmt);
$a = $sqlvals[0]->apikey;
$tables = $wpdb->prefix . "posts";
$sql_stmts = "SELECT * FROM $tables WHERE `post_content` LIKE '%[mblogi_cricket_fullscore]%' AND post_status = 'publish'";
$sqlvalss = $wpdb->get_results($sql_stmts);
$as = $sqlvalss[0]->post_name;
$idedhak = $sqlvalss[0]->ID;
$sturl = get_permalink( $idedhak );
$furl = "http://cricketapi.mblogi.com/sfsjson.php?api=".$a;
$fjson = file_get_contents($furl);
$fjson = json_decode($fjson,true);
$rurl = "http://cricketapi.mblogi.com/srsjson.php?api=".$a;
$rjson = file_get_contents($rurl);
$rjson = json_decode($rjson,true);
$chvar = 0;
$curl = "http://cricketapi.mblogi.com/sscjson.php?api=".$a;
$cjson = file_get_contents($curl);
$cjson = json_decode($cjson,true);
$myupdlincs = MBC_URL . '/sscupdate.php';
 ?>
<ul id="ct_accordion_1-menu1" class="skin-classic ctAccordion">
			<li class="open"><a href="#" class="head">Current</a>
			
<ul style="display: block;" class='current-menu-itemwidget'>
		 
		 <div id="latestscData">
		 <?php
		 $inn = $cjson;
  		 $sstfr = count($inn);
if($sstfr == 0)
{
echo "<li class='current-menu-itemwidget' >No live match in progress</li>";
}
else
{
		 
			 foreach($cjson as $mat)
{ 
 $xxt = count($mat);
$innings_tot = $xxt - 1;
$innings_tot;
 ?>
<li <?php if($chvar == 0){ echo "class='current-menu-itemwidget'" ;} ?>>
<div class="mbcmatch"><a href="<?php echo $sturl."?mid=".$mat[0]['mid']; ?>" ><?php echo $mat[0]['team1shortname']; ?> VS <?php echo $mat[0]['team2shortName']; ?></a></div>
<div> <?php 
if($innings_tot == 1)
{
print $mat[1]['batting'].": ".$mat[1]['runs']."/".$mat[1]['wickets']." in ".$mat[1]['overs']." Ov ";
}
if($innings_tot == 2)
{
print $mat[1]['batting'].": ".$mat[1]['runs']."/".$mat[1]['wickets']." in ".$mat[1]['overs']." Ov | ";
print $mat[2]['batting'].": ".$mat[2]['runs']."/".$mat[2]['wickets']." in ".$mat[2]['overs']." Ov";
}
if($innings_tot == 4)
{
if($mat[1]['batting'] == $mat[3]['batting'])
{
print $mat[1]['batting']." ".$mat[1]['runs']."/".$mat[1]['wickets']." & ";
print $mat[3]['runs']."/".$mat[3]['wickets']." | ";
}
elseif($mat[1]['batting'] == $mat[4]['batting'])
{
print $mat[1]['batting']." ".$mat[1]['runs']."/".$mat[1]['wickets']." & ";
print $mat[4]['runs']."/".$mat[4]['wickets']." | ";
}

if($mat[2]['batting'] == $mat[3]['batting'])
{
print $mat[2]['batting']." ".$mat[2]['runs']."/".$mat[2]['wickets']."  & ";
print $mat[3]['runs']."/".$mat[3]['wickets'];
}
elseif($mat[2]['batting'] == $mat[4]['batting'])
{
print $mat[2]['batting']." ".$mat[2]['runs']."/".$mat[2]['wickets']." &";
print $mat[4]['runs']."/".$mat[4]['wickets'];
}
}
if($innings_tot == 3)
{
if($mat[1]['batting'] == $mat[3]['batting'])
{
print $mat[1]['batting']." ".$mat[1]['runs']."/".$mat[1]['wickets']." & ";
print $mat[3]['runs']."/".$mat[3]['wickets']." | ";
}

if($mat[2]['batting'] == $mat[3]['batting'])
{
print $mat[2]['batting']." ".$mat[2]['runs']."/".$mat[2]['wickets']." & ";
print $mat[3]['runs']."/".$mat[3]['wickets'];
}
elseif($mat[2]['batting'] != $mat[3]['batting'])
{
print $mat[2]['batting']." ".$mat[2]['runs']."/".$mat[2]['wickets'];
}
}
?> </div>
<span><?php if($mat[0]['status'] != '' ) { echo $mat[0]['status']; } ?> </span>
</li>
<?php
$chvar = 1;
} 

}
?>
			
		</ul>
</li>
		<li class="closed"><a href="#">Recent</a>
			
		 <ul>
		 <?php foreach($rjson as $midr)
{  ?><li>
			<div class="mbcmatch"><a href="<?php echo $sturl."?mid=".$midr['mid']; ?>"><?php echo $midr['Team1']; ?> VS <?php echo $midr['Team2']; ?></a></div>
			<span><?php echo $midr['Seriesname']; ?> <br/><?php echo $midr['startdate']; ?>, <strong><?php print $midr['result']; ?></strong></span></li>
			<?php } ?>
		 </ul></li>
		 <li class="closed"><a href="#">Fixtures</a>
		<ul>
			<?php foreach($fjson as $midf)
{ ?><li>
			 <div class="mbcmatch"><a href="#"><?php echo $midf['Team1']; ?> VS <?php echo $midf['Team2']; ?></a></div>
			 <span><?php echo $midf['startdate']; ?>, <?php echo $midf['ISTtime']; ?> IST<br/> <?php echo $midf['Seriesname']; ?></span><li>
			<?php } ?>
		
		</li>
		</ul></li>
		</ul>
		
<script type="text/javascript">
		jQuery(document).ready(function () {
			jQuery("#ct_accordion_1-menu1").ctAccordion({
				event:"click",
				speed:"normal",
				easing:"linear",
				oneOpenAtTime:1,
				defaultExpanded:'.current-menu-itemwidget',
                                create: function(event, ui) { $("#ct_accordion_1-menu1").show(); }
			});});
	</script>
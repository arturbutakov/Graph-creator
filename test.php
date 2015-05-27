<?php
$way = $_POST["way"];
$fp = file_get_contents("test/".$way.".txt");
$arr = explode ("\n",$fp);

$channelname = $arr[11];
$channelname = substr($arr[11], 0, -1);
$channels = explode(";", $channelname);

$color = 0;

for ($j=0; $j < count($channels); $j++,$color++) { 
	
	$z = 0;
	
	$result .= '{label:'.'\''.$channels[$j].'\''.','.'color:'.$color.','.'data:[';
	
	for ($n=12; $n < count($arr); $n++,$z++) { 

		$str = explode(' ', $arr[$n]);

		$result .= '['.$z.','.$str[$j].'],';

	 	}
	 $result .= ']},';
	 
}

$new = fopen('text.txt','w');
fwrite($new, $result);
fclose($new);
header('Location:index.php')
?>	


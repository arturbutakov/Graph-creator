<?php

$way = "earthquake";
$fp = file_get_contents("test/".$way.".txt");
$arr = explode ("\n",$fp);

$number = $_POST["number"];
$number = explode(" ", $number);
for ($n=0; $n < count($number); $n++) {
	$number[$n] = $number[$n]-1;
}

$channelname = $arr[11];
$channelname = substr($arr[11], 0, -1);
$channels = explode(";", $channelname);

for ($n=0; $n < 11; $n++) {
	$output .= $arr[$n]."\n";
}

for ($n=0; $n < count($number); $n++) {
	$output .= $channels[$number[$n]].";";
}
$output .= "\n";

for ($t=12; $t < count($arr); $t++) {
	$string = explode(" ", $arr[$t]);
	for ($n=0; $n < count($number); $n++) {
		$output .= $string[$number[$n]]." ";
	}
	$output .= "\n";
}


//printf($output);

$file = 'output.txt';
file_put_contents($file, $output);
header('Location:index.php')
?>
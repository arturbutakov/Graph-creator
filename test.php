<?php
global $HTTP_POST_VARS;
function load($way) {
	$fp = file_get_contents("test/".$way);
	$arr = explode ("\n",$fp);

	$channelname = $arr[11];
	$channelname = substr($arr[11], 0, -1);
	$channels = explode(";", $channelname);

	$color = 0;

	for ($j=0; $j < count($channels); $j++,$color++) { 
		
		$z = 0;
		
		@$result .= '{label:'.'\''.$channels[$j].'\''.','.'color:'.$color.','.'data:[';
		
		for ($n=12; $n < count($arr); $n++,$z++) { 

			$str = explode(' ', $arr[$n]);

			@$result .= '['.$z.','.$str[$j].'],';

		 	}
		 $result .= ']},';
	}

$new = fopen('text.txt','w');
fwrite($new, $result);
fclose($new);
header('Location:index.php');
}

function loadfile() {
	$uploaddir = "test/";
	$way = $_FILES['userfile']['name'];
	setcookie("Way", $way);
	move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $_FILES['userfile']['name']);
	load($way);
	}

function save() {
	$way = $_COOKIE["Way"];
	$fp = file_get_contents("test/".$way);
	$arr = explode ("\n",$fp);

	$number = $_POST["number"];
	$begin = $_POST["begin"];
	$end = $_POST["end"];
	$number = explode(",", $number);
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

	for ($t=$begin+11; $t < ($end+12); $t++) {
		$string = explode(" ", $arr[$t]);
		for ($n=0; $n < count($number); $n++) {
			$output .= $string[$number[$n]]." ";
		}
		$output .= "\n";
	}

	//printf($output);

	$file = 'output.txt';
	file_put_contents($file, $output);
	// readfile('output.txt');
}

function newchannel() {
	$way = $_COOKIE["Way"];
	$fp = file_get_contents("test/".$way);
	$arr = explode ("\n",$fp);

	$number = $_POST["number"];

	$number = explode(",", $number);
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
	$output .= "NewChannel;";
	$output .= "\n";

	for ($t=12; $t < count($arr); $t++) {
		$string = explode(" ", $arr[$t]);
		for ($n=0; $n < count($number); $n++) {
			$output .= $string[$number[$n]]." ";
			$newchan = $newchan + $string[$number[$n]];
		}
		$output .= $newchan." ";
		$newchan = 0;
		$output .= "\n";
	}
	$file = 'output.txt';
	file_put_contents($file, $output);
	load('output.txt');
}

$type = $_GET['type'];
if ($type == 'loadfile') {
	loadfile();
}
if ($type == 'save') {
	save();
}
if ($type == 'newchannel') {
	newchannel();
}
// header('Location:index.php');
?>	


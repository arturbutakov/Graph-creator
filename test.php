<?php
function load($way) {
	$fp = file_get_contents("test/".$way);
	$arr = explode ("\n",$fp);

	$channelname = $arr[11];
	$channelname = substr($arr[11], 0, -1);
	$channels = explode(";", $channelname);
	$countchannels = count($channels);
	setcookie('countchannels', $countchannels);
	$color = 0;

	for ($j=0; $j < count($channels); $j++,$color++) { 
		setcookie($j, $channels[$j]);
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

function statistics() {
	$way = $_COOKIE["Way"];
	$fp = file_get_contents("test/".$way);
	$arr = explode ("\n",$fp);
	
	$number = explode(",", $number);
	for ($n=0; $n < count($number); $n++) {
		$number[$n] = $number[$n]-1;
	}

	$channelname = $arr[11];
	$channelname = substr($arr[11], 0, -1);
	$channels = explode(";", $channelname);

	for ($t=$begin+11; $t < ($end+12); $t++) {
		$string = explode(" ", $arr[$t]);
		for ($n=0; $n < count($number); $n++) {
			$summ[$n] += $string[$number[$n]];
		}
	}
	$file = 'output.txt';
	file_put_contents($file, $output);
}

function newchannel() {
	$way = $_COOKIE["Way"];
	$fp = file_get_contents("test/".$way);
	$arr = explode ("\n",$fp);

	$number = $_POST["number"];
	
	$countchannels = $_COOKIE["countchannels"];

	for ($i=0; $i < $countchannels; $i++) { 
		$koef[$i] = $_POST["koef$i"];
	}

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
		//$p=0;
		$string = explode(" ", $arr[$t]);
		for ($n=0; $n < count($number); $n++) {
			//while ($koef[$p] == '') {$p++;}

			$output .= $string[$number[$n]]." ";
			$newchan = $string[$number[$n]] + $newchan;
		}
		$output .= $newchan." ";
		$newchan = 0;
		$output .= "\n";
	}
	$file = 'test/output.txt';
	file_put_contents($file, $output);
	load('output.txt');
}

// function statistics() {
// 		$way = $_COOKIE["Way"];
// 		$fp = file_get_contents("test/".$way);
// 		$arr = explode ("\n",$fp);
// 		$content = 0;
// 		$channelname = $arr[11];
// 		$channelname = substr($arr[11], 0, -1);
// 		$channels = explode(";", $channelname);
// 		$summ = 0;
// 		print 'Статистики: <br><br>';
// 		for ($j=0; $j < count($channels); $j++) { 
// 			$content .= $channels[$j] . '<br/>';
// 			$summ = 0;
// 			for ($n=12; $n < count($arr); $n++) { 
// 				$str = explode(' ', $arr[$n]);
// 				print ($str[$n][$j]);
// 				// $summ += $arr[$n];
// 			 	}
// 			 // $middle = 'Среднее = ' . ($summ / count($arr));
// 			 // $content .= $middle . '<br>';
// 		}
// 			 // print($content);
// }


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
if ($type == 'statistics') {
	statistics();
}
// header('Location:index.php');
?>	


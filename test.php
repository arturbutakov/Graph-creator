<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: " . date("r"));

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

function newchannel() {
	$way = $_COOKIE["Way"];
	$countchannels = $_COOKIE["countchannels"]; // данные из куков

	$fp = file_get_contents("test/".$way);
	$arr = explode ("\n",$fp); // архив строк из файла

	$numberc = $_POST["numberc"]; //данные из формы
	for ($i=0; $i < $countchannels; $i++) {
		$koef[$i] = $_POST["koef$i"];
	}

	$numberc = explode(",", $numberc); // архив из номеров каналов
	for ($n=0; $n < count($numberc); $n++) {
		$numberc[$n] = $numberc[$n]-1; //уменьшение на единицу
	}

	$channelname = $arr[11];
	$channelname = substr($arr[11], 0, -1);
	$channels = explode(";", $channelname); //все имена каналов из файла

	for ($n=0; $n < 11; $n++) {
		$output .= $arr[$n]."\n"; //записываем первые 11 неизменных строк
	}

	for ($n=0; $n < count($numberc); $n++) { 
		$output .= $channels[$numberc[$n]].";";
	}
	$output .= "NewChannel;"; // создаем строку с именами каналов
	$output .= "\n";

	for ($t=12; $t < (count($arr)-1); $t++) {
		$p=0;
		$string = explode(" ", $arr[$t]); //string - архив чисед строки
		for ($n=0; $n < count($numberc); $n++) {
			while ($koef[$p] == '') {$p++;} //доходим до непустого инпута

			$output .= $string[$numberc[$n]]." ";
			$newchan = $string[$numberc[$n]] *$koef[$p]+ $newchan;
		}
		$output .= $newchan." ";
		$newchan = 0;
		$output .= "\n";
	}
	$file = 'test/output.txt';
	file_put_contents($file, $output);
	load('output.txt');
}


function statistics() {
	$way = $_COOKIE["Way"];
	$fp = file_get_contents("test/".$way);
	$arr = explode ("\n",$fp);
	$channels = explode(';', $arr['11']);
	$result = '';
	$countstr = count($arr)-12;

	for ($i=12; $i < $countstr; $i++) { 
			$arr[$i] = explode(' ', $arr[$i]);
	}
	/*Запускаем счетчик по каналам*/
	for ($i=0; $i < count($channels); $i++) {
		$summ = 0;
		$summdisp = 0;
		$summvar = 0;
		$summeks = 0;
		$min = 0;
		$max = 0;
		/*Суммируем все значения канала*/
		for ($j=12; $j < $countstr-1; $j++) { 
			$summ += $arr[$j][$i];
		}
		/*Делим сумму всех значений канала на количество значений*/
		$average = $summ / $countstr;

		/*Запускаем счетчик для вычисления дисперсии*/
		for ($j=12; $j < $countstr-1; $j++) { 
			$summdisp += pow($arr[$j][$i]-$average, 2);
		}
		/*Запускаем счетчик для вычисления коэффициента асимметрии*/
		for ($j=12; $j < $countstr-1; $j++) { 
			$summvar += pow($arr[$j][$i]-$average, 3);
		}
		/*Запускаем счетчик для вычисления коэффициента эксцесса*/
		for ($j=12; $j < $countstr-1; $j++) { 
			$summeks += pow($arr[$j][$i]-$average, 4);
		}
		/*Запускаем счетчик для вычисления максимального и минимального значения*/
		for ($j=12; $j < $countstr-1; $j++) { 
			$min = $arr[$j][$i];
		}
		/*Запускаем счетчик для вычисления максимального и минимального значения*/
		for ($j=12; $j < $countstr-1; $j++) { 
			if ($arr[$j][$i] > $max) {
				$max = $arr[$j][$i];
			}
			if ($arr[$j][$i] < $min) {
				$min = $arr[$j][$i];
			}
		}
		$disp = $summdisp / $countstr;
		$rms = sqrt($disp);
		$skewness = $rms / $average;
		$skvariation = $summvar / pow($rms, 3);
		$skveks = ($summeks / pow($rms, 4)) - 3;
		$result .= $channels[$i].'<br> Среднее  = '.$average.
		'<br> Дисперсия = '.$disp.
		'<br> Среднеквадратичное отклонение = '.$rms.
		'<br> Коэффициент вариации ='.$skewness.
		'<br> Коэффициент асимметрии = '.$skvariation.
		'<br> Коэффициент эксцесса = '.$skveks.
		'<br> Минимальное значение сигнала = '.$min.
		'<br> Максимальное значение сигнала = '.$max.
		'<br><br><br>';
	}
	echo $result."\n";
}

function modelSin() {
	$a = $_POST['a'];
	$w = $_POST['w'];
	$f = $_POST['f'];
	for ($i=0; $i < 11; $i++) { 
		$result .= "\n";
	}
	$result .= 'Sinn'."\n";

	for ($j=1; $j < 5; $j++) { 
		for ($i=-M_PI; $i < M_PI; $i += 0.01) { 
			$result .= $a*sin(($i*$w)+$f);
			$result .= "\n";
		}
	}
	$file = 'test/model.txt';
	file_put_contents($file, $result);
	load('model.txt');

}
function modelCos() {
	$a = $_POST['a'];
	$w = $_POST['w'];
	$f = $_POST['f'];
	for ($i=0; $i < 11; $i++) { 
		$result .= "\n";
	}
	$result .= 'Coss'."\n";

	for ($j=1; $j < 5; $j++) { 
		for ($i=-M_PI; $i < M_PI; $i += 0.01) { 
			$result .= $a*cos(($i*$w)+$f);
			$result .= "\n";
		}
	}
	$file = 'test/model.txt';
	file_put_contents($file, $result);
	load('model.txt');
}
function modelCosExp() {
	$a = $_POST['a'];
	$t = $_POST['t'];
	$f = $_POST['f'];
	for ($i=0; $i < 11; $i++) { 
		$result .= "\n";
	}
	$result .= 'CosExpp'."\n";

	for ($j=1; $j < 2; $j++) { 
		for ($i=-M_PI; $i < M_PI; $i += 0.003) { 
			$result .= $a*exp((0-$i)/$t)*cos(2*M_PI*$i*$t);
			$result .= "\n";
		}
	}
	$file = 'test/model.txt';
	file_put_contents($file, $result);
	load('model.txt');
}
function whitenoise() {
	$min = $_POST['min'];
	$max = $_POST['max'];
	for ($i=0; $i < 11; $i++) { 
		$result .= "\n";
	}
	$result .= 'white noisee'."\n";
	
	for ($j=0; $j < 2000; $j++) { 
		$result .= rand($min,$max);
		$result .= "\n";
	}
	
		$file = 'test/model.txt';
		file_put_contents($file, $result);
		load('model.txt');
}
function whitenoisedisp() {
	$a = $_POST['a'];
	$d = $_POST['d'];
	for ($i=0; $i < 11; $i++) { 
		$result .= "\n";
	}
	$result .= 'white noisee'."\n";
	
	for ($j=0; $j < 1200; $j++) { 
		$sum = 0;
		for ($i=0; $i < 12; $i++) { 
			$sum += rand(0,1);
		}
		$sum -= 6;
		$result .= $a + $d*$sum;
		$result .= "\n";
	}
	
		$file = 'test/model.txt';
		file_put_contents($file, $result);
		load('model.txt');
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
if ($type == 'statistics') {
	statistics();
}
if ($type == 'modelsin') {
	modelsin();
}
if ($type == 'modelcos') {
	modelcos();
}
if ($type == 'modelcosexp') {
	modelCosExp();
}
if ($type == 'whitenoise') {
	whitenoise();
}
if ($type == 'whitenoisedisp') {
	whitenoisedisp();
}
// header('Location:index.php');
?>	
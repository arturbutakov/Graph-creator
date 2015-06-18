<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: " . date("r"));
function input() {
	$countchannels = $_COOKIE["countchannels"];
	for ($i=0; $i < $countchannels; $i++) { 
		@print "<input placeholder='введите коэфицент' size='20' type='text' name='koef$i'/> $_COOKIE[$i]<br/>";
	}
}
?>

<!DOCTYPE html>
<html lang="ru">
   <head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <title>Графики</title>
	  <!-- Bootstrap -->
	  <link href="css/bootstrap.css" rel="stylesheet">
	  <link href="css/style.css" rel="stylesheet">
	  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	  <!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.pond/xs.42/respond.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.pond/xs.42/respond.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.pond/xs.42/respond.min.js"></script>
	  <![endif]-->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	  <script src="js/bootstrap.js"></script>
	  <script language="javascript" type="text/javascript" src="js/file.js"></script>
	  <script language="javascript" type="text/javascript" src="flot/jquery.js"></script>
	  <script language="javascript" type="text/javascript" src="flot/jquery.flot.js"></script>
	  <script language="javascript" type="text/javascript" src="flot/jquery.flot.stack.js"></script>
	  <script language="javascript" type="text/javascript" src="flot/jquery.flot.selection.js"></script>
   </head>
   <body>
   	<div class="row">
   	  <div class="col-xs-4 col-md-3"></div>
   	  <div class="col-xs-6 col-md-6">
   	  	   	<!-- Адаптивная навигация по сайту -->
   	  	   	
   	  			<div class="navbar navbar-default">
   	  			 <div class="container">
   	  				<div class="navbar-header">
   	  				   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#responsive-menu">
   	  				   <span class="sr-only"></span>
   	  				   <span class="icon-bar"></span>
   	  				   <span class="icon-bar"></span>
   	  				   <span class="icon-bar"></span>
   	  				   </button>
   	  				   <a href="#" class="navbar-brand"><img src="logo.png"></a>
   	  				</div>
   	  				<div class="collapse navbar-collapse" id="responsive-menu">
   	  				   <ul class="nav navbar-nav">
   	  					  <li class="dropdown">
   	  						 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Файл<b class="caret"></b></a>
   	  						 <ul class="dropdown-menu">
   	  							<li><a href="#">Создать</a></li> 
   	  							<li><a href="#">Открыть</a></li>
   	  							<li class="divider"></li>
   	  							<li><a href="#">Сохранить как</a></li>
   	  						 </ul>
   	  					  </li>
   	  					  <li class="dropdown">
   	  						 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Инструменты<b class="caret"></b></a>
   	  						 <ul class="dropdown-menu">
   	  							<li><a href="#">Информация о сигнале</a></li> 
   	  						 </ul>
   	  					  </li>
   	  					  <li class="dropdown">
   	  						 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Справка<b class="caret"></b></a>
   	  						 <ul class="dropdown-menu">
   	  							<li><a href="#">О программе</a></li> 
   	  							<li><a href="#">Разработчики</a></li> 
   	  						 </ul>
   	  					  </li>
   	  				   </ul>
   	  				</div>
   	  			 </div>
   	  			</div>
            
            <!-- Форма для загрузки файла -->
            <b>Нарисовать файл</b>
                <form enctype="multipart/form-data" action="test.php?type=loadfile" method="POST">
                    <div class="form-group">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000000000000">
                    <!-- Название элемента input определяет имя в массиве $_FILES -->
                    <input name="userfile" type="file" /><br/>
                    <input type="submit" value="Вывести" />
                    </div>
                </form>
			<hr/>
   	  		<div>
   	  			<b>Сохранение файла</b>
   	  			<form enctype="multipart/form-data" method="POST" action="test.php?type=save">
   	  		   	      <div class="form-group">
   	  		   	      	<input placeholder="Введите номера каналов через запятую" type="text" name="number" size="40"/>
   	  		   	      	от <input placeholder="Начало" size="4" type="text" name="begin"/>
   	  		   	      	до <input placeholder="Конец" size="4" type="text" name="end"/>
   	  				  <input type="submit" value="Сохранить"/></form>
   	  				  <a href="test/output.txt">Показать</a>
   	  		   	      </div>
   	  		   	</form>
   	  		   		
   	  		</div>
   	  		<hr/>
   	  		<b>Генерировать синус</b>
   	  		   	<form enctype="multipart/form-data" method="POST" action="test.php?type=modelsin">
   	  		   	      <div class="form-group">
   	  		   	      	<br/>
   	  		   	      	амплитуда <input name="a" type="text" size="3">
   	  		   	      	круговая частота <input name="w" type="text" size="3">
   	  		   	      	начальная фаза <input name="f" type="text" size="3">
   	  				  <input type="submit" value="Генерировать"/></form>
   	  				  <a href="test/model.txt">Показать</a>
   	  		   	      </div>
   	  		   	</form>	
   	  		<hr/>
   	  		<b>Генерировать косинус</b>
   	  		   	<form enctype="multipart/form-data" method="POST" action="test.php?type=modelcos">
   	  		   	      <div class="form-group">
   	  		   	      	<br/>
   	  		   	      	амплитуда <input name="a" type="text" size="3">
   	  		   	      	круговая частота <input name="w" type="text" size="3">
   	  		   	      	начальная фаза <input name="f" type="text" size="3">
   	  				  <input type="submit" value="Генерировать"/></form>
   	  				  <a href="model.txt">Показать</a>
   	  		   	      </div>
   	  		   	</form>	
   	  		<hr/>
   	  		<b>Генерировать сигнал с экспоненциальной огибающей</b>
   	  		   	<form enctype="multipart/form-data" method="POST" action="test.php?type=modelcosexp">
   	  		   	      <div class="form-group">
   	  		   	      	<br/>
   	  		   	      	амплитуда <input name="a" type="text" size="3">
   	  		   	      	ширина огибающей <input name="t" type="text" size="3">
   	  		   	      	частота несущей <input name="f" type="text" size="3">
   	  				  <input type="submit" value="Генерировать"/></form>
   	  				  <a href="model.txt">Показать</a>
   	  		   	      </div>
   	  		   	</form>	
   	  		   	<hr/>
   	  		   	<b>Генерировать белый шум</b>
   	  		   	<form enctype="multipart/form-data" method="POST" action="test.php?type=whitenoise">
   	  		   	      <div class="form-group">
   	  		   	      	<br/>
   	  		   	      	min <input name="min" type="text" size="5">
   	  		   	      	max <input name="max" type="text" size="5">
   	  				  <input type="submit" value="Генерировать"/>
   	  				</form>
   	  				  <a href="sin.txt">Показать</a>
   	  		   	      </div>
   	  		   	</form>
   	  		   	<hr/>
   	  		   		<b>Генерировать белый шум с дисперсией</b>
   	  		   	<form enctype="multipart/form-data" method="POST" action="test.php?type=whitenoisedisp">
   	  		   	      <div class="form-group">
   	  		   	      	<br/>
   	  		   	      	среднее <input name="a" type="text" size="5">
   	  		   	      	дисперсия <input name="d" type="text" size="5">
   	  				  <input type="submit" value="Генерировать"/>
   	  				</form>
   	  				  <a href="sin.txt">Показать</a>
   	  		   	      </div>
   	  		   	</form>
   	  		   	<hr/>
   	  		<!-- График -->
   	  		<div class="container">
   	  			<div class="row">
   	  				<p><noscript><strong style="color: red;">Для отображения данных необходимо включить JavaScript!</strong></noscript></p>
   	  				<div id="placeholder" style="width:600px;height:300px;float:left;"></div>
   	  				<div style="float:left;">
   	  		  		<div id="legend"></div>
   	  				</div>
   	  				<div style="clear: both;"></div>
   	  				<div id="overview" style="margin-top:20px;width:600px;height:50px"></div>
   	  		 	</div>
   	  		</div>

   	  </div>
   	  <div class="col-xs-4 col-md-3"></div>
   	</div>

	<!-- Скрипт отрисовки графика -->
	  <script language="javascript" type="text/javascript">
	  	
	  	// alert(str); 
	  	// выделенная область
	  	var selection = ["0", "2000"];
	  	// все данные
	  	// цвета задавать обязательно, иначе они будут все время меняться при удалении/добавлении рядов
	  	var all_data = [
	  	<?php
	  	include 'text.txt';
	  	?>
	  	];
	  	// какие данные скрываем - заполняем позже
	  	var hide = [];
	  	// преобразуем даты в формат, понятный Flot'у
	  	for(var j = 0; j < all_data.length; ++j) {
	  	  hide.push(false); // не скрываем j-ый ряд. пока что.
	  	  for(var i = 0; i < all_data[j].data.length; ++i)
	  	    all_data[j].data[i][0] = Date.parse(all_data[j].data[i][0]);
	  	}
	  	for(var i = 0; i < selection.length; ++i)
	  	  selection[i] = Date.parse(selection[i]);

	  	var overview; // "обзор" всех данных внизу страницы
	  	var plot; // график крупным планом
	  	var show_bars = false; // показывать столбики или линии
	  	var plot_conf = {
	  	  series: {
	  	    stack: null,
	  	    lines: { 
	  	      show: true,
	  	      lineWidth: 0.5
	  	    }
	  	  },
	  	  xaxis: {
	  	    mode: "time",
	  	    timeformat: "%y",
	  	    min: selection[0],
	  	    max: selection[1]
	  	  },
	  	  legend: {
	  	    container: $("#legend")
	  	  }
	  	};

	  	var overview_conf = {
	  	  series: {
	  	    lines: { 
	  	      show: true,
	  	      lineWidth: 0
	  	    },
	  	    shadowSize: 0
	  	  },
	  	  xaxis: {
	  	    ticks: []
	  	  },
	  	  yaxis: {
	  	    ticks: []
	  	  },
	  	  selection: {
	  	    mode: "x"
	  	  }, 
	  	  legend: {
	  	    show: false
	  	  }
	  	};
	  	 
	  	// перерисовываем все и вся :)
	  	function redraw() {
	  	  var data = [];
	  	  for(var j = 0; j < all_data.length; ++j)
	  	    if(!hide[j])
	  	      data.push(all_data[j]);

	  	  plot = $.plot($("#placeholder"), data, plot_conf);
	  	  overview = $.plot($("#overview"), data, overview_conf);

	  	  // легенду рисуем только один раз
	  	  plot_conf.legend.show = false;

	  	  // последний аргумент - чтобы избежать рекурсии
	  	  overview.setSelection({ x1: selection[0], x2: selection[1] }, true);
	  	}

	  	// вычисляем ширину колонки в соответствии с новой областью выделения
	  	function calc_bar_width() {
	  	  // поскольку по оси OX откладывается время,
	  	  // ширина столбцов в гистограмме вычисляется в 1/1000-ых секунды
	  	  // при масштабировании эту величину следует пересчитать
	  	  var r = plot_conf.xaxis;
	  	  // вычисляем, сколько столбцов попало в интервал
	  	  var bars_count = 0;
	  	  for(var i = 0; i < all_data[0].data.length; ++i)
	  	    if(all_data[0].data[i][0] >= r.min &&
	  	       all_data[0].data[i][0] <= r.max)
	  	       bars_count++;

	  	  // изменяем ширину столбцов
	  	  var new_conf = {
	  	    series: {
	  	      bars: { // умножаем на два, чтобы оставалось место между столбцами
	  	        barWidth: (r.max - r.min)/((bars_count + 1 /* на ноль не делим */) * 2) 
	  	      }
	  	    }
	  	  };
	  	  $.extend(true, plot_conf, new_conf);
	  	}

	  	// вычисляем ширину столбцов в гистограмме
	  	calc_bar_width();
	  	// рисуем графики в первый раз
	  	redraw();

	  	// событие - новое выделение на overview    
	  	$("#overview").bind("plotselected", function (event, ranges) {
	  	  var r = ranges.xaxis;
	  	  // сохраняем координаты выделенной области
	  	  selection = [r.from, r.to];

	  	  // перемещаем обзор в новую область
	  	  var new_conf = {
	  	    xaxis: {
	  	      min: r.from,
	  	      max: r.to
	  	    }
	  	  };
	  	  $.extend(true, plot_conf, new_conf);
	  	 
	  	  calc_bar_width();
	  	  redraw();
	  	});

	  	// рисуем чекбоксы в легенде
	  	var legend = document.getElementById('legend'); // еще IE не умеет заменять innerHTML в table
	  	var legend_tbl = legend.getElementsByTagName('table')[0];
	  	var legend_html = '<table style="font-size: smaller; color: rgb(84, 84, 84);"><tbody>';
	  	for(var i = 0; i < legend_tbl.rows.length; i++) {
	  	  legend_html += '<tr>' +
	  	    '<td><input type="checkbox" onclick="hide['+ i +']=!hide['+ i +'];redraw();" checked="1"></td>'
	  	    + legend_tbl.rows[i].innerHTML
	  	    + '</tr>';
	  	}
	  	legend_html += "</tbody></table>";
	  	legend.innerHTML = legend_html;
	  </script>
	  <br/>
	  <div class="row">
   	  <div class="col-xs-4 col-md-3"></div>
   	  <div class="col-xs-6 col-md-6">
   	  	<hr/>
   	  	<b>Записать суперпозицию</b><br><br>
   	  			<form enctype="multipart/form-data" method="POST" action="test.php?type=newchannel">
   	  		   	      <div class="form-group">
   	  		   	      	<input placeholder="Введите номера каналов через запятую" type="text" name="numberc" size="40"/>
   	  		   	      	<br/>
   	  		   	      	<? input(); ?>
   	  				  <input type="submit" value="Записать"/></form>
   	  				  <a href="test/output.txt">Показать</a>
   	  		   	      </div>
   	  		   	</form>
   	  		   	<hr/>
   	  		   		<form enctype="multipart/form-data" method="POST" action="test.php?type=statistics">
   	  		   	   	      <div class="form-group">
   	  		   			  <input type="submit" value="Показать статистики данного файла"/></form>
   	  		   	   	      </div>
   	  		   	   	</form>
   	  		   	
   	  </div>
   	  </div>
   	  <br>
   	  <br>
   	  <br>
   	  <br>
   	  <br>

   </body>
</html>
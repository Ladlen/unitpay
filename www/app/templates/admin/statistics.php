	<ul class="breadcrumb">
		<li><a href="/admin/">Главная</a> <span class="divider">/</span></li>
		<li class="active">Статистика</li>
	</ul>
	<?
		# Access Denied
		if($_SESSION['admPrivilege']['statistics'] == false){
			echo '<div class="alert alert-danger">У <b>Вас</b> отсутствуют права для данного раздела.</div>';
		} else {
	?>
	<? 
		# Статистика за текущий месяц
		$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' AND `time` > '".(time() - (Date("d") * 86400))."'");
		while($row = mysqli_fetch_array($SQL)){
			$day = intval(Date("d", $row['time']));
			$arr[$day] = @($arr[$day] != "" ? $arr[$day]+$row['price'] : $row['price']);
		}
		/* Статистика за сегодняшний день */
		$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `status` = '1' AND `time` > '".(time() - (Date("H") * 3600))."'");
		while($row = mysqli_fetch_array($SQL)){
			$hour = intval(Date("H", $row['time']));
			$arr1[$hour] = @($arr1[$hour] != "" ? $arr1[$hour]+$row['price'] : $row['price']);
		}
		/* Статистика за неделю */
		$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `status` = '1' AND `time` > '".(time() - (6 * 86400))."'");
		while($row = mysqli_fetch_array($SQL)){
			$day = intval(Date("d", $row['time']));
			$arr2[$day] = @($arr2[$day] != "" ? $arr2[$day]+$row['price'] : $row['price']);
		}
		/* Статистика за прошлую неделю */
		$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `status` = '1' AND `time` > '".(time() - (14 * 86400))."'");
		while($row = mysqli_fetch_array($SQL)){
			$day = intval(Date("d", $row['time']));
			$arr3[$day] = @($arr3[$day] != "" ? $arr3[$day]+$row['price'] : $row['price']);
		}
	?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);
		
		function drawChart(){
			var data = google.visualization.arrayToDataTable([
				['Day', 'Ваши продажи'],
				<? for($i = 1; $i < (Date("d") + 1); $i++){ ?>
				<? if(isset($arr[$i])){ ?>
				['<?=$i;?>',  <?=intval($arr[$i]);?>],
				<? } ?>
				<? } ?>
			]);

			var options = {
				vAxis: {minValue: 0}
			};

			var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
		
		google.charts.setOnLoadCallback(drawChart1);
		
		function drawChart1(){
			var data = google.visualization.arrayToDataTable([
				['Day', 'Ваши продажи'],
				<? for($i = 0; $i < Date("H") + 1; $i++){ ?>
				<? if(isset($arr1[$i])){ ?>
				['<?=($i < 10 ? "0".$i : $i);?>:00', <?=number_format($arr1[$i], 2, '.', '');?>],
				<? } ?>
				<? } ?>
			]);

			var options = {
				vAxis: {minValue: 0}
			};

			var chart = new google.visualization.AreaChart(document.getElementById('chart_div1'));
			chart.draw(data, options);
		}
		
		google.charts.setOnLoadCallback(drawChart2);
		
		function drawChart2(){
			var data = google.visualization.arrayToDataTable([
				['Day', 'Ваши продажи'],
				<? foreach($arr2 as $day => $sum){ ?>
				['<?=$day;?>',  <?=intval($sum);?>],
				<? } ?>				
			]);

			var options = {
				vAxis: {minValue: 0}
			};

			var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
			chart.draw(data, options);
		}
		
		google.charts.setOnLoadCallback(drawChart3);
		
		function drawChart3(){
			var data = google.visualization.arrayToDataTable([
				['Day', 'Ваши продажи'],
				<? $i = 1; ?>
				<? foreach($arr3 as $day => $sum){ ?>
				<? if($i < 8){ ?>
				['<?=$day;?>',  <?=intval($sum);?>],
				<? $i++; ?>
				<? } ?>
				<? } ?>
			]);

			var options = {
				vAxis: {minValue: 0}
			};

			var chart = new google.visualization.AreaChart(document.getElementById('chart_div3'));
			chart.draw(data, options);
		}
	</script>
	<center>
		<center><h5>Продажи в этом месяце</h5></center>
		<div id="chart_div" style="width: 900px; height: 500px;"></div>
		<center><h5>Продажи за сегодняшний день</h5></center>
		<div id="chart_div1" style="width: 900px; height: 500px;"></div>
		<center><h5>Продажи за текущую неделю</h5></center>
		<div id="chart_div2" style="width: 900px; height: 500px;"></div>
		<center><h5>Продажи за прошлую неделю</h5></center>
		<div id="chart_div3" style="width: 900px; height: 500px;"></div>
	</center>
	<?
		}
	?>
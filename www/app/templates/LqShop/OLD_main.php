<style>
.modgl {
    border-bottom: 1px dotted #0077AA;
    cursor: help;
}

.modgl::after {
background: rgba(0, 0, 0, 0.8);
border-radius: 8px 8px 8px 8px;
box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.5);
color: #FFF;
opacity: 0;
padding: 3px 7px;
position: absolute;
visibility: hidden;
transition: all 0.4s ease-in-out;
}
        
.modgl:hover::after {
    opacity: 1; /* Показываем его */
    visibility: visible;
}
.btnbuy {
	margin-top: -42px;
margin-left: 367px;
}
.iconurl {
	max-width:333px;
	max-height:inherit;
	margin-right:3px;
}
.paytable{
	width:100%;
	/*color:*/
	}


.footcopy {
	display:block;
	text-align:center;
	font-size:11px;
}
.foot {
	margin-top:20px;
}
#easyTooltip{
	padding:5px 10px;
	background:#195fa4 url(bg.gif) repeat-x;
	color:#fff;
	background: rgba(0, 0, 0, 0.8);
	border-radius: 8px 8px 8px 8px;
}
</style>
<?
	# Сортировка по категориям
	if(Defined('CID')){
		$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
	# Обычный вывод без сортировки
	} else {
		$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `main` = '1' ORDER BY item_id ASC");

	}
?>
<? if(mysqli_num_rows($SQL) > 0){ ?>
<? while($row = mysqli_fetch_array($SQL)){ ?>
<script type="text/javascript">
	// var getedId = 0;
	// var numOfItems = 0;
	// var setepaidway = 0;

	// function Basket(getedId) {
	//     numOfItems = document.getElementById('number-of-items-' + getedId).value;
	//     document.getElementById('end-number').value = numOfItems;
	//     document.getElementById('item-selected').value = getedId;
	// }

	// function setpaidway(setepaidway) {
	//     document.getElementById('fundsSelect').value = setepaidway;
	// }

	// function setEmail() {
	//     document.getElementById('row-box-email').value = document.getElementById('alert-box-email').value;
	//     sendData();
	// }
</script>
<!--<div class="modal fade" id="myModal_<?=$row['item_id'];?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?=$row['item'];?></h4>
            </div>
            <div class="modal-body">
            	<p><?=$row['body'];?></p>
            </div>        
		</div>
	</div>
</div>-->
	<? } ?>
	<? } ?>
	<? include('payModal.php'); ?>
	<?
		# Сортировка по категориям
		if(Defined('CID')){
			$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
		# Обычный вывод без сортировки
		} else {
			$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ".(Defined('SEARCH') ? "AND `item` LIKE '%".mysqli_real_escape_string($this->connectMainBD, SEARCH)."%'" : "AND `main` = '1'")." ORDER BY item_id ASC");
		}
	?>
	<? if(mysqli_num_rows($SQL) > 0){  
	?>
	<style>
	body {
    background-image: url(<?=BACKGROUND;?>);
}
</style>
<div class="layer">
<div id='qqq'>
	<table class="table table-bordered">
		<thead>
			<th>Наименование продукта</th>
			<th>шт. в наличии</th>
			<th>Цена</th>
			<th style="border-right-color: rgba(0, 0, 0, 0);">Купить</th>
		</thead>
		<tbody>
			<? while($row = mysqli_fetch_array($SQL)){ 	?>
			<? $price = json_decode($row['price'], true); ?>
			<tr title="<div><?= strip_tags($row['body'])?></div>">
				<!--<td class="modgl">-->
				<td class="modgl" data-modgl="<div><?= strip_tags($row['body'])?></div>">
				<img class="iconurl" src="<?=$row['image'];?>" /><?=$row['item'];?></td>
				<td data-id="<?=($row['count'] != NULL ? $row['count'] : '');?>"><?=($row['type'] == 'file' ? 'Файл' : $row['count']);?></td>
				<td class="rubprice"><?=$price['WMR'];?> WMR за 1 шт.</td>
				<td class="dlrprice" style="display:none"><?=$price['WMZ'];?> WMZ за 1 шт.</td>
				<td style="border-right-color: rgba(0, 0, 0, 0);"> <img class="iconbasket" src="./images/basket.png" width="22px" height="22px" data-toggle="modal" data-target="#setpaidway" style="display: inline;float: right;margin-left:0px; cursor:pointer" onclick="Basket(<?=$row['item_id'];?>)">
					<input type="text" class="form-control input-micro" id="number-of-items-<?=$row['item_id'];?>" style="width: 20px;margin-left: 0px;height: 18px;display: inline;padding: 0;float: right;" value="1">
				</td>
			</tr>
			<? } ?>
		</tbody>
	</table>
</div>
</div>

<form class="form-inline">
    <label class="control-label" for="count"></label>
    <input type="text" placeholder="Кол-во" class="form-control input-small" name="count" id="end-number" style2="width: 49px;margin-left: -15px;">
    <label class="control-label" for="item"></label>
    <select class="form-control input-small" name="item" id="item-selected" style2="width: 124px;margin-left: -30px;">
	    <?
			# Сортировка по категориям
			if(Defined('CID')){
				$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
			# Обычный вывод без сортировки
			} else {
				$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `main` = '1' ORDER BY item_id ASC");
			}
		?>
		<? if(mysqli_num_rows($SQL) > 0){ ?>
		<? while($row = mysqli_fetch_array($SQL)){ ?>
		<option value="<?=$row['item_id'];?>" data-id="<?=$row['item_id'];?>" data-min_order="<?=$row['min'];?>"><?=$row['item'];?></option>
		<? } ?>
		<? } ?>
	</select>
	<label class="control-label" for="funds"></label>
	<label class="control-label" for="funds"></label>
    <select class="form-control input-small" id="fundsSelect" name="funds">
		<? $wallets = json_decode(WALLETS, true); ?>
		<? foreach($wallets as $name => $wallet){ ?>
		<? if($wallet != false){ ?>
		<option value="<?=$name;?>" data-fund="<?=$name;?>"><?=($name == "YAD" ? "Яндекс.Деньги" : $name);?></option>
		<? } ?>
        <? } ?>
    </select>
    <input type="email" placeholder="E-mail" class="form-control input-small" id="row-box-email" name="email">
    <button id="sendButton" type="button" class="btn btn-primary" aria-hidden="true" style="">Оплатить</button>
    <button type='button' class='btn btn-primary' aria-hidden='true' data-toggle='modal' data-target='#kupon' styl3e='margin-bottom: 10px;width: 86px;padding-left: 1px;font-size: 14px;margin-left: 356px;font-weight: 100;'>Ввод купона</button>
</form>
<br>
    <? } else { ?>
		<? if(Defined('CID')){ ?>
		<div class="panel-heading" style="padding:15px; text-align:center;">
			<font color="red">В этой категории нет товара.</font>
		</div><br />
		<? } else { ?>
		<div class="panel-heading" style="padding:15px; text-align:center;">
			<font color="red">Для продажи добавьте свой товар в Админке.</font>
		</div><br />
		<? } ?>
	<? } ?>
</div> <!-- close div.col-lg-8-->
<? include('rightMenu.php'); ?>
</div> <!-- close div.maincont-->
<script type="text/javascript">
// $(document).ready(function(){	
// 	$("tr").easyTooltip();
// });
</script>
<script>
                    // $(document).ready(function(){	
                    //     function test(a) {
                    //         if (a=="13") {
                    //             $("#test").click();
                    //             console.log('$("#test").click(): ', $("#test").click())
                    //         }
                    // }
                    // });
                    </script>
	<aside id="sidebar-second" role="complementary" class="sidebar clearfix">
		<div class="region region-sidebar-second">
			<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `orders` WHERE `sid` = '".intval(SID)."' AND `status` = '1' ORDER BY oid DESC LIMIT 3"); ?>
			<? if(mysqli_num_rows($SQL) > 0){ ?>
			<section id="block-block-6" class="block block-block">
				<h2 class="block-title">Последние покупки</h2>
				<div class="content">
					<div id="csgo">
						<table class="views-view-grid cols-3">
							<tbody>
								<? while($row = mysqli_fetch_array($SQL)){ ?>
								<? $SQL1 = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `id` = '".intval($row['item_id'])."'"); ?>
								<? if(mysqli_num_rows($SQL1) > 0){ ?>
								<? $ITEM = mysqli_fetch_array($SQL1); ?>
								<tr>
									<td class="col-166">
										<div class="views-field views-field-field-price">
											<div class="field-content"><?=$row['price'];?> <?=$row['wallet'];?></div>  
										</div>  
										<div class="views-field views-field-field-image">        
											<div class="field-content">
												<a href="/item/<?=$ITEM['item_id'];?>">
													<img src="<?=$ITEM['image'];?>" height="107" width="230">
												</a>
											</div>  
										</div>  
										<div class="views-field views-field-title">        
											<span class="field-content">
												<a href="/item/<?=$ITEM['item_id'];?>"><?=$ITEM['item'];?></a>
											</span>  
										</div>
									</td>
								</tr>
								<? } ?>
								<? } ?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
			<? } ?>
			<section id="block-block-7" class="block block-block">
				<h2 class="block-title">Контакты</h2>
				<div class="content">
					<div id="block-block-7-ajax-content" class="ajaxblocks-wrapper"><?=CONTACTS;?></div> 				 
				</div>
			</section>
			<section id="block-block-19" class="block block-block">
				<h2 class="block-title">Информация</h2>
				<div class="content">
					<div id="csgo">
						<div id="block-block-7-ajax-content" class="ajaxblocks-wrapper"><?=INFORMATION;?></div>
					</div>
				</div>
			</section>
		</div>
	</aside>
			<?
				# Сортировка по категориям
				if(Defined('CID')){
					$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
				# Обычный вывод без сортировки
				} else {
					$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ".(Defined('SEARCH') ? "AND `item` LIKE '%".mysqli_real_escape_string($this->connectMainBD, SEARCH)."%'" : "AND `main` = '1'")." ORDER BY item_id ASC");
				}
			?>
			<section id="main" role="main" class="clearfix">
				<a id="main-content"></a> 
				<section id="block-quicktabs-the-main-unit-of-goods" class="block block-quicktabs">
					<div class="content">
						<div id="quicktabs-the_main_unit_of_goods" class="quicktabs-ui-wrapper">
							<ul>
								<li><a href="#qt-the_main_unit_of_goods-ui-tabs1">Все товары</a></li>
							</ul>
							<div id="qt-the_main_unit_of_goods-ui-tabs1" style="position: relative; left: 4px;">
								<section id="block-views-goods-block" class="block block-views">
									<div class="content">
										<div class="view view-goods view-id-goods view-display-id-block view-dom-id-0360474a33e5c35727ec79d722867d49">
											<div class="view-content">
												<table class="views-view-grid cols-3">
													<tbody>
														<? if(mysqli_num_rows($SQL) > 0){ ?>
														<div id="h-slider" style="position: relative; bottom: 9px;">
															<? while($row = mysqli_fetch_array($SQL)){ ?>
															<? $price = json_decode($row['price'], true); ?>
															<td class="col-<?=$row['item_id'];?>">
																<div class="views-field views-field-field-price">
																	<div class="field-content"><?=$price['WMR'];?> RUR</div>  
																</div>  
																<div class="views-field views-field-field-image">        
																	<div class="field-content">
																		<a href="/item/<?=$row['item_id'];?>">
																			<img src="<?=$row['image'];?>" width="230" height="107">
																		</a>
																	</div>  
																</div>  
																<div class="views-field views-field-title">        
																	<span class="field-content">
																		<a href="/item/<?=$row['item_id'];?>"><?=$row['item'];?></a>
																	</span>  
																</div>    
															</td>
															<? } ?>
														</div>
														<? } ?>
													</tbody>
												</table>
											</div>
										</div>  
									</div>
								</section>
							</div>
						</div>  
					</div>
				</section>
				<section id="block-block-15" class="block block-block">
					<h2 class="block-title">Купить в магазине дешево и просто</h2>
				</section>
			</section>
			<? include('rightMenu.php'); ?>
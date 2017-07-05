						<section class="catalog-tabs">
							<div class="wrapp">
								<div class="obl-btns">
									<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `categories` WHERE `sid` = '".intval(SID)."'"); ?>
									<? if(mysqli_num_rows($SQL) > 0){ ?>
										<? while($row = mysqli_fetch_array($SQL)){ ?>
										<h2 class="obl-btns-btn-wr _active">
											<a type="button" class="lucky-top-btn" href="/item/<?=$row['name'];?>"><?=$row['category'];?></a>
										</h2>
										<? } ?>
									<? } ?>
								</div>
								<div class="category-info test">
									<?
										# Сортировка по категориям
										if(Defined('CID')){
											$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' AND `cid` = '".intval(CID)."' ORDER BY item_id ASC");
										# Обычный вывод без сортировки
										} else {
											$SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `items` WHERE `sid` = '".intval(SID)."' ".(Defined('SEARCH') ? "AND `item` LIKE '%".mysqli_real_escape_string($this->connectMainBD, SEARCH)."%'" : "AND `main` = '1'")." ORDER BY item_id ASC");
										}
									?>
									<? if(mysqli_num_rows($SQL) > 0){ ?>
									<? while($row = mysqli_fetch_array($SQL)){ ?>
									<? $price = json_decode($row['price'], true); ?>
									<div class="products-list-item">
										<a href="/item/<?=$row['item_id'];?>" class="prod-preview animated">
											<div class="prod-preview-overlay" style="background-image: url('<?=$row['image'];?>')"></div>
											<div class="prod-preview-hover-gr">
												<div class="prod-preview-desc">
													<div class="line-prod-preview">
														<h2 class="prod-preview-title"><?=$row['item'];?></h2>
													</div>
												</div>
												<div class="tab-prev-price-btn">
													<span class="btn btn-round btn-orng btn-md prod-preview-price-btn">
													<span class="ico ico-cart-w"></span><?=$price['WMR'];?> Р</span>
												</div>
											</div>
										</a>
									</div>
									<? } ?>
									<? } else { ?>
									<div class="products-wr">
										<div class="products-wr-tab">
											<div class="products-list">
												<div class="panel">
													<div class="panel-body" style="min-height: 350px;">
														<center>
															<br /><font color="red">Товаров нет.</font>
														</center>
													</div>
												</div>
											</div>
										</div>
									</div>
									<? } ?>									
								</div>
								<div class="products-wr">
									<div class="products-wr-tab">
										<div class="products-list">
											<div class="archive-block">
												<br />
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>
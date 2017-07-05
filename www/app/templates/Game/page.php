	<? include('rightMenu.php'); ?>
	<? if(Defined('PID')){ ?>
	<? $SQL = mysqli_query($this->connectMainBD, "SELECT * FROM `pages` WHERE `pid` = '".intval(PID)."' AND `sid` = '".intval(SID)."'"); ?>
	<? if(mysqli_num_rows($SQL) > 0){ ?>
	<? $PAGE = mysqli_fetch_array($SQL); ?>
	<section id="block-panels-mini-info-good" class="block block-panels-mini" style="margin-top: -10px;">
		<div class="content">
			<div class="panel-display panel-2col clearfix" id="mini-panel-info_good">
				<div class="panel-panel panel-col-first">
					<div class="inside">
						<div class="panel-pane pane-block pane-quicktabs-product-description">
							<div class="pane-content">
								<div id="quicktabs-product_description" class="quicktabs-ui-wrapper qt-ui-tabs-processed-processed ui-tabs ui-widget ui-widget-content ui-corner-all">
									<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
										<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
											<a>Описание</a>
										</li>
									</ul>
									<div id="qt-product_description-ui-tabs1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" style=" background-color: rgba(0,0,0,0.2); display: block; border-width: 0; padding: 10px; background-color: rgba(0,0,0,0.2); ">
										<h1 class="title" id="page-title"><?=$PAGE['title'];?></h1>
										<div class="view view-product-description view-id-product_description view-display-id-block view-dom-id-fa8fd795a7bef86618d33faa3cd37d89">
											<div class="view-content">
												<div>
													<div class="views-field views-field-body">        
														<div class="field-content"><p></p><p><?=$PAGE['body'];?></p><p></p></div>  
													</div>  
												</div>
											</div>
										</div>
									</div>				
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<? } ?>
	<? } ?>
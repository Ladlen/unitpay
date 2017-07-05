	<div id="content" style="width: 85%; margin: 0 auto;">
		<aside id="side-center">
			<div class="speedbar">
				<style>
					#showcase {
						display: none;
					}
				</style>
				<a href="/" class="home"></a>
				Мои покупки
			</div>
			<div class="buy-item">
				<div class="buy-view">
					<style>
						.tdcl {
							padding: 5px;
							border: solid 1px rgb(223, 223, 223);
						}
						.btnr {
							width: 100%;
							margin-top: 10px;
							margin-bottom: 10px;
							background-color: #5F5F5F;
							color: #fff;
							border: 0;
							height: 45px;
							font-size: 20px;
						} 
						.table {
							font-size: 12px;
							width: 100%;
							margin-top: 10px;
						}
						.inputtext {
							display: block;
							height: 30px;
							width: 100%;
							padding: 15px;
							font-size: 14px;
							line-height: 1.428571429;
							color: rgb(0, 0, 0);
							vertical-align: middle;
							background-color: rgba(244, 244, 244, 0.77);
							border: 1px solid rgb(228, 228, 228);
							border-radius: 4px;
							box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
							transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
						}
						.inputtext:focus {
							border-color: rgb(183, 183, 183);
							outline: 0;
							-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075),0 0 8px rgba(0, 0, 0, 0.6);
							box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075),0 0 3px rgba(76, 76, 76, 0.6);
						}
						.inputtextarea {
							display: block;
							height: 350px;
							width: 100%;
							padding: 15px;
							font-size: 14px;
							line-height: 1.428571429;
							color: rgb(0, 0, 0);
							vertical-align: middle;
							background-color: rgba(244, 244, 244, 0.77);
							border: 1px solid rgb(228, 228, 228);
							border-radius: 4px;
							box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
							transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
						}
						.inputtextarea:focus {
							border-color: rgb(183, 183, 183);
							outline: 0;
							-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075),0 0 8px rgba(0, 0, 0, 0.6);
							box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075),0 0 3px rgba(76, 76, 76, 0.6);
						}
						.warning {
							background-color: rgb(242, 222, 222);
							padding: 15px;
							border-radius: 5px;
							margin-top: 15px;
							max-width: 525px;
						}
					</style>
					<form class="form-inline">
						<input type="text" id="mydata1" class="inputtext" style="margin-top: 10px;" placeholder="Введите e-mail" name="email" />
						<input type="button" id="btn" onclick="send()" style="margin-top: 10px;" class="btnr" value="Отправить" />
					</form>
					<script>
						$(".sidebox_title_black.br2").text("Мои покупки");
					</script>
					<script>
						function send(){
							$.post("/myorders/", {"email":$('#mydata1').val()}, function(a){
								obj = jQuery.parseJSON(a);
								if(obj['status'] == true){
									alert('Успех, '+obj['message']);
								} else if(obj['status'] == false){
									alert('Ошибка, '+obj['message']);
								}
							});
						}
					</script>
				</div>
			</div>
		</aside>
	</div>
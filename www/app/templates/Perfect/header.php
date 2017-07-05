<html>
	<head>
		<meta charset="utf-8">
		<title><?=(defined('NAME_PAGE') ? NAME_PAGE.' - ' : '').TITLE;?></title>
		<link rel="shortcut icon" href="<?=FAVICON;?>" type="image/x-icon">
        <meta name="description" content="<?=DESCRIPTION;?>">
        <meta name="keywords" content="<?=KEYWORDS;?>">
		<link href="/assets/css/jquery.toastmessage.css" rel="stylesheet" media="screen">
		<link href="/assets/Perfect/css/bootstrapgoodakk.css" rel="stylesheet" media="screen">
		<script type="text/javascript" src="/assets/Lite/js/jquery.js"></script>
		<link href="/assets/Perfect/css/style.css" rel="stylesheet" media="screen">
		<link href="/assets/Perfect/css/menu.css" rel="stylesheet" media="screen">
		<link href="/assets/Perfect/css/menu2.css" rel="stylesheet" media="screen">
		<link href="/assets/Perfect/css/bootstrap-glyphicons.css" rel="stylesheet" media="screen">
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="/assets/js/app.js"></script>
		<script src="/assets/js/popup_buy.js"></script>
		<script src="/assets/js/jquery.toastmessage.js"></script>
	</head>
	<body>
		<style>
			@font-face {
				font-family: "Jura-DemiBold";
				src: url("/assets/Perfect/fonts/Jura-DemiBold.ttf");
			}

			.list-group {
				margin-bottom: 0px;
			}

			#header #t-nav li a {
				height: 42px;
			}

			TABLE {
				width: 558px;
				display: block;
				height: 60px;
				overflow: hidden;
				position: relative;
				font-family: 'Jura-DemiBold';
				margin-bottom: 0px;
				-webkit-border-radius: 2px;
				-webkit-border-bottom-right-radius: 3px;
				-webkit-border-bottom-left-radius: 3px;
				-moz-border-radius: 2px;
				-moz-border-radius-bottomright: 3px;
				-moz-border-radius-bottomleft: 3px;
				border-radius: 6px;
				border-bottom-right-radius: 6px;
				border-bottom-left-radius: 6px;
				background-color: #e9eff2;
			}

			TD {
				background: #e9eff2;
			}

			body {
				background-repeat: no-repeat;
				background-position: center top;
				background-attachment: fixed;
				font-family: Jura-DemiBold;
			}

			#footer {
				overflow: hidden;
				text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
				background: #212427;
				-webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.2), 0 1px rgba(255, 255, 255, 0.08);
				box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.2), 0 1px rgba(255, 255, 255, 0.08);
				border-radius: 0px;
				height: 158px;
				width: 1000px;
				margin: auto;
				padding: 5px 1px;
				margin-top: -329px;
			}

			#footer {
				overflow: hidden;
				background-image: linear-gradient(to right, transparent, rgba(0, 0, 0, 0.075) 15%, rgba(0, 0, 0, 0.125), rgba(0, 0, 0, 0.075) 75%, transparent), linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.075) 15%, rgba(255, 255, 255, 0.125), rgba(255, 255, 255, 0.075) 75%, rgba(255, 255, 255, 0)), radial-gradient(ellipse farthest-corner at top center, rgba(255,255,255,0.07), rgba(255,255,255,0) 50%);
				background-size: 100% 1px, 100% 1px, 100% 100%;
				background-repeat: no-repeat, no-repeat, repeat;
				background-position: 0 0;
				background-origin: border-box, padding-box, padding-box;
				border-top: 1px solid transparent;
				background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%,rgba(0,0,0,0.5) 100%);
				height: 158px;
				width: 1000px;
				margin: auto;
				padding: 5px 1px;
				margin-top: -329px;
			}

			#middle {
				float: left;
				width: 1000px;
				background-color: #fff;
				-webkit-border-bottom-right-radius: 3px;
				-webkit-border-bottom-left-radius: 3px;
				-moz-border-radius-bottomright: 3px;
				-moz-border-radius-bottomleft: 3px;
				border-bottom-right-radius: 0;
				border-bottom-left-radius: 0;
			}

			#f-mid #copy {
				display: inline-block;
				vertical-align: top;
				line-height: 18px;
				margin: 10px 0;
				padding: 1px 8px 0px;
				text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
				background: #212427;
				border: 1px solid #1A1A1A;
				border-radius: 2px;
				-webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.2), 0 1px rgba(255, 255, 255, 0.08);
				box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.2), 0 1px rgba(255, 255, 255, 0.08);
				color: #838992;
				float: left;
				color: #848484;
				margin-top: 29px;
				margin-right: 20px;
				margin-left: 10px;
				font-family: Jura-DemiBold;
				font-size: 14px;
				width: 160px;
				padding-left: 2px;
			}

			.block {
				margin-bottom: 30px;
			}

			.block .top {
				background: url(http://s7.hostingkartinok.com/uploads/images/2015/01/6b48c10a15be0ff42bbf13bcc6e01798.png) 11px 12px no-repeat;
				width: 211px;
				height: 49px;
				display: block;
				color: #fff;
				font-size: 14px;
				font-family: tahoma;
				cursor: pointer;
				padding-left: 38px;
				padding-top: 11px;
			}

			#f-mid #ws-copy .ws-logo {
				background: url(http://5.firepic.org/5/images/2014-10/30/7edoqt2a1nke.png);
				width: 140px;
				height: 77px;
				display: block;
				opacity: .5;
				-webkit-transition: opacity .25s ease-in-out;
				-moz-transition: opacity .25s ease-in-out;
				-ms-transition: opacity .25s ease-in-out;
				-o-transition: opacity .25s ease-in-out;
				transition: opacity .25s ease-in-out;
			}

			#f-bot #f-count {
				margin-top: 6px;
				float: left;
				width: 228px;
				height: 65px;
			}

			.lol123 {
				height: 158px;
				width: 1002px;
			}
			
			#menu {width:199px;font-family:arial;}
			ul {list-style:none;margin:0;padding:0;}
			#menu ul li {margin:0 0 3px 0;}  
			#menu li a {height:26px;text-decoration: none;font-size:13px;text-align:left;}  
			#menu li a:link, #menu li a:visited {color:#65614c;display:block;background:url('http://wallaby.ucoz.ru/Images_template/menu.png');padding:10px 0 0 20px;}  
			#menu li a:hover {background:url('http://wallaby.ucoz.ru/images/menur.png');color:#474747;}

			#h1 {
				font-size: 2em;
				margin: 0.67em 0;
				margin-top: 0px;
				margin-bottom: 0px;
				padding: 0px 10px 5px 10px;
				text-align: center;
				background: #00a789;
				color: #fff;
				height: 30px;
				font-family: "Century Gothic Bold";
				font-size: 20px;
			}

			#menu {
				width: 100%;
			}

			#menu ul {
				display: table-row;
				list-style: none;
				margin: 0;
				padding: 0;
			}

			#menu ul li {
				display: table-cell;
			}

			#menu ul li a {
				background: #ccc;
				color: #000;
				display: table-cell;
				padding: 10px 0;
				text-align: center;
				text-decoration: none;
				width: 1000px;
			}

			#menu ul li a:hover {
				background: #aaa;
			}

			.block-title {
				height: 40px;
				line-height: 40px;
				background: #1a1a1a;
				color: #fff;
				text-transform: uppercase;
				font-size: 15px;
				position: relative;
				z-index: 2;
			}
		</style>
		<style>
		.block-title {
    background: <?=COLORPERFECTBLOCK;?>;
}
</style>
<style>
.block-title1 {
    background: <?=COLORPERFECTVERX;?>;
}
</style>
<Style>
.block-title2 {
    background: <?=COLORPERFECTVERX;?>;
}
</style>
<Style>
label, input[type="button"], input[type="submit"], input[type="reset"], button {
    background-color: <?=COLORPERFECTVERX;?>;
}
</style>
		<style>body {background: url(<?=BACKGROUND;?>); no-repeat top center!important;background-attachment:fixed;}</style>
		<div id="main">
			<header id="header">
				<div id="m-nav">
					<a href="/"><img style="padding:0px" src="<?=LOGOTYPE;?>"></a>
				</div>
			</header>
			<section id="middle">
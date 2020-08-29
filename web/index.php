<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
	
	<style>
		body {
			font-family: Arial, Helvetica, sans-serif;
			margin:0;
			
		}
		
		.header{
			text-align: center;
			font-size: 28pt;
			font-family: consolas;
			font-weight: bolder;
			color: aliceblue;			
			background-color:sandybrown;
			padding: 15px;
			background-image: url(earth.jpg);
			background-repeat: no-repeat;
			background-size: cover;	
		}
		
		.icerik{
			
			text-align: justify;
			max-width: 1100px;
  			margin:auto ;					
			margin-bottom: 130px;
			margin-top: 25px;
			font-size: 13pt;
			background-color: white;	
			
		}
		
		#alan{
			margin-top:5px;
		}
		
		#veriler {
			margin-top:10px;
			text-align: center;
		}
		
		.temizle {
			background-color: #73AD21;
			display: inline-block;
			padding: 5px;
			border:none;
			color:white;	
			font-weight: bold;	
			width: 50%; 
			margin-bottom: 7px;
			cursor: pointer;
		}
		
		#tablo {
			border-collapse: collapse;  			
		}
		th, td {
		  	padding: 5px;
		  	text-align: left;
			border: 1px solid #ddd;
		}
		tr:nth-child(even){
			background-color: #f2f2f2;
		}
		th {
		  	padding-top: 12px;
		  	padding-bottom: 12px;
		  	text-align: left;
		  	background-color:cadetblue;
		  	color: white;
		}
		
		a {
			text-decoration: none;
			color:blueviolet;
			font-weight: bold;
		}
		
		a:hover, a:active{
			color: blue;
		}
	</style>
	
</head>

<body>	
	<div class="header">
		<h1>GPS KONUM TAKİBİ</h1>
	</div>
	
	<div class="icerik" align="center">
		
		<form action="index.php" method="POST" id="veriler"><input type="submit" name="temizle" value="TEMİZLE" class="temizle"/></form>
			
		<?php
		include "vtislemleri.php";

		if(isset($_GET["gonder"]))	
		{
			veriKayit();	
			header("Refresh:0; url=index.php");
		}
			
		if(isset($_POST["temizle"]))
			temizle();

		echo "<div id='alan' align='center'>".veriListele()."</div>";
		?>	

		<form action="index.php" method="GET" id="veriler" style="visibility:hidden">
			Enlem: <input type="text" name="en"/><br>
			Boylam: <input type="text" name="boy"/><br>
			Yükseklik: <input type="text" name="yuk"/><br>
			Hız: <input type="text" name="hiz"/><br>
			Yön: <input type="text" name="yon"/><br>
			Uydular: <input type="text" name="uyd"/><br>
			Tarih: <input type="text" name="trh"/><br>
			Saat: <input type="text" name="st"/><br>		
			<input type="submit" name="gonder" value="KAYIT"/>	
		</form>
		</div>
	
</body>
</html>
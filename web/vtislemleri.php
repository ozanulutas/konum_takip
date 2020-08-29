<?php
function baglan()
{
	$sunucu="localhost";
	$ka="root";
	$sifre="";
	$db="dbkonum";
	
	$bag=new PDO("mysql:host=$sunucu; dbname=$db; charset=utf8", $ka, $sifre);
	return $bag;
}

function veriKayit()
{
	try
	{
		$bag=baglan();
		$tbl="tblkonumlar";

		$en="";  if(isset($_GET["en"]))  $en=$_GET["en"];
		$boy=""; if(isset($_GET["boy"])) $boy=$_GET["boy"];
		$yuk=""; if(isset($_GET["yuk"])) $yuk=$_GET["yuk"];
		$hiz=""; if(isset($_GET["hiz"])) $hiz=$_GET["hiz"];
		$yon=""; if(isset($_GET["yon"])) $yon=$_GET["yon"];
		$uyd=""; if(isset($_GET["uyd"])) $uyd=$_GET["uyd"];
		$trh=""; if(isset($_GET["trh"])) $trh=$_GET["trh"];
		$st="";  if(isset($_GET["st"]))  $st=$_GET["st"];

		$komut=$bag->prepare("INSERT INTO $tbl VALUES(:en, :boy, :yuk, :hiz, :yuk, :uyd, :trh , :st)");
		$komut->bindParam(":en", $en);
		$komut->bindParam(":boy", $boy);
		$komut->bindParam(":yuk", $yuk);
		$komut->bindParam(":hiz", $hiz);
		$komut->bindParam(":yon", $yon);
		$komut->bindParam(":uyd", $uyd);
		$komut->bindParam(":trh", $trh);
		$komut->bindParam(":st", $st);
		$komut->execute();
		
		//$kayitlar=$komut->fetchAll();
	}
	catch(PDOException $hata)
	{
		echo "HATA: ".$hata->getMessage();
	}
	$bag=null;
	//return $kayitlar;	
}

function veriListele()
{
	$tablo="";
	try
	{
		$bag=baglan();
		$tbl="tblkonumlar";
		
		$komut=$bag->prepare("SELECT * FROM $tbl");
		$komut->execute();
		
		$sutunSayisi=$komut->columnCount();
		$tablo="<table border='1' id='tablo'><tr>";
		for($i=0; $i<$sutunSayisi; $i++)
		{
			$meta=$komut->getColumnMeta($i);
			$alanAdi[$i]=$meta["name"];
			$tablo.="<th>".$alanAdi[$i]."</th>";
		}
		$tablo.="<th>LİNK</th></tr>";		
		
		if($komut->rowCount())
		{
			while($satir=$komut->fetch(PDO::FETCH_NUM))
			{
				$tablo.="<tr>";
				for($i=0; $i<$sutunSayisi; $i++)
					$tablo.="<td>".$satir[$i]."</td>";
				$tablo.="<td><a target='_blank' href='http://www.google.com/maps/place/".$satir[0].",".$satir[1]."'>GİT</a></td></tr>";
			}
		}
		$tablo.="</table>";
	}
	catch(PDOException $hata)
	{
		echo "HATA: ".$hata->getMessage();
	}
	$bag=null;
	return $tablo;
}

function temizle()
{
	try
	{
		$bag=baglan();
		$tbl="tblkonumlar";
		
		$komut=$bag->prepare("DELETE FROM $tbl");
		$komut->execute();
	}
	catch(PDOException $hata)
	{
		echo "HATA: ".$hata->getMessage();
	}
	$bag=null;
}

?>
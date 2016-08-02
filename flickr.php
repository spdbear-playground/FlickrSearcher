<!DOCTYPE html>
<head>
	<title>Flickr Searcher - CSexp1 Part3</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
	<script type="text/javascript" src="DataTables/datatables.min.js"></script>
	<script src="js/typeahead.bundle.min.js"></script>

	<!-- navbar -->
	<div class="row">
		<nav class="navbar navbar-default navbar-fixed-top">

			<div class="navbar-header">
				<a href="index.html" class="navbar-brand">Home</a>
			</div>

			<ul class="nav navbar-nav">
				<li class ="active"><a href="flickr.html">Flickr Tool</a></li>
				<li><a href="sql.html">実装A,B,C</a></li>
				<li><a href="ans.html">Zip Searcher</a></li>
				<li><a href="ansall.html">Zip Searcher+</a></li>
				<li><a href="prog00.php">prog00</a></li>
				<li><a href="prog01.html">prog01</a></li>
			</ul>

		</nav>
	</div>

	<div class="container" style="padding:60px 0 0 0">


		<?php
		date_default_timezone_set('Asia/Tokyo');

		$tag = htmlspecialchars($_REQUEST["tag"]);

		echo '<h1>検索結果 - '.$tag.'</h1>';

		// set your apikey
		$Flickr_apikey = "********************************";

		$Flickr_getImage = "https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=".$Flickr_apikey."&text=".$tag."&license=1%2C2%2C3%2C4%2C5%2C6%2C7&sort=relevance&extras=license%2Cdate_upload%2Cowner_name%2Curl_s%2Curl_o&format=php_serial";
		$result = unserialize(file_get_contents($Flickr_getImage));

		$c = 0;
		foreach($result["photos"]["photo"] as $k => $photo){
			if(isset($photo["url_s"])){
				$title = $photo["title"];

				$l = $photo["license"];


				switch ($l) {
					case 1:
					$license = "<a href='http://creativecommons.org/licenses/by-nc-sa/2.0/jp/' target='_blank'>CC-BY-NC-SA</a>";
					break;
					case 2:
					$license = "<a href='http://creativecommons.org/licenses/by-nc/2.0/jp/' target='_blank'>CC-BY-NC</a>";
					break;
					case 3:
					$license = "<a href='http://creativecommons.org/licenses/by-nc-nd/2.0/jp/' target='_blank'>CC-BY-NC-ND</a>";
					break;
					case 4:
					$license = "<a href='http://creativecommons.org/licenses/by/2.0/jp/' target='_blank'>CC-BY</a>";
					break;
					case 5:
					$license = "<a href='http://creativecommons.org/licenses/by-sa/2.0/jp/' target='_blank'>CC-SA</a>";
					break;
					case 6:
					$license = "<a href='http://creativecommons.org/licenses/by-nd/2.0/jp/' target='_blank'>CC-BY-ND</a>";
					break;
					case 7:
					$license = "<a href='http://flickr.com/commons/usage/' target='_blank'>Public Domain</a>";
					break;
				}


				$url   = $photo["url_s"];
				$url2   = $photo["url_o"];
				$width = $photo["width_s"];
				$height= $photo["height_s"];
				$width2 = $photo["width_o"];
				$height2 = $photo["height_o"];
				$date   = date( "Y/m/d" , $photo["dateupload"] );
				$owner   = $photo["ownername"];
				$size  = max($width,$height);
				// $margin_top = ($size-$height)/2;
				// $margin_left= ($size-$width) /2;

				echo '<div class="col-md-4">';
				echo '<div class="image">';
				echo '<img class="img-rounded img-thumbnail" src="'.$url.'" width="'.$width.'" height="'.$height.'">';
				echo '</div>';
				echo '<div class="title">';
				echo '<p>';
				echo $title;
				echo '<br>';
				echo 'uploaded by: '. $owner;
				echo '<br>';
				echo 'upload date: '. $date;
				echo '<br>';
				echo $license;
				echo '<br>';
				echo '<a href="'.$url2.'" download="'.basename($url2).'">' .$width2.'*'.$height2 .' Download</a>';
				echo '</p>';
				echo '</div>';
				echo '</div>';
			}
		}
		?>

	</div>
</body>

</html>

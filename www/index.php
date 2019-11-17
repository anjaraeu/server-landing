<?php 
	$fh = fopen('/proc/meminfo','r');
	while ($line = fgets($fh)) {
		$pieces = array();
		if (preg_match('/^SwapTotal:\s+(\d+)\skB$/', $line, $pieces)) {
			$totalswap = $pieces[1];
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo ucwords(strtolower(gethostname())) ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" media="screen" href="semantic.min.css" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script src="jquery.js"></script>
		<script src="semantic.min.js"></script>
	</head>
	<body class="template">
		<div class="ui inverted vertical center aligned segment">
		<div class="ui container"><div class="ui massive borderless inverted menu"><h1 class="header item"><?php echo ucwords(strtolower(gethostname())) ?></h1></div></div>
			<div class="ui text container">
				<img src="<?php echo gethostname();?>.gif" alt="<?php echo gethostname();?> gif" class="ui circular centered image" />
				<h1 class="ui inverted header">Welcome here!</h1>
				<div class="text">Load average: <span id="avg"></span></div>
				<div class="text"><div class="ui orange progress" id="ram"><div class="bar"></div><div class="label">RAM Usage</div></div></div>
				<?php if($totalswap =! 0) {?><div class="text"><div class="ui green progress" id="swap"><div class="bar"></div><div class="label">Swap Usage</div></div></div><?php }?>
				<div class="text"><div class="ui red progress" id="du"><div class="bar"></div><div class="label">Disk Usage on /</div></div></div>
			</div>
		</div>
		<script src="script.js"></script>
	</body>
</html>

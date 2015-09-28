<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>FuelPHP Framework</title>
	<?php
        echo Asset::css(array(
            'bootstrap.css',
            'jquery-ui/jquery-ui.css',
            'template.css',
        ));
        ?>
        <?php
        echo Asset::js(array(
            'jquery.js',
            'bootstrap.js',
            'jquery-ui/jquery-ui.min.js',
        ));
        ?>
</head>
<body>
	<div>
		<ul>
			<li>
				<a href='<?php echo Uri::base(false); ?>categories/index'>Categories</a>
			</li>
			<li>
				<a href='<?php echo Uri::base(false); ?>fetchdata/index'>Fetch Data</a>
			</li>
			<li>
				<a href='<?php echo Uri::base(false); ?>items/index'>Items Data</a>
			</li>
		</ul>
	</div>
	<br>
	<br>
	<br>
	<div>
		<?php echo $this->content; ?>
	</div>
</body>
</html>

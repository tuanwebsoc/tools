<div class="wrap">
	<?php foreach ($models as $item): ?>
	<div class="item">
		<ul	class="child-item">
			<?php 
				$books = $item->data;
				$bo2 = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $books), true );
				$bo = json_decode($books, JSON_UNESCAPED_UNICODE);
				$bo3 = str_replace('&quot;', '&#39;', $books);
				$bo4 = preg_replace("/([a-zA-Z0-9_]+?):/" , "\"$1\":", $books);
				
				echo "<pre>";
				var_dump(json_decode($books));
				var_dump($books);
// 				var_dump(addslashes($bo3));
// 				var_dump(json_last_error());
			?>
		</ul>
	</div>
	<?php endforeach; ?>
</div>

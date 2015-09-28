<div><a href="javascript:void(0)" class="btn-fetch">Fetch data</a></div>
<div class="list-select">
	<?php 
                echo Form::select("list-categories",
                        '',
                        $categories,
                		array("class" => "list-categories")
                 );
     ?>
</div>
<div>
	<a href="javascript:void(0)" class="saveall">Save all</a>
</div>
<script type="text/javascript">

// Get data from it-books
$('.btn-fetch').on('click', function(){
	// Get category selected
	var cat_id = $('.list-categories').val();
	$("#data").html("");
	$.ajax({
		  url: '<?php echo Uri::base(false); ?>fetchdata/fetch',
		  type: 'POST',
		  data: {
			"category_id": cat_id
		  },
		  success: function(data) {
// 			  console.log(JSON.stringify(data));
				$("#count-data").text(data.length);
			  var strings = JSON.stringify(data['Books']),
			  		books = data['Books'];
			  
			  $.each(books, function(k, v){
				  var parents = $('<div>', {'class': 'wrap-item'})

				  parents.append(
						  $('<div>', {'class': 'item-title'}).append(
									$('<a>', {'href': 'javascript:void(0)', 'class': 'save-item', 'data-href': '<?php echo Uri::base(false); ?>/fetchdata/saveitem/' + v["ID"]}).text('Save')
						  ),
						  $('<div>', {'class': 'item-id'}).html(v["ID"]),
						  $('<div>', {'class': 'item-title'}).html(v["Title"])
				  );

				  $("#data").append(parents);
			  });
			  // Called when successful
			 //  $('#data').html(strings);
		  }
	});
});

$(document).on('click', '.save-item', function(){
	var datahref = $(this).attr('data-href'),
		cat_id = $('.list-categories').val();

	$.ajax({
		  url: datahref,
		  type: 'GET',
		  data: {
			'category_id': cat_id
		  },
		  success: function(data) {
			  console.log(data);
		  }
	});
});

$('.saveall').on("click", function(e){
	var allitem = $(".wrap-item").find(".save-item");

	$.each(allitem, function(k, v){
		$(v).trigger("click");
	});
});
</script>
<pre>
<span id="count-data"></span>
</pre>
<pre>
	<div id="data">
	
	</div>
</pre>

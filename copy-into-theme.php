<?php

//This goes into: checkout/review_order.php after the jigoshop_cart::needs_shipping() if statement, around line 90. You can add your collection options manually.

if($_SESSION['_chosen_method_id']=='collection'): ?>
	<tr>
		<td colspan="2"><?php _e('Collection Place', 'jigoshop'); ?></td>
		<td>
			<select name="collection_location" id="collection_location">
				<option value="Head Office">Head Office</option>
				<option value="Custom House">Custom House Quay</option>
				<option value="North Wall Quay">North Wall Quay</option>
				<option value="Mayor Street">Mayor Street</option>
			</select>
		</td>
	</tr>
<?php endif; ?>


<script>

//Put this into the footer of your theme, it grabs the values of the dropdown and appends it to the notes textarea.

$("#collection_location").live('change', function(){
	$('#order_comments').val($('#order_comments').val() + ' Collecting from: ' + $(this).attr('value'));
});

</script>
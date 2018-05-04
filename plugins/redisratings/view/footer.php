<div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post">
	  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Give your rate for this business</h4>
      </div>
      <div class="modal-body">
		<div class="response"></div>
		<div class="row">
			<div class="col-md-12">
				
				<input type="hidden" name="post_id"  id="id_for_rate" value="">
				<label>1</label>
				<input type="radio" name="rate" value="1">
				<label>2</label>
				<input type="radio" name="rate" value="2">
				<label>3</label>
				<input type="radio" name="rate" value="3">
				<label>4</label>
				<input type="radio" name="rate" value="4">
				<label>5</label>
				<input type="radio" name="rate" value="5">
				
			</div>
		</div>
      </div>
     <div class="modal-footer">
           <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Close</button>
		   <input type="submit" class="btn btn-primary" id="save_action" name="rate_action" value="Rate it!">
      </div>
	 </form>
    </div>
  </div>
</div>
<script>
function addRating(e){
	
	jQuery("#id_for_rate").val(jQuery(e).attr("data-value"));
	jQuery("#ratingModal").modal("show");
}
jQuery(document).ready(function() {
	
});

</script>

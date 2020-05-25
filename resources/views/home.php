<?php require 'partials/header.php'; ?>
    <div class="row">
        <form class="form-horizontal" action="/upload_file" method="post" name="frm" id="frm" enctype="multipart/form-data">
            <div class="input-row">
            	<input type="file" name="file" id="file" accept=".csv">
            	<button type="submit" id="submit" name="upload_file" class="btn btn-success">Upload and Process</button>
                
            </div>
        </form>
    </div>

<?php 
	if( isset($structeredOwners) ) { 
		if( count($structeredOwners) ) {
	?>
	
 <table class='table table-stripped' id='userTable'>
    <thead>
        <tr>
            <th>Parsed Property Owners - Total rows: <?= count($structeredOwners) ?></th>
        </tr>
    </thead>
    
    <tbody>
    <tr>
        <td><pre><?= print_r($structeredOwners); ?></pre></td>
    </tr>
	</tbody>
 </table>

 

<?php } else { ?>

	<div class="row" style="margin-top:20px">
	  <div class="alert alert-danger" style="margin-left:0">
 			Unable to parse. Please make sure you upload the a CSV file containing first column with property owners data.<br>
 			Can use CSV file from sample folder provided in this project.
 	  </div>
	</div>

<?php }  

} ?> 

</div>



</div><!-- container -->
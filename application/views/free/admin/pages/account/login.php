<!-- ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ -->
	
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
     <!-- /.login-logo -->
      <div class="login-box-body">
		<?php 
			if(trim($status)!='' AND trim($message)!=''){
		  ?> 
				<div> 
					<div class="callout  mb-1 <?php echo ($status==200)?'callout-success':'callout-danger'; ?>">
					  <div style="text-align:left;"><?php echo $message; ?></div>
					  </div>
				</div> 
		  <?php
			}
		  ?>   
        
		<form method="POST" action=""> 
		<div class="form-group">
			<div class="d-block">
				<label for="password" class="control-label">Username</label>
			</div>
			<input type="text" class="form-control" name="user_name">
		</div>
		<div class="form-group">
			<div class="d-block">
				<label for="password" class="control-label">Password</label>
			</div>
			<input type="password" class="form-control" name="user_password">
		</div>
		<div class="form-group">
			<div class="d-block">
				<label for="shift" class="control-label">Shift</label>
			</div>
			<select name="shift" id="shift" class="form-input form-control form-select2" style="width: 100%;" data-placeholder="Pilih Shift">
				<?php foreach($data_shift as $arr){
					$selected=($shift_time>=$arr['shift_hour_start']&&$shift_time<=$arr['shift_hour_end'])?'selected':'';
					?>
				<option value="<?php echo $arr['shift_id']?>" <?php echo $selected;?>><?php echo $arr['shift_name']?></option>
				<?php } ?>
			</select>
		</div>
          <div class="row">  
            <!-- /.col -->
            <div class="col-md-12">
				<button type="submit" name="submit" value="1" class="btn btn-primary btn-lg btn-block"><i class="ft-unlock"></i> Login</button>
            </div>
            <!-- /.col -->
          </div>
        </form> 
   
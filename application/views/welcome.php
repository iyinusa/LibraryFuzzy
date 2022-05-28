<!-- WELCOME SECTION -->
<div class="container">
	<div class="row mt">
    	<div class="col-lg-2"></div>
        <div class="col-lg-8">
        	<div class="text-center">
                <h3><b>INFORMATION RETRIVAL USING FUZZY LOGIC<br /><span class="text-muted">(Lagos State Polytechnic Library)</span></b></h3>
            </div>
            
            <hr style="border:1px solid #eee;" />
            
            <div class="col-lg-12 text-center">
                <?php echo form_open_multipart(''); ?>
               		<?php
						$all_publisher = '';
						$all_author = '';
						$all_department = '';
						
						//get all publisher
						if(!empty($allpublisher)){
							foreach($allpublisher as $publisher){
								if(!empty($e_pub_id)){
									if($e_pub_id == $publisher->id){
										$p_sel = 'selected="selected"';	
									} else {$p_sel = '';}
								} else {$p_sel = '';}
								
								$all_publisher .= '<option value="'.$publisher->id.'" '.$p_sel.'>'.$publisher->name.'</option>';
							}
						}
						
						//get all author
						if(!empty($allauthor)){
							foreach($allauthor as $author){
								if(!empty($e_author_id)){
									if($e_author_id == $author->id){
										$a_sel = 'selected="selected"';	
									} else {$a_sel = '';}
								} else {$a_sel = '';}
								
								$all_author .= '<option value="'.$author->id.'" '.$a_sel.'>'.$author->name.'</option>';
							}
						}
						
						//get all department
						if(!empty($alldepartment)){
							foreach($alldepartment as $department){
								if(!empty($e_dept_id)){
									if($e_dept_id == $department->id){
										$d_sel = 'selected="selected"';	
									} else {$d_sel = '';}
								} else {$d_sel = '';}
								
								$all_department .= '<option value="'.$department->id.'" '.$d_sel.'>'.$department->name.'</option>';
							}
						}
					?>
                    
                    <div class="form-inline">
                        <div class="form-group">
                        	<select name="pub_id" class="form-control">
                                <option>All Publishers</option>
                                <?php echo $all_publisher; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="author_id" class="form-control">
                                <option>All Authors</option>
                                <?php echo $all_author; ?>
                            </select>
                        </div>
                        <div class="form-group">
                        	<select name="dept_id" class="form-control">
                                <option>All Department</option>
                                <?php echo $all_department; ?>
                            </select>
                        </div>
                    </div>
                    <br />
                    <div class="form-inline">
                        <div class="form-group">
                            <input type="text" name="query" class="form-control" placeholder="Search Query" />
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="pull-left btn btn-success"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                <?php form_close(); ?>
            </div>
            
            <hr style="border:1px solid #ddd;" />
            
            <div class="col-lg-12 text-muted text-center">
            	FUZZY LOGIC BOOK RESULT
            </div>
            
            <hr style="border:1px solid #eee;" />
            
            <div class="row col-lg-12">
            	<?php if(!empty($err_msg)){echo $err_msg;} ?>
				
				<?php if(!empty($search)){ ?>
                	<?php foreach($search as $sr){ ?>
                    	<?php
							$dept_name = '';
							$author_name = '';
							$pub_name = '';
							$gdept = $this->user->query_rec_single('id', $sr->dept_id, 'bz_department');
							if(!empty($gdept)){
								foreach($gdept as $gd){
									$dept_name = $gd->name;
								}
							}
							
							$gauthor = $this->user->query_rec_single('id', $sr->author_id, 'bz_author');
							if(!empty($gauthor)){
								foreach($gauthor as $ga){
									$author_name = $ga->name;
								}
							}
							
							$gpub = $this->user->query_rec_single('id', $sr->pub_id, 'bz_publisher');
							if(!empty($gpub)){
								foreach($gpub as $gp){
									$pub_name = $gp->name;
								}
							}
							
							//increase record relevance
							$new_vew = $sr->view + 1;
							$upd_data = array(
								'view' => $new_vew
							);
							$this->user->update_rec('id', $sr->id, 'bz_book', $upd_data);
							
							//compute star rate view
							$rate_star = '';
							$relavance = $sr->relevance;
							if($relavance >= 0 && $relavance <= 20){
								$rate_star = '
									<i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
								';
							} else if($relavance > 20 && $relavance <= 40){
								$rate_star = '
									<i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
								';
							} else if($relavance > 40 && $relavance <= 60){
								$rate_star = '
									<i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
								';
							} else if($relavance > 60 && $relavance <= 80){
								$rate_star = '
									<i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
								';
							} else {
								$rate_star = '
									<i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
								';
							}
						?>
                        
                        <div class="col-lg-12 box_search">
                            <div class="bs_title">
								<a target="_blank" href="<?php echo base_url('uploads/'.$sr->doc); ?>"><?php echo $sr->title; ?></a> 
                                <span class="text-muted small">[<?php echo $sr->pages; ?> pages]</span>
                            </div>
                            <div class="bs_details">
								<?php echo $sr->details; ?><br />
                                <span class="text-danger">
                                    <?php echo $rate_star.' / '. number_format($relavance,2); ?>% Relevance
                                </span>
                                <br /><br />
                                <b><?php echo $dept_name; ?></b> | ISBN: <?php echo $sr->isbn; ?>
                                <div class="bs_primary">
									<?php echo $sr->edition; ?> of 
									<?php echo $pub_name; ?> Publication, 
									<?php echo $sr->year; ?> by 
                                    <?php echo $author_name; ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                	
                <?php } ?>
            </div>
            
            <hr style="border:1px solid #ddd;" />
            
            <div class="col-lg-12 text-center">
            	<a href="<?php echo base_url('books'); ?>" class="btn btn-info btn-block" style="display:block;"><h4 style="color:#fff;">Admin Login <i class="fa fa-arrow-circle-right"></i></h4></a>
                <br />
                Project by Ayetomowo Bola - 1405022043<br />(Computer Science, Lagos State Polytechnic)
            </div>
    	</div>
        <div class="col-lg-2"></div>
 	</div>
</div>
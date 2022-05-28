    <div class="rightside">
        <div class="page-head">
            <h1>Books</h1>
            <ol class="breadcrumb">
                <li>You are here:</li>
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Books</li>
            </ol>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-sm-12">
                    <?php echo form_open_multipart('books'); ?>
                        <div class="box">
                            <div class="box-title">
                                <i class="fa fa-upload"></i>
                                <h3>New Book</h3>
                                <div class="pull-right box-toolbar">
                                    <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                                </div>          
                            </div>
                            
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
                            
                            <div class="box-body" style="overflow:auto;">
                                <?php if(!empty($err_msg)){echo $err_msg;} ?>
                                <div class="col-lg-12">
                                	<div class="col-lg-6">
                                        <div class="form-group">
                                            <label>ISBN</label>
                                            <input type="text" name="isbn" placeholder="ISBN Number" class="form-control" value="<?php if(!empty($e_isbn)){echo $e_isbn;} ?>" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="book_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                                            <input type="hidden" name="edoc" value="<?php if(!empty($e_doc)){echo $e_doc;} ?>" />
                                            
                                            <label>Publisher</label>
                                            <select name="pub_id" class="form-control">
                                                <option>...Select Publisher</option>
                                                <?php echo $all_publisher; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Author</label>
                                            <select name="author_id" class="form-control">
                                                <option>...Select Author</option>
                                                <?php echo $all_author; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select name="dept_id" class="form-control">
                                                <option>...Select Department</option>
                                                <?php echo $all_department; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Edition</label>
                                            <input type="text" name="edition" placeholder="1st Edition" class="form-control" value="<?php if(!empty($e_edition)){echo $e_edition;} ?>" required="required" />
                                        </div>
                                  	</div>
                                    
                                    <div class="col-lg-6">
                                    	<div class="form-group">
                                            <label>Publication Year</label>
                                            <input type="text" name="year" placeholder="YYYY" class="form-control" value="<?php if(!empty($e_year)){echo $e_year;} ?>" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <label>Book Title</label>
                                            <input type="text" name="title" placeholder="Book Title" class="form-control" value="<?php if(!empty($e_title)){echo $e_title;} ?>" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="details" class="form-control"><?php if(!empty($e_details)){echo $e_details;} ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Book Pages</label>
                                            <input type="text" name="pages" placeholder="1253" class="form-control" value="<?php if(!empty($e_pages)){echo $e_pages;} ?>" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="doc" placeholder="Upload Book" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer clearfix">
                                <button type="submit" name="submit" class="pull-left btn btn-success">Update Record <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
                
                
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-title">
                            <i class="fa fa-upload"></i>
                            <h3>Books Report</h3>
                            <div class="pull-right box-toolbar">
                                <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                            </div>          
                        </div>
                        <div class="box-body">
                            <?php
								$dir_list = '';
								if(!empty($allup)){
									foreach($allup as $up){
										$dept_name = '';
										$author_name = '';
										$gdept = $this->user->query_rec_single('id', $up->dept_id, 'bz_department');
										if(!empty($gdept)){
											foreach($gdept as $gd){
												$dept_name = $gd->name;
											}
										}
										
										$gauthor = $this->user->query_rec_single('id', $up->author_id, 'bz_author');
										if(!empty($gauthor)){
											foreach($gauthor as $ga){
												$author_name = $ga->name;
											}
										}
										
										$dir_list .= '
											<tr>
												<td>'.$up->year.'</td>
												<td>'.$dept_name.'</td>
												<td><a target="_blank" href="'.base_url().'uploads/'.$up->doc.'">'.$up->title.'</a></td>
												<td>'.$author_name.'</td>
												<td>'.$up->edition.'</td>
												<td>
													<a href="'.base_url().'books?edit='.$up->id.'" class="btn btn-primary btn"><i class="fa fa-pencil"></i> Edit</a>
													<a href="'.base_url().'books?del='.$up->id.'" class="btn btn-danger btn"><i class="fa fa-times"></i> Delete</a>
												</td>
											</tr>
										';	
									}
								}
							?>	
                            
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>YEAR</th>
                                        <th>DEPT.</th>
                                        <th>BOOK</th>
                                        <th>AUTHOR</th>
                                        <th>EDITION</th>
                                        <th width="150">MANAGE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php echo $dir_list; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
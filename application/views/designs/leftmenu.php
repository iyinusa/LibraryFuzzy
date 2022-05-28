<?php
	if($page_act == 'setup'){$setup_active = 'active';}else{$setup_active = '';}
	if($page_act == 'book'){$book_active = 'active';}else{$book_active = '';}
?>

<!-- wrapper -->
<div class="wrapper">
    <div class="leftside">
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li class="title">Navigation</li>
                <li class="<?php echo $setup_active; ?> sub-nav">
                    <a href="javascript:;">
                        <i class="fa fa-home"></i> <span>Setup</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo base_url(); ?>publishers">Publishers</a></li>
                        <li><a href="<?php echo base_url(); ?>authors">Authors</a></li>
                        <li><a href="<?php echo base_url(); ?>departments">Departments</a></li>
                    </ul>
                </li>
                <li class="<?php echo $book_active; ?>">
                    <a href="<?php echo base_url(); ?>books">
                        <i class="fa fa-book"></i> <span>Books</span>
                    </a>
                </li>
            </ul>
         </div>
    </div>
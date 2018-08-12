<nav class="navbar-default navbar-static-top" role="navigation">
             <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <h1> <a class="navbar-brand" href="home.php">Hi Admin!</a></h1>         
			   </div>
			 <div class=" border-bottom">
        	<!-- <div class="full-left">
        	  <section class="full-top">
				<button id="toggle"><i class="fa fa-arrows-alt"></i></button>	
			</section>
			<form class=" navbar-left-right">
              <input type="text"  value="Search..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search...';}">
              <input type="submit" value="" class="fa fa-search">
            </form>
            <div class="clearfix"> </div>
           </div> -->
     
       
            <!-- Brand and toggle get grouped for better mobile display -->
		 
		   <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="drop-men" >
		        <ul class=" nav_1">
					<li class="dropdown">
		              <a href="#" class="dropdown-toggle dropdown-at" data-toggle="dropdown"><span class=" name-caret"><?php echo $_SESSION['user']?><i class="caret"></i></span></a>
		              <ul class="dropdown-menu " role="menu">
		                <li><a href="logout.php"><i class="fa fa-power-off"></i>Log Out</a></li>
		              </ul>
		            </li>
		           
		        </ul>
		     </div><!-- /.navbar-collapse -->
			<div class="clearfix">
       
        </div>
	  
		    <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
				
                    <!-- <li>
                        <a href="home.php" class=" hvr-bounce-to-right"><i class="fa fa-dashboard nav_icon "></i><span class="nav-label">Dashboards</span> </a>
                    </li> -->
					 <li>
                        <a href="add_quotation.php" class=" hvr-bounce-to-right"><i class="fa fa-plus nav_icon"></i><span class="nav-label">Add Quotation</span> </a>
                    </li>
					
					<li>
                        <a href="list_quotation.php" class=" hvr-bounce-to-right"><i class="fa fa-th-list nav_icon"> </i><span class="nav-label">Quotation List</span></a>
                        
                    </li>
                    <li>
                        <a href="#" class=" hvr-bounce-to-right"><i class="fa fa-users nav_icon"></i> <span class="nav-label">Customer</span></span><span class="fa arrow"></span> </a>
                        <ul class="nav nav-second-level">
                            <li><a href="add_customer.php" class=" hvr-bounce-to-right"> <i class="fa fa-user nav_icon"></i>Add New Customer</a></li>
                            <li><a href="list_customer.php" class=" hvr-bounce-to-right"><i class="fa fa-list-alt nav_icon"></i>View Customer</a></li>
                       </ul>
                    </li>
                    <li>
                        <a href="#" class=" hvr-bounce-to-right"><i class="fa fa-building nav_icon"></i> <span class="nav-label">Products</span></span><span class="fa arrow"></span> </a>
                        <ul class="nav nav-second-level">
                            <li><a href="add_product.php" class=" hvr-bounce-to-right"> <i class="fa fa-cog nav_icon"></i>Add New Product</a></li>
                            <li><a href="list_product.php" class=" hvr-bounce-to-right"><i class="fa fa-cogs nav_icon"></i>View Products</a></li>
                       </ul>
                    </li>
                </ul>
            </div>
			</div>
        </nav>
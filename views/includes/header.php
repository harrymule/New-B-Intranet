   <nav id="myNavbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="container">
            <div class="navbar-header logo_holder">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src ="views/images/logo.png"/></a>
            </div>
			<div class = "header_right_content">
				<div class = "country_flags"><img class = "flags first_flag" src = "views/images/kenya_flag.png"/>
											 <img class = "flags" src = "views/images/Tanzania_flag.png"/>
											 <img class = "flags" src = "views/images/south-sudan_flag.png"/>
											 <img class = "flags" src = "views/images/Uganda_flag.png"/>
											 <img class = "flags" src = "views/images/Mozambique_flag.png"/>
											 <img class = "flags" src = "views/images/Rwanda_flag.png"/>
											 <img class = "flags last_flag" src = "views/images/Malawi_flag.png"/>
				</div>
				<div class = "search">
					  <form class="navbar-form" role="search">
						<div class="input-group add-on">
						  <input type="text" class="form-control" placeholder="Search this site" name="srch-term" id="srch-term">
						  <div class="input-group-btn">
							<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
						  </div>
						</div>
					  </form>
				</div>
			</div>
<?php include('views/includes/nav.php'); ?>
        </div>
    </nav>
<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li><a href="<?php echo site_url(); ?>">Home</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Search Events<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/search/city">By City</a></li>
							<li><a href="/search/state">By State</a></li>
							<li><a href="/search/zip">By Zip Code</a></li>
							<li><a href="/search/tag">By Tag</a></li>
							<li><a href="/search/date">By Date</a></li>
							<li><a href="/search/more">More Options</a></li>
						</ul>
					</li>
					<?php
					if(!$this->session->userdata('logged_in')){
					?>
						<li><a href="/account/register">Register</a></li>
						<li><a href="/account/login">Login</a></li>
					<?php
					}else{
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Event Management<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/account/addevent">Add Event</a></li>
							<li><a href="/account/listevents">Edit Existing Event</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Account<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/account/editprofile">Edit Profile</a></li>
							<li><a href="/account/logout">Logout</a></li>
						</ul>
					</li>
					<?php
					}
					?>
					<li><a href="/about/contact">Contact</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
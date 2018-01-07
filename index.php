<?php require('header.php') ?>

<div class="container " lang="en" ng-controller="animateCtrl">
	<div class="row  align-items-center">
		<div class="row"  >
			<img src="">
		</div>
		<div id="div1" class="row firstrow">	
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
				<form id="LoginForm" class="form-group" action="login.php" method="post">
					<label name="Login">Login</label>
					<input name="Login"type="text" placeholder="Login" class="form-control elemWidth">
					<label name="Pass">Password</label>
					<input name="Pass" type="text" placeholder="Password" class="form-control elemWidth">
					<br>
					<button type="submit" class="btn btn-default">Log in</button>				
				</form>

				<br><br>
				<button class="btn btn-default" ng-click="signupClicked()">Sign up</button>
				<br><br>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6" uib-collapse="signupState">
				<form id="RegisterForm" class="form-group" action="register.php" method="post" > 
					<label name="UserName">Username</label>
					<input type="text" name="UserName" placeholder="User Name" class="form-control elemWidth">					
					<label name="Password">Password</label>
					<input type="text" name="Password" placeholder="Password" class="form-control non-empty elemWidth">
					<label name="PasswordConfirm">Password Confirm</label>
					<input type="text" name="PasswordConfirm" placeholder="Confirm Password" class="form-control non-empty elemWidth">
					<label name="Email">E-mail</label>
					<input type="text" name="Email" placeholder="Email@email.com" class="form-control non-empty elemWidth">		
					<br>					
					<button id="registerbtn" type="submit" class="btn btn-default">Register</button>
					
				</form>
				<button class="btn btn-default" ng-click="signupClicked()">Close registration form</button>		
				
			</div>
		</div>
		<div id="div2" class="row firstrow" hidden>	
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<form id="PostForm" class="form-group" action="post.php" method="post" > 
					<label name="Logged" id="Logged" >Hello</label>
					<label style="margin-left: 5px;" id="UserLogged" ng-model="toPost.UserName"></label>
					<textarea name="toPost" id="toPost" class="form-control" rows="3" type="text" ng-model="toPost.Recall_text"></textarea>
					<button type="submit" class="btn btn-default" ng-click="addPost()">Post</button>
				</form>
				<button id="Logoutbtn" class="btn btn-default pull-right" action="logout.php" method="post">Log out</button>		
				
			</div>
		</div>

		<div class="row" >	
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<div class="container-fluid">
					<div class="col-md-12">
						<div class="row">
							<h1>Latest recalls:</h1>
						</div>
						<div class="row" ng-repeat="recall in recalls track by $index">
							
							<div class="timeline timeline-line-dotted">
								<span class="timeline-label">
									<span class="label label-primary">{{recall.UserName}}</span>
								</span>
								<div class="timeline-item">
									<div class="timeline-point timeline-point-success">
										<i class="fa fa-money"></i>
									</div>
									<div class="timeline-event">
										<!--<div class="timeline-heading">
											<h4>Recall theme</h4>
										</div> -->
										<div class="timeline-body bg_textbox">
											<p>{{recall.Recall_text}}</p>
										</div>
										<div class="timeline-footer">
											<p class="text-right">{{recall.Time}}</p>
										</div>
									</div>
								</div>		
							</div>
						</div>
					</div>
				</div>										
			</div>
		</div>	
	</div>
</div>	

<?php require('footer.php') ?>
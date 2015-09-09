
	     <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Authentification</div>
                     <!--   <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Besoin d'aide ?</a></div> -->
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form action="" method="POST"  class="form-signin" role="form">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input maxlength=30 autocomplete="off" id="login-username" type="text" class="form-control" name="login" value="" placeholder="nom d'utilisateur / login">                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="password" placeholder="mot de passe / password">
                                    </div>                                    

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">                                      
                                      <p><input type="submit" class="btn btn-success" value="Se connecter" /></p>
                                    </div>
                                </div>
  
                            </form>     
	<?php if($this->sError!=''):?>
		<p style="color:red"><?php echo $this->sError ?></p>
	<?php endif;




                     


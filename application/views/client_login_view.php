<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login to Our Website</title>
<meta name="description" content="" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/landing.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/style.css"/>
<script>
	
jQuery(function($){
		   
	// simple jQuery validation script
	$('#login').submit(function(){
		
		var valid = true;
		var errormsg = 'This field is required!';
		var errorcn = 'error';
		
		$('.' + errorcn, this).remove();			
		
		$('.required', this).each(function(){
			var parent = $(this).parent();
			if( $(this).val() == '' ){
				var msg = $(this).attr('title');
				msg = (msg != '') ? msg : errormsg;
				$('<span class="'+ errorcn +'">'+ msg +'</span>')
					.appendTo(parent)
					.fadeIn('fast')
					.click(function(){ $(this).remove(); })
				valid = false;
			};
		});
		
		return valid;
	});
	
})	



</script>
<style>

/* HTML elements  */		

	h1, h2, h3, h4, h5, h6{
		font-weight:normal;
		margin:0;
		line-height:1.1em;
		color:#000;
		}	
	h1{font-size:2em;margin-bottom:.5em;}	
	h2{font-size:1.75em;margin-bottom:.5142em;padding-top:.2em;}	
	h3{font-size:1.5em;margin-bottom:.7em;padding-top:.3em;}
	h4{font-size:1.25em;margin-bottom:.6em;}
	h5,h6{font-size:1em;margin-bottom:.5em;font-weight:bold;}
	
	p, blockquote, ul, ol, dl, form, table, pre{line-height:inherit;margin:0 0 1.5em 0;}
	ul, ol, dl{padding:0;}
	ul ul, ul ol, ol ol, ol ul, dd{margin:0;}
	li{margin:0 0 0 2em;padding:0;display:list-item;list-style-position:outside;}	
	blockquote, dd{padding:0 0 0 2em;}
	pre, code, samp, kbd, var{font:100% mono-space,monospace;}
	pre{overflow:auto;}
	abbr, acronym{
		text-transform:uppercase;
		border-bottom:1px dotted #000;
		letter-spacing:1px;
		}
	abbr[title], acronym[title]{cursor:help;}
	small{font-size:.9em;}
	sup, sub{font-size:.8em;}
	em, cite, q{font-style:italic;}
	img{border:none;}			
	hr{display:none;}	
	table{width:100%;border-collapse:collapse;}
	th,caption{text-align:left;}
	form div{margin:.5em 0;clear:both;}
	label{display:block;}
	fieldset{margin:0;padding:0;border:none;}
	legend{font-weight:bold;}
	input[type="radio"],input[type="checkbox"], .radio, .checkbox{margin:0 .25em 0 0;}

/* //  HTML elements */	

/* base */

body, table, input, textarea, select, li, button{
	font:1em "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	line-height:1.5em;
	color:#444;
	}	
body{
    background: url("<?php echo base_url(); ?>images/bg-arrow.png") no-repeat scroll center bottom #c7e1f2;
    overflow-x: hidden;
	font-size:12px;
	/* background:#c4f0f1;		 */
	text-align:center;
	}		

/* // base */
.register {
width: 500px;
margin: 2px auto;
text-align: right;
}
/* login form */	

#login{
	margin:5em auto 1em;
	background:#fff;
	border:8px solid #eee;
	width:500px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
	-moz-box-shadow:0 0 10px #4e707c;
	-webkit-box-shadow:0 0 10px #4e707c;
	box-shadow:0 0 10px #4e707c;
	text-align:left;
	position:relative;
	}
#login a, #login a:visited{color:#0283b2;}
#login a:hover{color:#111;}
#login h1{
	background:#0092c8;
	color:#fff;
	text-shadow:#007dab 0 1px 0;
	font-size:14px;
	padding:18px 23px;
	margin:0 0 1.5em 0;
	border-bottom:1px solid #007dab;
	}
#login .register{
	position:absolute;
	float:left;
	margin:0;
	line-height:30px;
	top:-40px;
	right:0;
	font-size:11px;
	}
#login p{margin:.5em 25px;}
#login div{
	margin:.5em 25px;
	background:#eee;
	padding:4px;
	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;
	text-align:right;
	position:relative;
	}	
#login label{
	float:left;
	line-height:30px;
	padding-left:10px;
	}
#login .field{
	border:1px solid #ccc;
	width:280px;
	font-size:12px;
	line-height:1em;
	padding:4px;
	-moz-box-shadow:inset 0 0 5px #ccc;
	-webkit-box-shadow:inset 0 0 5px #ccc;
	box-shadow:inset 0 0 5px #ccc;
	}	
#login div.submit{background:none;margin:1em 25px;text-align:center;}	
#login div.submit label{float:none;display:inline;font-size:11px;}	
#login button{
	border:0;
	padding:0 30px;
	height:30px;
	line-height:30px;
	text-align:center;
	font-size:12px;
	color:#fff;
	text-shadow:#007dab 0 1px 0;
	background:#0092c8;
	-moz-border-radius:50px;
	-webkit-border-radius:50px;
	border-radius:50px;
	cursor:pointer;
	}
	
#login .forgot{text-align:right;font-size:11px;}
#login .back{padding:1em 0;border-top:1px solid #eee;text-align:right;font-size:11px;}
#login .error{
	float:left;
	position:absolute;
	left:95%;
	top:-5px;
	background:#890000;
	padding:5px 10px;	
	font-size:11px;
	color:#fff;
	text-shadow:#500 0 1px 0;
	text-align:left;
	white-space:nowrap;
	border:1px solid #500;
	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;
	-moz-box-shadow:0 0 5px #700;
	-webkit-box-shadow:0 0 5px #700;
	box-shadow:0 0 5px #700;
	}


/* //  login form */	
		
</style>


</head>
<body>
    <div id ="header">
        <div class="wrapperMain">
            <!--header-->
            <?php $this->load->view('global/header.php'); ?>
            <!--/header-->
        </div>
    </div>


<h1>Login here</h1>
<form id="login" method="post" action="<?php echo base_url();?>login"> 

    <h1>Log in to your <strong>EasyAccessProfits.com</strong> account!</h1>
	
	<font style="font-size:12px;color:red;text-align:center;">
		<?php echo form_error('password'); ?>
	</font>	
	
    <div>
    	<label for="login_username">Username</label> 
    	<input type="text" name="username" id="login_username" class="field required" title="Please provide your username" />
    </div>			

    <div>
    	<label for="login_password">Password</label>
    	<input type="password" name="password" id="login_password" class="field required" title="Password is required" />
    </div>			
    
    <!--<p class="forgot"><a href="#">Forgot your password?</a></p>-->
    			
    <div class="submit">
        <button name="client_login" type="submit">Log in</button>   
        
        <!--<label>
        	<input type="checkbox" name="remember" id="login_remember" value="yes" />
            Remember my login on this computer
        </label>   -->
    </div>
    
    
  
</form>	
    <p class="register">No account? <a href="<?php echo base_url(); ?>createaccount">Create your account here!</a></p>
    <p class="register">Forget password? <a href="<?php echo base_url(); ?>createaccount">Click here to contact support!</a></p>

</body>
</html>

<?php 
$session_data = $this->session->userdata('client_login');
$session_menu = $this->session->userdata('menu_data_in_session');
// echo '<pre>';
// print_r($session_data);
// echo '</pre>';
// foreach($session_menu as $key=>$value){
	// echo '<br/>'.$session_menu[$key]->menu_url;		
	// echo $key;		
// } 
// $data['fullname']=$session_data['user_track_id'];
if (array_key_exists('sponser_full_name', $session_data)) {
    $sponser=$session_data['sponser_full_name'];
}else{
    $sponser='No Sponser';
}

?>
<html>
    <head>
        <title>::-<?php if(isset($metatitle)){ echo $metatitle; }else { echo 'allMoney';}?>-::</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/style.css">
		<script src="<?php echo base_url()?>scripts/jquery-1.7.2.min.js" type="text/javascript"></script>
		<?php if(isset($stylelist)):
            foreach ($stylelist as $style):?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().$style; ?>">
			<?php endforeach;
        endif; 
        if(isset($scriptlist)): 
            foreach ($scriptlist as $script):?>
        <script src="<?php echo base_url().$script; ?>" type="text/javascript"></script>
        <?php endforeach;
        endif; ?>
		<script type="text/javascript">
			setTimeout(function() { 
				$('.infomessage').fadeOut('fast');
			} , 1750);
			
		</script>
                <style>
.sponsor {
padding-left: 15px;
color: #333333;
float: right;
margin: 5px 0px;
width: 242px;
border: 1px solid;
padding: 5px 5px;
border-radius: 5px;
font-size: 12px;
}
nav.maniNav {
font: 12px Arial,Helvetica,sans-serif;
margin-bottom: 30px;
height: auto;
overflow: hidden;
margin-top: 3px;
width: 620px;
float: left;
}
nav.maniNav ul li {
display: block;
line-height: normal;
width: 155px;
text-align: center;
margin: 0;
padding: 0;
float: left;
background: url(../images/navBg.png) repeat-x left top;
padding-top: 2px;
}
                </style>
    </head>
<body>
<!-- Code of contact support pop-up hidden inline form -->

<script src="<?php echo base_url()?>scripts/fancybox/jquery.fancybox.js?v=2.0.6" type="text/javascript"></script>
<script src="<?php echo base_url()?>scripts/popup/popup.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>scripts/fancybox/jquery.fancybox.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/popup/popup.css">
				
<div id="inline">
	<form id="contact" name="contact" action="#" method="post">
		<fieldset id="support">
		<legend id="support">Please complete the following form</legend>

		<label for="email"><span class="required">*</span> Email</label>
		<input name="email" type="email" id="email" class="txt" />

		<br />
		<label for="comments"><span class="required">*</span> Your comments</label>
		<textarea name="msg" id="msg"></textarea>
		
		<button id="send" class="button">Send E-mail</button>
		</fieldset>
	</form>
</div>
<input type="hidden" id="baseurl_head" value="<?php echo base_url();?>">

<!-- End of Code of contact support pop-up hidden inline form -->

<div id="wrapper">
	<div class="siteHeaderBg">
        <div class="wrapperOuter">
             <div class="wrapperMain">
					<!--header-->
						<div class="siteHeader">
							<!-- logo -->
							<div class="logo">
								<h3><a href="<?php if (($session_data['login_state'] == 'active' && $session_data['role'] == 'user')){ echo base_url().'members/programs'; }else{ echo base_url(); } ?>">Logo</a></h3>
							</div>
							<!-- /logo -->
							<!-- header right -->
							<div class="siteHeaderRight">
								
								 <nav class="headertop">
                                                                     <div class="links"><ul><li><a href="#">Welcome <b><?php echo $session_data['fullname']; ?></b></a></li>
									
										<li><a href="<?php echo base_url()?>members/setting">Tools</a></li>
										<li><a href="<?php echo base_url()?>members/clientdashboard/logout">Logout</a></li>
										<li><a  class="last modalbox" href="#inline">Contact Support</a></li>
									</ul></div>
								 </nav>
							</div>
							<!-- /header right -->
						</div>
						<!--/header-->
			 </div>
            <!-- container -->
            <div id="container">
            	<div class="wrapperMain containermain">
					<div id="navigation">
					<nav class="maniNav">
						<ul>
							<?php
								$total=count($session_menu);
								$menu_count=0;
								$current_url=uri_string();

								foreach($session_menu as $key=>$value){
									++$menu_count;
									
									/****** Code start to show Active menu*******/
										if($session_menu[$key]->menu_url==$current_url){
											$class='class="active"';
										}else{
											$class='class=""';	
										}
									/****** End of Code to show Active menu*******/
									
								?>	
									<li><a <?php echo $class; ?> id="menu_<?php echo $key; ?>" <?php if($menu_count==$total){ echo 'class="last"'; } ?> href="<?php echo base_url().$session_menu[$key]->menu_url; ?>"><?php echo  $session_menu[$key]->menu_title; ?></a></li>
								<?php
								} 
							?>
							<!--<li><a href="<?php echo base_url(); ?>members/clientdashboard">Dashboard</a></li>
							<li><a href="#" >Commissions</a></li>
							<li><a href="<?php echo base_url(); ?>members/training">Marketing Videos</a></li>
							<li>
								<a class="last" href="<?php echo base_url(); ?>members/programs">p</a>
							</li>-->
							
							
						</ul>
					</nav>
								<div class="sponsor">
									<span id="sponsor">Your Sponsor :<br/>  <a href="#"><?php echo $sponser; ?></a></span>
									<br/>
									<span>Your Affiliate Id : </span><br/><a href="<?php echo base_url()?>go/<?php echo $session_data['user_track_id'];?>" target="_blank">
                                                                            <?php echo base_url()?>go/<?php echo $session_data['user_track_id'];?>
                                                                        </a>
								 </div>
                                        </div>
					
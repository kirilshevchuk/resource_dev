<?php if (isset($status) && $status=="success"){?>
			<div class="infomessage"><?php echo "Successfully"?> </div>
<?php } 

/**************** code to fetch next step data **************/
$video_data=array();

foreach($video_query->result() as $singlevideo ){	
	if($singlevideo->type=='next_video'){
		$video_data[$singlevideo->type.'_'.$singlevideo->menu_id]=$singlevideo;
	}else{
		$video_data[$singlevideo->type]=$singlevideo; 
	}
}
		// echo '<pre>';
		// print_r($video_data);
		// echo '</pre>';
		
/**************** End of code to fetch next step data **************/
	

?>


<div class="video_title">Welcome User</div>	
	<div class="webleft">
			<div class="leftnav">
				<ul>
					<?php foreach($query->result() as $category ){ ?>
						<li onclick="load_train_data(<?php echo $category->id; ?>);">
							<a id="ctab_<?php echo $category->id; ?>" class="cat_tabs" value="<?php echo $category->category_name; ?>" href="#" ><?php echo $category->category_name; ?></a>
							<input type="hidden" id="title_<?php echo $category->id; ?>" value="<?php echo $category->category_name; ?>" >
						</li>
					<?php } ?>
					<!-- Next Tab Li code start here -->
						<?php if($video_data['next_video_'.$tab_menu_id]->is_show=='Y'){ ?>
						<li onclick="load_next_step(<?php echo $tab_menu_id; ?>);">
							<a id="next_tab_title" class="cat_tabs" href="#"><?php echo $video_data['next_video_'.$tab_menu_id]->tab_title;  ?></a>
							<input type="hidden" id="next_video_title" value="<?php echo $video_data['next_video_'.$tab_menu_id]->file_name; ?>" >
							<input type="hidden" id="next_video" value="<?php echo $video_data['next_video_'.$tab_menu_id]->file_name_in_folder; ?>" >
						</li>
					<!-- End of Next Tab Li code start here -->
					<?php } ?>
				</ul>
			</div>
	</div>
	<div class="webright">
		<?php 
                if($query->num_rows>0):
			$first_cat = $query->row();
		?>

		<input type="hidden" id="firstCategory" value="<?php echo $first_cat->id;?>">
				
		<div id="ma">
		
		
		</div>
                <?php else: ?>
                <div id="ma"></div>
                <input type="hidden" id="firstCategory" value="">
		<?php endif; ?>
                        <input type="hidden" id="baseurl" value="<?php echo base_url();?>">
                        <input type="hidden" id="id_videopreview" value="default.mp4">
                        <input type="hidden" id="tab_menu_id" value="<?php echo $tab_menu_id; ?>">
				
	</div>
</div>
<!-- /wrapperMain -->

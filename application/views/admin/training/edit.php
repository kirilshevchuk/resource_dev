<div style="display:none" id="infomessage">
	<div style="margin-bottom: 10px;">Are you sure to delete?</div>
	<a href="" id="del_yes">
		<div class="yes">
			Yes
		</div>
	</a>
	<div class="no" onclick="no_del();">
		No
	</div>
</div>
    
<script src="<?php echo base_url(); ?>scripts/marketing.js" type="text/javascript"></script>
<style>
    #upload , #youtube{
        cursor: pointer;
        text-decoration: underline;
    }
    .selected_src{
        text-decoration: none !important;
        cursor: default !important;
    }
    #youtube_link{
        display: none;
    }
</style>
    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title">Edit Training</h1>
        </div>
        
		<ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>admin/dashboard">Home</a> <span class="divider">/</span></li>
            <li class="active"><a href="<?php echo base_url(); ?>admin/training">Training</a> <span class="divider">/</span> Edit Training</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
     <!--<a href="<?php echo base_url();?>admin/videos/addvideo" ><button class="btn btn-primary" id="btn_addnewproduct"><i class="icon-plus"></i>Edit Login Video</button></a>-->
  <div class="btn-group">
  </div>
</div>
<div class="well">
<?php
//$marketing = $query->result();

//echo '<pre>';
	//var_dump($marketing[0]);
?>
<?php if(isset($errors)){//Display form errors.
     foreach ($errors as $error){
         echo $error;
     }
}
$training = $trainingdata->first_row();
//Video adding form.
echo validation_errors(); 
 echo form_open("admin/training/edit/$training->id");?>
    <div id="left_form_part">
	<div class="field">
		<label for="title">Title</label> 
		<input id="title" value="<?php echo $training->title; ?>" name="title" size="50" type="text" class="medium" />
	</div>
	<div class="field">
		<label for="link">Link</label> 
		<input id="link" value="<?php echo $training->link; ?>" name="link" size="50" type="text" class="medium" />
	</div>
	<div class="field">
		<label for="category">Category</label> 
                <select id="category" name="category" class="medium" >
                    <?php foreach ($categories->result() as $category):?>
                    <option value="<?php echo $category->id; ?>" <?php if($training->cid==$category->id) echo 'selected'?> >
                        <?php echo $category->category_name; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
	</div>
	<div class="field">
		<label for="type">Type</label> 
                <select id="type" name="type" class="medium" >
                    <?php foreach ($types->result() as $type):?>
                    <option value="<?php echo $type->id; ?>" <?php if($training->tid==$type->id) echo 'selected'?> >
                        <?php echo $type->type_name; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
	</div>
	<div class="field">
		<label for="status">Status</label> 
                <select id="status" name="status" class="medium" >
                    <?php foreach ($statuses->result() as $status):?>
                    <option value="<?php echo $status->id; ?>" <?php if($training->sid==$status->id) echo 'selected'?> >
                        <?php echo $status->status; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
	</div>
    </div>
    <textarea id="training_text" class="ckeditor" name="training_text" rows="10" cols="50" >
        <?php if(!empty($training->t_text)){echo $training->t_text;} ?>
    </textarea><!--class="ckeditor" -->

	<input id="edit_training" name="edit_training" type="submit" class="btn" value="Save"/>
<?php echo form_close();
if(!empty($training->video)):?>
        <div class="video_preveiw" style="">
            <script type="text/javascript">jwplayer.key="oIXlz+hRP0qSv+XIbJSMMpcuNxyeLbTpKF6hmA==";</script>
            <div id="videopreview">Loading the player...</div>
        </div>
        <?php if(preg_match("/youtube\.com/", $training->video)): ?>
        <input type="hidden" id="baseurl" value="">
        <input type="hidden" id="video_file_path" value="">
        <?php else: ?>
        <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
        <input type="hidden" id="video_file_path" value="uploads/training/video/">
        <?php endif; ?>
        <input type="hidden" id="id_videopreview" value="<?php echo $training->video; ?>">
    <?php 
    /*if(preg_match("/youtube\.com/", $training->video)):
        $video_str = substr($training->video,-11);
    ?>
        <!--<iframe width="560" height="315" 
                src="http://www.youtube.com/embed/<?php echo $video_str; ?>" 
                frameborder="0" allowfullscreen>
        </iframe>
    <?php
    else: ?>
         <video id="register_page_vieo" class="video-js vjs-default-skin"
               controls preload="auto" width="480" height="360">
            <source src="<?php echo base_url(); ?>uploads/training/video/<?php echo $training->video; ?>" type='video/mp4' />
        </video>
    <?php
    endif;//*/
?>
        <a href="<?php echo base_url(); ?>admin/training/editvideo/<?php echo $training->id;  ?>">Change Video File </a>
        <?php else: 
$addvideo = array(
    'id'=>'add_video',
    'name'=>'add_video',
    'class'=>'btn',
    'value'=>'Add Video'
);
echo form_open("admin/training/addvideo/$training->id");
echo form_submit($addvideo);
echo form_close();
        endif;/*
        if(!empty($training->t_text)):
?>
        <div>
            <!--<textarea id="training_text" name="training_text" rows="10" cols="50" disabled ><?php //echo $training->t_text; ?></textarea>-->
            <div id="training_text_view">
                <h4>Training Text</h4>
                <?php echo $training->t_text; ?>
                <a href="<?php echo base_url(); ?>admin/training/edittext/<?php echo $training->id; ?>">Edit Text </a>
            </div>
            
        </div>
<?php
else:
$addtext = array(
    'id'=>'add_text',
    'name'=>'add_tr_text',
    'class'=>'btn',
    'value'=>'Add Text'
);
echo form_open("admin/training/addtext/$training->id");
echo form_submit($addtext);
echo form_close();
endif; //*/
?>

</div>
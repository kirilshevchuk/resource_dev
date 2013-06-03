<?php if (isset($status) && $status=="success"){?>
			<div class="infomessage"><?php echo "Successfully"?> </div>
<?php } ?>

<style>
.m_t_tab-close {
    background: none repeat scroll 0 0 #245679;
    color: #FFFFFF;
    font-size: 20px;
    padding: 14px;
}
.tab_close {
    cursor: pointer;
    margin-top: 15px;
}

.show-tab-content {
    background: none repeat scroll 0 0 #FFFFFF;
    color: #000000;
    min-height: 100px;
    padding: 15px 7px 10px 14px;
    width: 97%;
}

</style>

	<div class="webleft">
			<div class="leftnav">
				<ul>
					<li><a href="#" class="active">E.A.P Training</a></li>
					<li><a href="#">System Training-2</a></li>
					<li><a href="#">Training -3 </a></li>
					<li><a href="#">Training -4</a></li>
				</ul>
			</div>
	</div>
	<div class="webright">
<script>
	$(document).ready(function() {
		$('div.main_tab').click(function(){
			//if div is allready open
			if($(this).find('.tab_child_2').css('display')=='block'){
				if($(this).find('.open_close').hasClass('open_tab')){
					$(this).find('.open_close').removeClass('open_tab').addClass('close_tab');
				}else{
					$(this).find('.open_close').removeClass('close_tab').addClass('open_tab');
				}
				$(this).find('.tab_child_2').slideToggle("slow");
				return false;
			}
			//if div is Not open
			$('.tab_child_2').slideUp('500');
			if($(this).find('.open_close').hasClass('open_tab')){
				$(this).find('.open_close').removeClass('open_tab').addClass('close_tab');
			}else{
				$(this).find('.open_close').removeClass('close_tab').addClass('open_tab');
			}
			
			$(this).find('.tab_child_2').slideToggle("slow");
		})

	})
	
</script>
		<div class="main_tab" >
			<div class="m_t_tab-close tab_close tab_child_1">Marketing 101
				<img  src="<?php echo base_url();?>images/transparent.gif" class="open_close open_tab" width="36" height="29">
			</div>
			<div class="show-tab-content tab_child_2" style="display: none;">
					<p>Get On Our Daily .Think and Grow Rich. Call Every Monday-Friday
				<br>
				<br>Keep in mind on this call we don.t mention company names, or products during the mastermind.  It.s 100% focused on Mindset and Personal Development!
				<br>
				<br>The live call is at 9am EST Monday-Friday: 712-432-0900 . Access Code: 565762#
				<br>
				<br>Here is the Replay number (different call in number then the live one) if you missed it today:
				<br> 
				<br>Replay Number: 712-432-0990 Access Code: 565762# (Usually up for 23 hours)
				<br>
				<br>...
				<br>
				<br>You will also want to fill your mind full of good books for at least 30 minutes per day!   
				<br>
				<br>Here is some good ones:
				<br>
				<br>Mike Hobbs Top 3 Book List:
				<br> 
				<br>1. Napoleon Hill: "Think &amp; Grow Rich" (wealth principles)
				<br>2. Noah St. John: "The Secret Code Of Success" (get your foot off the break)
				<br>3. Dale Carnegie: "How To Win Friends and Influence People" (people are your product)
				<br>
				<br>Other recommended Books:
				<br>
				<br>4. Og Mandino: "University of Success" (any book by Mandino is AWESOME)
				<br>5. Paul Zane Pilzer: "God Wants You To Be Rich" (awesome book!)
				<br>6. Charles Haanel: "The Master Key System"
				<br>7. Robert Kiyosaki: "The Cash Flow Quadrant" &amp; "Rich Dad, Poor Dad"
				<br>8. James Allen: "As a Man Thinketh"
				<br>9. Wallace Wattles: "The Science of Getting Rich"
				<br>10. Timothy Ferris: "The 4 Hour Work Week"
				<br>11. Napoleon Hill: "The Law of Success"
				<br>12. Dr. Thomas Murphy: "The Power of Your Subconscious Mind"
				<br>
				<br>Bonus:  Go to Dashboard. Click Step 2. Plug Into Empower Network.
				<br>
				<br>They have hundreds of hours of Inner Circle audio trainings you can download to your phone or mp3 player and listen to while in the car, taking a shower or working out!
				<br><br>
				<br>It.s important to fill your mind with positive energy as much as you can throughout the day!
				</p>
			</div>
		</div>
		
		<div class="main_tab">
			<div class="m_t_tab-close tab_close tab_child_1">Marketing 101
				<img  src="<?php echo base_url();?>images/transparent.gif" class="open_close open_tab" width="36" height="29">
			</div>
			<div class="show-tab-content tab_child_2" style="display: none;">
					<p>Get On Our Daily .Think and Grow Rich. Call Every Monday-Friday
				<br>
				<br>Keep in mind on this call we don.t mention company names, or products during the mastermind.  It.s 100% focused on Mindset and Personal Development!
				<br>
				<br>The live call is at 9am EST Monday-Friday: 712-432-0900 . Access Code: 565762#
				<br>
				<br>Here is the Replay number (different call in number then the live one) if you missed it today:
				<br> 
				<br>Replay Number: 712-432-0990 Access Code: 565762# (Usually up for 23 hours)
				<br>
				<br>...
				<br>
				<br>You will also want to fill your mind full of good books for at least 30 minutes per day!   
				<br>
				<br>Here is some good ones:
				<br>
				<br>Mike Hobbs Top 3 Book List:
				<br> 
				<br>1. Napoleon Hill: "Think &amp; Grow Rich" (wealth principles)
				<br>2. Noah St. John: "The Secret Code Of Success" (get your foot off the break)
				<br>3. Dale Carnegie: "How To Win Friends and Influence People" (people are your product)
				<br>
				<br>Other recommended Books:
				<br>
				<br>4. Og Mandino: "University of Success" (any book by Mandino is AWESOME)
				<br>5. Paul Zane Pilzer: "God Wants You To Be Rich" (awesome book!)
				<br>6. Charles Haanel: "The Master Key System"
				<br>7. Robert Kiyosaki: "The Cash Flow Quadrant" &amp; "Rich Dad, Poor Dad"
				<br>8. James Allen: "As a Man Thinketh"
				<br>9. Wallace Wattles: "The Science of Getting Rich"
				<br>10. Timothy Ferris: "The 4 Hour Work Week"
				<br>11. Napoleon Hill: "The Law of Success"
				<br>12. Dr. Thomas Murphy: "The Power of Your Subconscious Mind"
				<br>
				<br>Bonus:  Go to Dashboard. Click Step 2. Plug Into Empower Network.
				<br>
				<br>They have hundreds of hours of Inner Circle audio trainings you can download to your phone or mp3 player and listen to while in the car, taking a shower or working out!
				<br><br>
				<br>It.s important to fill your mind with positive energy as much as you can throughout the day!
				</p>
			</div>
		</div>
		<div class="main_tab">
			<div class="m_t_tab-close tab_close tab_child_1">Marketing 101
				<img  src="<?php echo base_url();?>images/transparent.gif" class="open_close open_tab" width="36" height="29">
			</div>
		</div>
		<div class="main_tab">
			<div class="m_t_tab-close tab_close tab_child_1">Marketing 101
				<img  src="<?php echo base_url();?>images/transparent.gif" class="open_close open_tab" width="36" height="29">
			</div>
		</div>
				
	</div>
</div>
<!-- /wrapperMain -->

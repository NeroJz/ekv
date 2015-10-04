<div class="row-fluid">
	<div class="span12">
		<?=display_dateline_warning();?>
		<?=display_tarikh_pengesahan();?>
		<!--accordian pengumuman-->
		<div class="accordion" id="accordion_pengumuman">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_pengumuman" href="#collapseOne"> Pengumuman </a>
				</div>
				<div id="collapseOne" class="accordion-body in collapse" style="height: 100px;">
					<div class="accordion-inner" style="height: 100px;">
						<!--table pengumuman-->
						<div class="media">
							<a class="pull-left" href="#"> <img class="media-object" data-src="holder.js/64x64"> </a>
								<div class="ticker4">
									<div class="mticker-news">
          								<ul>
          				<?php 
          				if(empty($data)){
          					echo "Tiada pengumuman terkini.";
						}else{
						           
          					foreach ($data as $key) { 
          					    ?>
            							
            								<li>
												<h4 class="media-heading"><?echo $key['ann_title'];?></h4>
												<?echo $key['ann_content'];?>
												<?
												if(!empty($key['ann_footer']))
												 echo $key['ann_footer'];?>
											</li>
						<?php }} ?>
										</ul>
									</div>
								</div>
						</div>
						<!--end of table pengumuman-->
					</div>
				</div>
			</div>
		</div>
		<!--end of accordian pengumuman-->

		<!--accordian report 1-->
		<div class="accordion" id="accordion_report1">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_report1" href="#collapseReportOne"> Dashboard </a>
				</div>
				<div id="collapseReportOne" class="accordion-body in collapse" style="height: auto;">
					<div class="accordion-inner" id="panelReportStudent">
						<!--panel untuk display report student-->
					</div>
				</div>
			</div>
			<!--end of accordian report 1-->
		</div>
	</div>

	<script src="<?=base_url()?>assets/js/highcharts.js" type="text/javascript"></script>
	<script src="<?=base_url()?>assets/js/exporting.js" type="text/javascript"></script>
	<script src="<?=base_url()?>assets/js/themes/grid.js" type="text/javascript"></script>
		<script src="<?=base_url()?>assets/js/dashboard.js" type="text/javascript"></script>
		
	
	<script src="<?=base_url()?>assets/js/ticker/jquery.modern-ticker.min.js" type="text/javascript"></script>
	<script type="text/javascript">$(function (){$(".ticker1").modernTicker({effect: "scroll",scrollInterval: 20,transitionTime: 500,autoplay: true});$(".ticker2").modernTicker({effect: "fade",displayTime: 4000,transitionTime: 300,autoplay: true});$(".ticker3").modernTicker({effect: "type",typeInterval: 10,displayTime: 4000,transitionTime: 300,autoplay: true});$(".ticker4").modernTicker({effect: "slide",slideDistance: 100,displayTime: 4000,transitionTime: 350,autoplay: true});});</script>
	
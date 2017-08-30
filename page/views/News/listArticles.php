<div class="wrap mt-50">

	<?php if($this->page->headingImage->FileName) { ?>
		
		<div class="list-header" style="background: url('/media/pages/large_<?=$this->page->headingImage->FileName?>')">
			<div class="container">
				<div class="row">
					<div class="col-xs-6">
						<h1 class="title distorted">
							<?=$this->page->name?>
							<span><?=$this->page->heading?></span>
						</h1>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="container">
		
		<div class="row">

			<div class="col-xs-12">
				<h2 class="title mt-0">Arhiva novosti <span>Pronađi vijest koja te zanima</span></h2>
				<!-- <ul class="nav-secondary">
					<?=$nav?>
				</ul> -->
			</div>

			<div class="col-xs-12 content">

				<div class="row gut-25 pflex mb50">
					<?php 
						$i = 0;
						foreach ($places as $row) {  
						if($i < 3){
							$b = "4";
							$s = "large_";
						} else {
							$b = "3";
							$s = "medium_";
						}
						$i++;
					?>
						
						<div class="col-xs-12 col-sm-<?=$b?>">
						
							<a class="article" href="<?=$row["PagesLink"]?>/<?=$row["link"]?>">

								<div class="image-con" style="background-image:url('/media/news/<?=$s?><?=$row["FileName"]?>')">
									<div class="datum"><?=date("d.m.Y", strtotime($row['datum_od']) )?></div>
								</div>

								<h4 class="title"><?=$row["naslov"]?></h4>
								<p><?=$row["heading"]?></p>
								
							</a>

						</div>
					<?php } ?>
				</div>

			</div>
		</div>
		
	</div>
</div>
<div class="wrap">

	<?php if($this->page->headingImage->FileName) { ?>
		
		<div class="list-header hidden-xs" style="background: url('/media/pages/large_<?=$this->page->headingImage->FileName?>')">
			<div class="container">
				<div class="row">
					<div class="col-xs-6">
						<h1 class="title distorted">
							<?=$this->page->name?>
							<span><?=nl2br($this->page->heading)?></span>
						</h1>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="container mt-50">
		
		<div class="row">

			<div class="col-sm-3">
				<div class="nav-secondary-container">
					<h2 class="title mt-0"><?=$rootPage->name?></h2>
					<div class="visible-xs dropdown open-nav-secondary"> <svg class="icon-down-open-big"><use xlink:href="#icon-down-open-big"></use></svg> </div>
					<ul class="nav-secondary">
						<?=$nav?>
					</ul>
				</div>
			</div>

			<div class="col-sm-9 content">

				<div class="row gut-25 pflex mb50">

					<div class="col-xs-12">
						<?=$this->page->content?>
					</div>

					<?php 

						$places = new Places();
						foreach ($placesData as $row) { 
						$customFields = json_decode($row["CustomFieldsValues"]);
						$filters = $places->getCategorys($row["ID"], "526, 102, 101, 103, 276, 278");

						

					?>
						<div class="col-xs-12 col-sm-6">

							<a class="item" href="<?=$row["PagesLink"]?>/<?=$row["link"]?>">
	
								<div class="image-con">
									<img class="image" src="/media/places/medium_<?=$row["FileName"]?>">
								</div>
								
								

								<div class="info">
									<h3 class="title"><?=$row["naziv"]?><span><?=$row["heading"]?></span></h3>

									<ul class="details inline">

										<?php foreach ($filters as $key => $value) {
											echo '<li title="'.$value["name"].'" class="tooltip"><svg class="icon-102"><title>your title</title><use xlink:href="#icon-'.$value["ID"].'"></use></svg> '.$value["value"].' '.$value["valuetype"].'</li>';
										}?>
										
										
									</ul>
									
								</div>
								
							</a>

						</div>
					<?php } ?>
				</div>

			</div>
		</div>
		
	</div>
</div>
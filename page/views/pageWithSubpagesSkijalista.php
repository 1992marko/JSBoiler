<div class="wrap">

	<?php if($this->page->headingImage->FileName) { ?>
		<div class="list-header hidden-xs" style="background: url('/media/pages/large_<?=$this->page->headingImage->FileName?>')">
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
				<h1><?=$this->page->name?></h1>
				<p><?=$this->page->content?></p>
				
				<h2>Skijališta</h2>

				<div class="row pflex gut-25">
					<?php foreach ($subPages as $row) { ?>
						
						<div class="col-xs-12 col-sm-6">

							<a class="item" href="<?=$row["link"]?>">
								
								<?php 
									
									$places = new Places();
									$skijaliste = $places->getForCategory( $row["ID"], false, [], true, null, 4 )[0];
									//$headingImage = Media::get( MyModules::PLACES, $row["ID"], mediaTypes::image, true, true )[0]; 
									//print_r($skijaliste);
								?>

								<div class="image-con">
									<img class="image" src="/media/places/medium_<?=$skijaliste["FileName"]?>">
								</div>
								
								<!--<div class="price">
									<img src="/assets/price.svg">
									<span class="st">starting from</span>
									<span class="pr"> Kn</span>
								</div>-->

								<!--button class="yellow-o book">View</button-->

								<div class="info">
									<h1 class="title"><?=$skijaliste["naziv"]?><span><?=$skijaliste["heading"]?></span></h1>
								</div>
								
							</a>

							<?php 
								

								
								


							?>

							

						</div>

					<?php } ?>
				</div>
			</div>
		</div>
		
	</div>
</div>
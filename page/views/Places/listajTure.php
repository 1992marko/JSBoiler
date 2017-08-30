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

			<div class="col-xs-12 col-sm-9 content">

				<div class="row gut-25 pflex mb50">
					
					<div class="col-xs-12">
						<?=$this->page->content?>
					</div>

					<?php foreach ($places as $row) { 
						$customFields = json_decode($row["CustomFieldsValues"]);
					?>
						<div class="col-xs-12 col-sm-6">

							<a class="item" href="<?=$row["PagesLink"]?>/<?=$row["link"]?>">
	
								<div class="image-con">
									<img class="image" src="/media/places/medium_<?=$row["FileName"]?>">

									<div class="head">
										<?=$row["heading"]?>
									</div>
								</div>
								
								<div class="price">
									<img src="/assets/price.svg">
									<span class="st">cijena od</span>
									<span class="pr"><?=number_format($row["price"],2,',','.')?> HRK</span>
								</div>

								<div class="info">
									<h3 class="title"><?=$row["naziv"]?></h3>

									<ul class="details">
										<li><svg class="icon-android-time"><use xlink:href="#icon-android-time"></use></svg> <?=$customFields->trajanjeture?></li>
										<li><svg class="icon-earth"><use xlink:href="#icon-earth"></use></svg> <?=$customFields->polazak?></li>
										<li><svg class="icon-calendar"><use xlink:href="#icon-calendar"></use></svg> <b><?=$customFields->istaknutidatum?></b> <?=$customFields->datumipolazaka?></li>
									</ul>

									<p class="price-total">Cijena od <strong><?=number_format($row["price"],2,',','.')?> HRK</strong></p>
									
								</div>
								
							</a>

						</div>
					<?php } ?>
				</div>

			</div>
		</div>
		
	</div>
</div>
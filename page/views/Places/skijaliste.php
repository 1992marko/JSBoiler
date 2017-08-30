<div class="wrap">
	<div ID="images" class="swiper-container">
		<div class="swiper-wrapper">

			<?php 
				$images = Media::get( MyModules::PLACES, $skijaliste->ID, mediaTypes::image, true, false ); 
			?>

			<?php foreach ($images as $row) { ?>
				
				<div class="swiper-slide" style="background-image:url('/media/places/<?=$row->FileName?>')"></div>
			
			<?php } ?>
		</div>

		<!-- Add Pagination -->
    	<div class="swiper-pagination"></div>

    	 <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
	</div>
</div>

<div class="wrap">
	<div class="container">
		
		<div class="row">
			
			<div class="col-xs-12">
				
				<h1 class="title blue"> <?=$skijaliste->naziv?> <span> <?=$skijaliste->heading?> </span>  </h1>

				

				<!-- <div class="row full">
					<div class="col-xs-6">
						<div ID="gmap" class="mb30" style="height: 400px; width: 100%;"></div>
					</div>
				</div> -->


				<div class="row">
					<div class="col-xs-8">
						<h3 class="title medium blue">Opis skijališta</h3>
						<p><?=$skijaliste->opis?></p>
					</div>

					<div class="col-xs-4">
						<h3 class="title medium blue">Sadržaj skijališta</h3>
						<?php foreach($filters as $key => $value) { ?>
							<ul class="facility">
								<li><?=$key?></li>
								<?php foreach($value as $key => $value) { ?>
									<li><svg class="icon-check"><use xlink:href="#icon-check"></use></svg> <?=$value["name"]?> <?=$value["value"]?> <?=$value["valuetype"]?></li>
								<?php } ?>
							</ul>
						<?php } ?>

						
					</div>

				</div>

				<h1>Hoteli</h1>

				<div class="row pflex hotel-list">
					<?php foreach ($objekti as $row) { ?>
						<div class="col-xs-12 col-sm-4">
							
							<a class="item" href="<?=$row["PagesLink"]?>/<?=$row["link"]?>">

								<div class="image-con">
									<img class="image" src="/media/places/medium_<?=$row["FileName"]?>">
								</div>

								<div class="info">
									<h1 class="title"><?=$row["naziv"]?><span><?=$row["heading"]?></span></h1>
								</div>
								
							</a>

						</div>
					<?php } ?>

				</div>
				
			</div>
		</div>
		
	</div>
</div>
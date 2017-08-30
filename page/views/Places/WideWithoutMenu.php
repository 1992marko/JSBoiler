<div class="wrap mt-50">
	<div class="container">
		
		<div class="row">
			<div class="col-xs-12">

				<h1><?=$this->page->name?></h1>
				<p><?=$this->page->content?></p>
				<div class="row full grid hotel-list mb50">
					<?php foreach ($places as $row) { ?>
						<div class="col-xs-12 col-sm-4">
						
							<div class="item">
								<img class="image" src="/media/places/medium_<?=$row["FileName"]?>">

								<div class="price">
									<img src="/assets/price.svg">
									<span class="st">starting from</span>
									<span class="pr"><?=number_format($row["price"],2,',','.')?> HRK</span>
								</div>

								<a href="<?=$row["PagesLink"]?>/<?=$row["link"]?>"><button class="yellow-o book">View</button></a>

								<div class="info">
									<h1 class="title"><?=$row["naziv"]?><span>Dubrovnik riviera</span></h1>
								</div>
							</div>

						</div>
					<?php } ?>
				</div>

			</div>
		</div>
		
	</div>
</div>
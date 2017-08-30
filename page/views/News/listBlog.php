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
				<h2 class="title mt-0">Blog arhiva<span>Propustili ste...pročitajte</span></h2>
				<!-- <ul class="nav-secondary">
					<?=$nav?>
				</ul> -->
			</div>

			



			<div class="col-xs-12 content">

				<div class="row gut-25 pflex mb50">
					<?php 
						$i = 0;
						foreach ($places as $row) {  
							//Remove images
							$row["novost"] = preg_replace("/<img[^>]+\>/i", "", $row["novost"]); 

							//Get first two paragraphs
							$dom = new DOMDocument;
							$dom->loadHTML('<?xml encoding="utf-8" ?>'.$row["novost"]);
							$p = $dom->getElementsByTagName('p');
							
							$novost = "";
							for ($i=0; $i < 2; $i++) { 
								$novost .= "<p>".$p[$i]->nodeValue."</p>";
							}

							//Decide the size
							if($i < 2){
								$b = "6";
								$s = "large_";
							} else {
								$b = "4";
								$s = "medium_";
							}
							$i++;
					?>
						
						<div class="col-xs-12 col-sm-4">
						
							<div class="article">

								<div class="image-con" style="background-image:url('/media/news/<?=$s?><?=$row["FileName"]?>')">
									<div class="datum"><?=date("d.m.Y", strtotime($row['datum_od']) )?></div>
								</div>

								<a href="<?=$row["PagesLink"]?>/<?=$row["link"]?>"><h4 class="title"><?=$row["naslov"]?></h4></a>
								<p><?=$row["heading"]?></p>
								<?=$novost?>
								<a href="<?=$row["PagesLink"]?>/<?=$row["link"]?>"><button class="blue-o">Pročitaj više</button></a>
							</div>

						</div>
					<?php } ?>
				</div>

			</div>
		</div>
		
	</div>
</div>
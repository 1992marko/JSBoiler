<div class="wrap">

	<?php if($this->page->headingImage->FileName) { ?>
		<div class="list-header hidden-xs" style="background: url('/media/pages/large_<?=$this->page->headingImage->FileName?>')">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
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
			
				<div class="row pflex gut-25">
					<?php foreach ($subPages as $row) { ?>
						
						<div class="col-sm-6">

							<a class="item" href="<?=$row["link"]?>">
								
								<div class="image-con">
									<img class="image" src="<?=$row["MediaFilePath"]?>medium_<?=$row["FileName"]?>">
								</div>
								

								<div class="info">
									<h1 class="title"><?=$row["name"]?><span><?=$row["heading"]?></span></h1>
								</div>
								
							</a>

						</div>

					<?php } ?>
				</div>
			</div>
		</div>
		
	</div>
</div>
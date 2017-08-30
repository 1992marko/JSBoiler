<div class="wrap mt-50">
	<div class="container">
		
		<div class="row">
			<div class="col-sm-3">
				<div class="nav-secondary-container">
					<h2 class="title blue mt-0"><?=$rootPage->name?></h2>
					<div class="visible-xs dropdown open-nav-secondary"> <svg class="icon-down-open-big"><use xlink:href="#icon-down-open-big"></use></svg> </div>
					<ul class="nav-secondary blue">
						<?=$nav?>
					</ul>
				</div>
			</div>

			<div class="col-sm-9 content">
				<h1><?=$this->page->name?></h1>
				<p><?=$this->page->content?></p>
			</div>
		</div>
		
	</div>
</div>
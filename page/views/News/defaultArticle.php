<div class="wrap mt-50">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
			
				<div class="row">
					<div class="col-xs-3">
						<h2 class="title blue mt-0">Novosti</h2>
							<div class="articles-side">
								<?php foreach ($articles as $row) { ?>
									<div class="article">
									
										<a href="<?=$row["PagesLink"]?>/<?=$row["link"]?>">
				
											<h6 class="mt-0"><?=$row["naslov"]?></h6>
											<p><?=$row["heading"]?></p>
											<span><?=date("d.m.Y", strtotime($row['datum_od']) )?></span>
											
										</a>

									</div>
								<?php } ?>
								<a href="/novosti"><button class="blue-o">Arhiva novosti</button></a>
							</div>
					</div>

					<div class="col-xs-9 content novost">
						<h1> <?=$article->naslov?> </h1>
						<h3><?=$article->heading?></h3>
						<span class="datum"><?=date("d.m.Y", strtotime($article->datum_od) )?></span>
						<p><?=$article->novost?></p>

					</div>

				</div>
				
			</div>
		</div>
		
	</div>
</div>
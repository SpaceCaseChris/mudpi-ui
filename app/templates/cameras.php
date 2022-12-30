<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
		<title>MudPi Cameras</title>
	    <?php echo csrf_meta(); ?>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="MudPi UI Cameras">
	    <meta name="author" content="MudPi - Eric Davisson">

		<?php include "partials/headIncludes.php"; ?>
	</head>
	<body>
		<div id="app" class="mnh-full">
			<?php include "partials/navigation.php"; ?>
			<div class="container">
				<div class="columns is-centered">
					<div class="column column-12 sm:column-12 md:column-12 ">
						<div class="content px-2 w-100">
							<h1 class="h2 text-primary" id="title">Cameras</h1>
							<p class="mb-4 text-grey-dark" id="message">This page lets you view the latest image or video from each camera associated with MudPi</p>
							<div id="errors" class="rounded-2 text-red-dark errors"></div>
							<h3 class="h3 text-primary">Cameras</h3>
							<div class="columns" style="margin-left:-10px;margin-right:-10px;">
								<?php foreach($cameras as $key => $camera) { ?>
								<div class="column column-12 sm:column-12 md:column-12">
									<div class="box py-1 px-1 display" data-key="<?php echo $camera->key;?>" data-topic="<?php echo $camera->topic ?? '' ?>">
										<div class="flex flex-row px-1">
											<div class="mr-a">
												<h3 class="h4 text-primary"><?php echo ($camera->name); ?></h3>
												<p class="text-grey-dark text-xs mb-1"><?php echo $camera->interface ?></p>
											</div>
											<div class="ml-a text-right">
												<p class="text-grey-dark text-sm"><?php echo $camera->topic ?? ''; ?></p>
												<?php if(isset($camera->source)) { ?>
													<a href="<?php echo $camera->source; ?>" class="text-grey text-xs mb-1" target="_blank"><?php echo $camera->source; ?></a>
												<?php }?>
											</div>
										</div>
										
										<div class="columns">
											<div class="mb-2 column column-12">
												<label class="label mb-1 text-primary w-100">Latest Photo: <?php echo $camera->state->state ?>, captured at: <?php echo $camera->state->updated_at ?></label>
												
												
												<?php if(end(explode(".", $camera->state->state)) == "mp4") { ?>
													<!-- video -->
													<?php if(isset($camera->binary) && !empty($camera->binary)) { ?>
														<video class="w-100" src="data:video/mp4;base64,<?php echo $camera->binary; ?>" controls>
															<img class="w-100" style="margin:0px auto;" src="img/no_photo.jpg"/>
														</video>
													<?php } else {?>
														<img style="margin:0px auto;" src="img/no_photo.jpg"/>
													<?php }?>
												<?php } else {?>
													<!-- photo -->
													<?php if(isset($camera->binary) && !empty($camera->binary)) { ?>
														<a class="w-100" href="data:image/jpeg;base64,<?php echo $camera->binary; ?>" target="_blank">
															<img class="w-100" src="data:image/jpeg;base64,<?php echo $camera->binary; ?>"/>
														</a>
													<?php } else {?>
														<img class="w-100" style="margin:0px auto;" src="img/no_photo.jpg"/>
													<?php }?>
												<?php }?>
											</div>
										</div>
									</div>
								</div>
								<?php }?>
							</div>
						</div>
					
					</div> <!-- /Container -->
				</div> <!-- /Columns -->
			</div> <!-- /Column 12 -->
		</div>
	</body>
</html>
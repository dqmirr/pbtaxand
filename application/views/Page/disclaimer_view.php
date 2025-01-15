<style>
	#disclaimer_page {
		display: flex;
		flex-direction: column;
		position: fixed;
		background-color: #fff;
		left: 1rem;
		right: 1rem;
		bottom: 42px;
		border-radius: 2rem;
		border: 5px solid var(--primary);
		padding: 1rem 2rem;
		overflow: auto;
		max-height: 600px;
	}

	.petunjuk_dan_ketentuan .body h2 {
		color: var(--danger);
		font-size: 20px;
		font-weight: bold;
		margin-bottom: 0;
	}

	.petunjuk_dan_ketentuan ul {
		list-style: none; /* Remove default bullets */
		padding-left: 1rem;
	}

	.petunjuk_dan_ketentuan ul li::before {
		content: "\2022";  /* Add content: \2022 is the CSS Code/unicode for a bullet */
		font-size: 42px;
		color: var(--primary); /* Change the color */
		font-weight: bold; /* If you want it to be bold */
		display: inline-block; /* Needed to add space between the bullet and the text */
		width: 2rem; /* Also needed for space (tweak if needed) */
		margin-left: -2rem; /* Also needed for space (tweak if needed) */
		line-height: 14px;
		top: 20px;
		transform: translate(0, 5px);
	}

	.petunjuk_dan_ketentuan ul li {
		font-weight: 500;
	}

	.disclaimer_text{
		height: 200px;
	}

	input[type="checkbox"] {
		appearance: none;
		background-color: #fff;
		font: inherit;
		color:  var(--primary);
		width: 1.15em;
		height: 1.15em;
		border: 0.15em solid var(--primary);
		border-radius: 0.15em;
		transform: translateY(-0.075em);
		display: grid;
  		place-content: center;
	}

	input[type="checkbox"]::before {
		content: "x";
		width: 0.65em;
		height: 0.65em;
		transform: scale(0);
		transition: 120ms transform ease-in-out;
		box-shadow: inset 1em 1em var(--form-control-color);

		transform-origin: bottom left;
		clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
	}

	input[type="checkbox"]:checked::before {
		background-color:var(--primary);
		transform: scale(1);
	}

	.btn{
		white-space:normal !important;
		word-wrap: break-word; 
	}
	video, canvas {
		width: 100%    !important;
		height: auto   !important;
	}

	.body-bg-image-disclaimer {
		background-image:url('/assets/images/bg-disclaimer.jpeg');
		background-repeat: no-repeat;
		background-size: 100vw 93vh;
		position: absolute;
		left: 0px;
		width: 100vw;
		top:70px;
		bottom: 0;
	}
</style>
<!-- <div class="body-bg-image-disclaimer"></div> -->
<div id="disclaimer_page">
	<div class="d-flex flex-column text-center">
		<h2>WELCOME</h2>
		<h4>Selamat datang di platform tes online</h4>
		<h4>PB Taxand</h4>
	</div>
	<div class="row">
		<div class="col-12 col-md-6 petunjuk_dan_ketentuan">
			<div class="d-flex flex-column text-center mb-3">
				<b><?= strtoupper($petunjuk_text['header']); ?></b>
			</div>
			<div class="body">
				<?= $petunjuk_text['content'] ?>
			</div>
		</div>
		<div class="col-12 col-md-6 disclaimer_text">
			<div class="d-flex flex-column text-center mb-3">
				<b>PERNYATAAN</b>
			</div>
			<div class="d-flex flex-column" style="font-weight:500;">
				<p>Dengan ini, saya menyatakan:</p>
				<form method="POST" action="<?php echo $target_url;?>">
					<?php 
						if(isset($list_policy) && is_array($list_policy)):
							foreach($list_policy as $row):
					?>
						<div class="form-check mb-2">
							<input class="form-check-input" type="checkbox" name="<?=$row->value;?>" id="<?= "selectDisc-".$row->value; ?>" <?php if($row->is_checked){echo 'checked';}?>>
							<label class="form-check-label ml-2" for="<?= "selectDist-".$row->value; ?>">
								<?=$row->text;?>
							</label>
						</div>
					<?php
							endforeach; 
						endif;
					?>
					<center>
						<input type="submit" class="btn" style="background-color:var(--primary)" id="save_value" name="save_value" value="ACCEPT" />
					</center>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.all.min.js"></script>


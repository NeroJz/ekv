<legend>
	<h4>Penyelenggaraan Modul</h4>
</legend>
<ul class="nav nav-tabs" id="myTab">
	<?php /*<li class="active">
		<a href="#Akademik" data-toggle="tab">Akademik</a>
	</li>*/?>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Akademik <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li class="">
				<a href="#Akademik" data-toggle="tab">Aktif</a>
			</li>
			<li class="">
				<a href="#Tak-Aktif" data-toggle="tab">Tak-Aktif</a>
			</li>
		</ul>
	</li>

	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Vokasional <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li class="">
				<a href="#Akademik" data-toggle="tab">Vokasional-Aktif</a>
			</li>
			<li class="">
				<a href="#Tak-Aktif" data-toggle="tab">Vokasional-Tak-Aktif</a>
			</li>
		</ul>
	</li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="tabContentAkademik"></div>
	<div class="tab-pane" id="tabContentVokasional"></div>
</div>

<script src="<?=base_url() ?>assets/js/maintenance/table.js" type="text/javascript"></script>
<div id="etapes" class="row">
		<ul class="ulRecap nav navbar-nav m0 col-lg-push-2 col-lg-8 col-md-push-1 col-md-10 col-sm-push-2 col-sm-8 col-push-xs-0 col-xs-12">
			<li id="un" class="cel p0 col-xs-4 col-sm-3 col-sm-offset-2 col-md-2"><span class="num p0 col-xs-1">1</span><span class="txt tar p0 col-xs-10">Votre Panier</span></li>
			<li id="deux" class="cel p0 col-xs-4 col-sm-3 col-sm-offset-1 col-md-2"><span class="num p0 col-xs-1">2</span><span class="txt tar p0 col-xs-10">Vos Coordonnées</span></li>
			<li id="trois" class="cel p0 col-xs-4 col-sm-3 col-sm-offset-1 col-md-2"><span class="num p0 col-xs-1">3</span><span class="txt tar p0 col-xs-10">Paiement</span></li>
		</ul>
</div>
<script>
	var url = window.location.href;
	var lastChar = url[url.length - 1];

	switch (lastChar) {
		case 'p':
			$("#un").addClass('op');
			break;
		case 's':
			$("#deux").addClass('op');
			break;
		case 't':
			$("#trois").addClass('op');
			break;

		default:
			// statements_def
			break;
	}

</script>

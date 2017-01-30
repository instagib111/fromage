<div id="etapes">
	<ul>
		<li id="un"><span>1</span>Votre Panier</li>
		<li id="deux"><span>2</span>Vos Coordonnées</li>
		<li id="trois"><span>3</span>Paiement</li>
	</ul>
</div>
<script>
	var url = window.location.href;
	var lastChar = url[url.length - 1];

	switch (lastChar) {
		case 'p':
			$("#un").attr('class', 'op');
			break;
		case 's':
			$("#deux").attr('class', 'op');
			break;
		case 't':
			$("#trois").attr('class', 'op');
			break;

		default:
			// statements_def
			break;
	}

</script>
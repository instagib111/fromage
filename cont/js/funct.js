/***************/
/**** ADMIN ****/
/***************/
$(function() {
	function modifier(id_fromage, nom, categorie, prixKg, description, image){
		$('#id_fromage').val(id_fromage);
		$('#idFromage').html(id_fromage);
		$('#nom').val(nom);
		$('#categorie').val(categorie);
		$('#prixKg').val(prixKg);
		$('#description').val(description);
		$('#image').val(image);
	}

	$(".lnkModifier").click(function(event) {
	    var t = $(this).data('valeur');
	    modifier(t.id_fromage, t.nom, t.categorie, t.prixKg, t.description, t.image);
	    $("#subAjMo").val('Modifier');
	    $("#titreForm").html("Modification d'un fromage");
	    $("#ident").slideDown();
	    $(".formAdd").slideDown(500);
	    $("#addFromage").slideUp();
	    $("html, body").animate({ scrollTop: $(document).height() }, 500);
	});

	$("#cross").click(function(event) {
		$(".formAdd").slideUp(500);
	    $("#addFromage").slideDown();
	});

	$("#addFromage").click(function(event) {
		modifier("","","","","","");
	    $("#titreForm").html("Ajout d'un fromage");
	    $("#subAjMo").val('Ajouter');
	    $("#ident").slideUp();
    	$("#addFromage").slideUp(200);
	    $(".formAdd").slideDown(500);
	    $("html, body").animate({ scrollTop: $(document).height() }, 500);
	});;

	$(".lnkSuppReta").click(function(event) {
		var v = $(this).data('valeur');
		var s = $(this).data('stat');
		var that = this;
		$.ajax({
			method: "POST",
			url: "../admin/admin.php",
			data: { idSupp: v,
					stat: s
				  },
			success: function (){
				if(s == 0){
					$(that).removeClass('glyphicon-remove').addClass('glyphicon-repeat').data('stat',1);
					$(that).removeClass('btn-danger').addClass('btn-warning');
					$("#l" + v).attr('class', 'status1');
				} else {
					$(that).removeClass('glyphicon-repeat').addClass('glyphicon-remove').data('stat',0);
					$(that).removeClass('btn-warning').addClass('btn-danger');
					$("#l" + v).attr('class', 'status0');
				}
			}
		});
	});

	$(".articles").click(function(event) {
		var v = $(this).data('valeur');
		$('#hidenAttr').val(v);
		$("#hidenForm").submit();
	});

	$(".btn_slider").click(function(event) {
		var stat = $(this).data('stat');
		var id = $(this).data('id');
		var that = this;
		$.ajax({
			method: "POST",
			url: "../admin/admin.php",
			data: { idSlider: id,
					stat: stat
				  },
			success: function (){
				if (stat == 0){
					$(that).data('stat', 1).html("OUI");
					$(that).removeClass('btn-danger').addClass('btn-info');
				} else {
					$(that).data('stat', 0).html("NON");
					$(that).removeClass('btn-info').addClass('btn-danger');
				}
			}
		});
	});

	/*********************************/
	/** Gestion des click sur aside **/
	/*********************************/
	$("#lVache").click(function(event) {
		var v = $(this).data('value');
		$('#asideHiddenInput').val(v);
		$("#asideHiddenForm").submit();
	});
	$("#lChevre").click(function(event) {
		var v = $(this).data('value');
		$('#asideHiddenInput').val(v);
		$("#asideHiddenForm").submit();
	});
	$("#lBrebis").click(function(event) {
		var v = $(this).data('value');
		$('#asideHiddenInput').val(v);
		$("#asideHiddenForm").submit();
	});
	$("#vins").click(function(event) {
		var v = $(this).data('value');
		$('#asideHiddenInput').val(v);
		$("#asideHiddenForm").submit();
	});
	$("#plateaux").click(function(event) {
		var v = $(this).data('value');
		$('#asideHiddenInput').val(v);
		$("#asideHiddenForm").submit();
	});

	/********************************/
	/** topArticle Gestion du prix **/
	/********************************/
	$("#poids").change(function(event) {
		var by = $(this).val();
		var qt = $("#quantite").val();
		var prix = $('#prixTTC').data('prix');

		$("#prixTTC").html(((prix * by) * qt).toFixed(2) + "€");
		$("#prixTTCHidden").val(((prix * by) * qt).toFixed(2));
		
	});
	$("#quantite").change(function(event) {
		var by = $("#poids").val();
		var qt = $(this).val();
		var prix = $('#prixTTC').data('prix');

		$("#prixTTC").html(((prix * by) * qt).toFixed(2) + "€");
		$("#prixTTCHidden").val(((prix * by) * qt).toFixed(2));
	});

	/************/
	/** Panier **/
	/************/
	$(".dPanier").click(function(event) {
		var id = $(this).data('id');
		$('#hidenAttr').val(id);
		$("#hidenForm").submit();
	});
	/*****************/
	/** coordonnees **/
	/*****************/
	$("#same").change(function(event) {
		if($(this).is(':CHECKED')){
			$("#adresseFacturation").slideDown(100);
			$("#adresseLivraison").hide(100);
			$("#adresseL").removeAttr('required');
			$("#villeL").removeAttr('required');
			$("#codePostalL").removeAttr('required');
			$("#paysL").removeAttr('required');
		}
	});
	$("#notsame").change(function(event) {
		if($(this).is(':CHECKED')){
			$("#adresseFacturation").slideDown(100);
			$("#adresseLivraison").slideDown(100);
			$("#adresseL").attr('required','required');
			$("#villeL").attr('required','required');
			$("#codePostalL").attr('required','required');
			$("#paysL").attr('required','required');
		}
	});
	/***************/
	/** commandes **/
	/***************/
	$(".btn_affAdr").click(function(event) {
		var a = $(this).data('adresse');
		alert(a);
	});
	$(".btn_affPan").click(function(event) {
		var a = $(this).data('panier');
		alert(a);
	});
	$(".btn_envoye").click(function(event) {
		var id = $(this).data('id');
		var statut = $("#l" + id).data('statut');
		var t = new Date();
		var day = t.getDate();
		var month = t.getMonth() + 1;
		var year = t.getFullYear();
		var that = this;
		if(statut == 0 || statut == 1){
			$.ajax({
				method: "POST",
				url: "../admin/commandes.php",
				data: { idCommande: id,
						statut: statut,
						btn: 1
					  },
				success: function (){
					if(statut == "0"){
						$("#l" + id).attr('class', 'statut1');
						$("#l" + id).data('statut', 1);
						$("#l" + id).attr('data-statut', '1');
						$(that).html((day<10 ? '0' : '') + day +"/"+ (month<10 ? '0' : '') + month +"/" + year);
					}
					else if(statut == "1"){
						$("#l" + id).attr('class', 'statut0');
						$("#l" + id).data('statut', 0);
						$("#l" + id).attr('data-statut', '0');
						$(that).html("ENVOYER");
					}
				}
			});
		}
	});
	$(".btn_recue").click(function(event) {
		var id = $(this).data('id');
		var statut = $("#l" + id).data('statut');
		var t = new Date();
		var day = t.getDate();
		var month = t.getMonth() + 1;
		var year = t.getFullYear();
		var that = this;
		if(statut == 1 || statut == 2){
			$.ajax({
				method: "POST",
				url: "../admin/commandes.php",
				data: { idCommande: id,
						statut: statut,
						btn: 2
					  },
				success: function (){
					if(statut == "1"){
						$("#l" + id).attr('class', 'statut2');
						$("#l" + id).data('statut', 2);
						$("#l" + id).attr('data-statut', '2');
						$(that).html((day<10 ? '0' : '') + day +"/"+ (month<10 ? '0' : '') + month +"/" + year);
					}
					else if(statut == "2"){
						$("#l" + id).attr('class', 'statut1');
						$("#l" + id).data('statut', 1);
						$("#l" + id).attr('data-statut', '1');
						$(that).html("REÇUE");
					}
				}
			});
		}
	});
});
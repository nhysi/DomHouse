/* Bootstrap Contact Form
 ***************************************************************************/
jQuery(document).ready(function(){
	// validate signup form on keyup and submit

	var validator = jQuery("#contactform").validate({
		errorClass:'has-error',
		validClass:'has-success',
		errorElement:'div',
		highlight: function (element, errorClass, validClass) {
			jQuery(element).closest('.form-control').addClass(errorClass).removeClass(validClass);
		},
		unhighlight: function (element, errorClass, validClass) {
			jQuery(element).parents(".has-error").removeClass(errorClass).addClass(validClass);
		},
		rules: {
			nom: {
				required: true,
				minlength: 2
			},
			prenom: {
				required: true,
				minlength: 2
			},
			ville: {
			    required: true,
				minlength: 2
		    },
            pays: {
			    required: true,
				minlength: 1	
		    },				
			code_postal: {
			    required: true,
				minlength: 3		
			},
			jour: {
			    required: true,
				minlength: 1		
			},
			mois: {
			    required: true,
				minlength: 1		
			},
			année: {
			    required: true,
				minlength: 1		
			},
			login: {
			    required: true,
				minlength: 3				
			},
			mdp: {
			    required: true,
			    minlength: 7
			},	
			ConfirmMdp: {
			    required: true,
			    minlength: 7
			},	
			email: {
				required: true,
				email: true
			},
			ConfirmEmail: {
				required: true
			},
			LienRasp: {
				required: true,
				minlength: 14
			},
		},
		messages: {
			nom: {
				required: '<span class="help-block">Entrez votre nom.</span>',
				minlength: jQuery.format('<span class="help-block">Votre nom doit contenir au moins {0} caractères.</span>')
			},
			prenom: {
				required: '<span class="help-block">Entrez votre prenom.</span>',
				minlength: jQuery.format('<span class="help-block">Votre prenom doit contenir au moins {0} caractères.</span>')
			},
			ville: {
			    required: '<span class="help-block">Entrez la ville.</span>',
				minlength: jQuery.format('<span class="help-block">Le nom de la ville doit être au moins de {0} caractères.</span>')			
			},
			pays: {
			    required: '<span class="help-block">Indiquez le pays.</span>',
				minlength: jQuery.format('<span class="help-block">Merci d\'indiquez le pays.</span>')		
			},
			code_postal: {
			    required: '<span class="help-block">Entrez le code postal.</span>',
				minlength: jQuery.format('<span class="help-block">Le code postal doit être au moins de {0} chiffres.</span>')			
			},
			jour: {
			    required: '<span class="help-block">Entrez un jour.</span>',
				minlength: jQuery.format('<span class="help-block">Entrez un jour valide.</span>')			
			},
			mois: {
			    required: '<span class="help-block">Entrez un mois.</span>',
				minlength: jQuery.format('<span class="help-block">Entrez un mois valide.</span>')			
			},
			année: {
			    required: '<span class="help-block">Entrez une année.</span>',
				minlength: jQuery.format('<span class="help-block">Entrez une année valide.</span>')			
			},
			login: {
			    required: '<span class="help-block">Entrez un identifiant.</span>',
				minlength: jQuery.format('<span class="help-block">Le login doit contenir au moins {0} caractères.</span>')	
			},
			mdp: {
			    required: '<span class="help-block">Entrez un mot de passe.</span>',
				minlength: jQuery.format('<span class="help-block">Le mot de passe doit contenir au moins {0} caractères.</span>')			
			},		
			ConfirmMdp: {
			    required: '<span class="help-block">Entrez un mot de passe de confirmation.</span>',
				minlength: jQuery.format('<span class="help-block">Le mot de passe de confirmation doit être identique.</span>')			
			},
			email: {
				required: '<span class="help-block">Entrez une adresse email valide.</span>',
				email: '<span class="help-block">Entrez une adresse email valide.</span>'
			},
			ConfirmEmail: {
				required: '<span class="help-block">Entrez une adresse email de confirmation.</span>'
			},
			LienRasp: {
				required: '<span class="help-block">Entrez un lien URL valide.</span>',
				minlength: jQuery.format('<span class="help-block">Le lien URL doit être au minimum de {0} caractères.</span>')	
			}
		}
	});
});

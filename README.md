### ORGANIZAÇÃO DO PROJETO

/list-all-broadband/index.php - Lógica de listagem de todas as combinações possíveis de planos iniciadas com planos do tipo Broadband

/list-all-broadband/plans.json - Json representativo do diagrama de planos proposto. Para adicionar novos planos, deve-se manter a estrutura proposta neste arquivo:

	"" : {
		"name"	: "",
		"type"	: "",
		"value"	: ,
		"connections": []
	}

/index.php - Recebe dados das combinações dos planos através do controller myApp (assets/js/controllers.js) e exibe todas combinações possíveis

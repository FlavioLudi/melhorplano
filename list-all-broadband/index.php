<?php

// Recebe json com lista de Planos e formata início da Lógica de Combinação 
$plans = json_decode(file_get_contents('plans.json'), true);

/** 
* Recebe plano inicial e retorna com valores formatados
* @param array $plan plano inicial
*/
function makeSingle($plan) {
	
	$single = [
		'names' => [$plan['name']],
		'types' => [$plan['type']],
		'total_value' => $plan['value']
	];

	return $single;
}

/**
 * Recebe Planos e retorna combinações sequenciais a partir dele
 * @param array $plans Todos os planos isolados disponíveis 
 * @param int $plan_id id do plano que será o ponto de partida para as combinações
 * @param array $bundle combinação de planos anterior às novas combinações
 * @param int $add_value valor adicional referente a cada nova coneção feita em cada combinação
 */
function makeBundles($plans, $plan_id, $bundle=[], $add_value=0) {

	// Não há conexões no Plano
	if (empty($plans[$plan_id]['connections'])) {

		// Acrescenta dados deste Plano à combinação de planos anterior
		$bundle[] = [
			'name' => $plans[$plan_id]['name'], 
			'value' => $plans[$plan_id]['value'],
			'type' => $plans[$plan_id]['type'],
			'add_value' => $add_value,
		];

		return $bundle;
		
	}

	// Há conexões no Plano
	else {

		// Acrescenta dados deste Plano à combinação de planos anterior
		$bundle[] = [
			'name' => $plans[$plan_id]['name'], 
			'value' => $plans[$plan_id]['value'],
			'type' => $plans[$plan_id]['type'],
			'add_value' => $add_value,
		];
		
		foreach ($plans[$plan_id]['connections'] as $key => $connection) {
			// Mantém a combinação de planos anterior para cada nova conexão deste Plano
			if ($key == 0) {
				$aux_bundle = $bundle;
			}
			// Executa nova combinação as conexões deste plano
			$option[] = makeBundles($plans, $connection['id'], $aux_bundle, $connection['add_value']);
		}
		
		return $option;

	}
}

/** 
* Recebe Combinação de Planos e retorna com valores formatados
* @param array $bundle combinação de Planos
*/
function formatBundles($bundle) {
	
	$formated_bundle = ['names' => [], 'types' => [], 'total_value' => ''];

	foreach ($bundle as $bundle_items) {
		foreach ($bundle_items as $key => $item) {
			if ($key == 'value' || $key == 'add_value') {
				$formated_bundle['total_value'] += $item;
			}
			elseif ($key == 'name') {
				array_push($formated_bundle['names'], $item);
			}
			elseif ($key == 'type') {
				array_push($formated_bundle['types'], $item);
			}
		}
	}

	return $formated_bundle;
}

/** 
* Recebe Combinação de Planos formatados e retorna em ordem crescente
* @param array $result combinação de Planos a ser ordenado
* @param String $orderBy atributo do plano que será utilizado como fator de ordenação
*/
function orderResult($result, $orderBy) {
	
	// Cria array auxiliar para ordernar resultado
	foreach ($result as $key => $result_item) {
	    $aux_order[$key] = $result_item[$orderBy];
	}

	// Ordena resultado
	array_multisort($aux_order, SORT_ASC, $result);

	return $result;
}


// Todas Combinações possíveis para os Planos disponíveis
$bundles = [];
// Todas Combinações possíveis + Planos Isolados para os Planos disponíveis
$bundles_result = [];

foreach ($plans as $key => $plan) {

	// Todas Combinações e Planos Isolados deverão começar por Planos do Tipo BroadBand
	if ($plan['type'] == 'bb') {	

		// Insere Planos Isolados no resultado final
		$bundles_result[] = makeSingle($plan);
		// Todas Combinações possíveis em cada Plano Isolado selecionado como inicial
		$bundles[] = makeBundles($plans, $key);

	}

}

// Primeira dimesão do Array de Combinações
foreach ($bundles as $bundles_one) {

	// Segunda dimesão do Array de Combinações
	foreach ($bundles_one as $bundle_two) {

		// Formata resultado das Combinações, caso existentes nessa dimensão
		if (array_key_exists('name', $bundle_two[0])) {
			$bundles_result[] = formatBundles($bundle_two);
		}

		// Terceira dimesão do Array de Combinações
		foreach ($bundle_two as $key => $bundle_three) {

			// Separa e formata resultados das Combinações de 2 Planos nas combinações de 3 Planos
			if (count($bundle_three) == 3 && $key == 0) {
				$bundle_three_aux = $bundle_three;
				array_pop($bundle_three_aux);
				$bundles_result[] = formatBundles($bundle_three_aux);
			}

			// Formata resultado das Combinações, caso existentes nessa dimensão
			if (array_key_exists(0, $bundle_three) && array_key_exists('name', $bundle_three[0])) {
				$bundles_result[] = formatBundles($bundle_three);
			}

		}

	}

}

// Ordeman resultado
$bundles_result = orderResult($bundles_result, 'total_value');

// Formata e envia resultado em Json 
header('Content-Type: application/json');
echo json_encode($bundles_result);

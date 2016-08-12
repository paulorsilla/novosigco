<?php

namespace Application\Validator;

use Zend\Validator\AbstractValidator;

class Cpf extends AbstractValidator {
	const INVALIDO = 'INVALIDO';
	protected $messageTemplates = array (
			self::INVALIDO => 'Cpf inválido' 
	);
	public function __construct(array $options = array()) {
		parent::__construct ( $options );
	}
	public static function isValid($cpf = null) {
		// elimina possivel mascara
		$cpf = preg_replace ( '/[^0-9]/', '', $cpf );
		$cpf = str_pad ( $cpf, 11, '0', STR_PAD_LEFT );
		
		// verifica se o numero de digitos informados é igual a 11
		if (strlen ( $cpf ) != 11) {
			$this->error ( self::INVALIDO );
			return false;
		} 		// verifica se nenuma das sequências invalidas abaixo
		// foi digitada. caso afirmativo, retorna falso
		else if ($cpf == "00000000000" || $cpf == "11111111111" || $cpf == "22222222222" || $cpf == "33333333333" || $cpf == "44444444444" || $cpf == "55555555555" || $cpf == "66666666666" || $cpf == "77777777777" || $cpf == "88888888888" || $cpf == "99999999999") {
			$this->error ( self::INVALIDO );
			return false;
		} 		// calcula os digitos verificadores para verificar
		// se o CPF é valido
		else {
			for($i = 9; $i < 11; $i ++) {
				for($j = 0, $k = 0; $k < $i; $k ++) {
					$j += $cpf {$k} * (($i + 1) - $k);
				}
				$j = ((10 * $j) % 11) % 10;
				if ($cpf {$k} != $j) {
					$this->error ( self::INVALIDO );
					return false;
				}
			}
			return true;
		}
	}
}
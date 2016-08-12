<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class Empregado extends Form
{
	public function __construct()
	{
		parent::__construct('Empregado');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/application/empregado/save');
                
		$this->add(array(
			'name' => 'matricula',
			'attributes' => array(
				'type' => 'hidden',
				'id' => 'matricula',
			),
		));

        $this->add(array(
            'name' => 'submit',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Enviar',
				'id' => 'submit',
			),
		));
	}
}

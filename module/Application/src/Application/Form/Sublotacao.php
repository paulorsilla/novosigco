<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class Sublotacao extends Form
{
	public function __construct()
	{
		parent::__construct('Sublotacao');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/application/sublotacao/save');
                
		$this->add(array(
			'name' => 'id',
			'attributes' => array(
			'type' => 'hidden',
			),
		));
                
		$this->add(array(
			'name' => 'descricao',
			'attributes' => array(
				'type' => 'text',
				'style' => 'width: 800px'
				),
			'options' => array(
				'label' => 'Sublotação:*',
			),
		));

		$this->add(array(
				'name' => 'sigla',
				'attributes' => array(
					'type' => 'text',
					'style' => 'width: 800px'
				),
				'options' => array(
						'label' => 'Sigla:',
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

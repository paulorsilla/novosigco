<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class Escolaridade extends Form
{
	public function __construct()
	{
		parent::__construct('Escolaridade');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/application/escolaridade/save');
                
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
				'style' => 'width:800px',
			),
			'options' => array(
				'label' => 'Escolaridade:*',
			),
		));

		$this->add(array(
				'name' => 'ordem',
				'attributes' => array(
						'style' => 'width:800px',
						'type' => 'text',
				),
				'options' => array(
						'label' => 'Ordem:*',
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

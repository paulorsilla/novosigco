<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class Cargo extends Form
{
	public function __construct()
	{
		parent::__construct('Cargo');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/application/cargo/save');
                
		$this->add(array(
			'name' => 'id',
			'attributes' => array(
			'type' => 'hidden',
			),
		));
                
		$this->add(array(
			'name' => 'descricao',
			'attributes' => array(
				'style' => 'width:800px',
				'type' => 'text',
				),
			'options' => array(
				'label' => 'Cargo:*',
			),
		));

		$this->add(array(
				'name' => 'pce',
				'attributes' => array(
						'style' => 'width:80px',
						'type' => 'text',
				),
				'options' => array(
						'label' => 'PCS/PCE:*',
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

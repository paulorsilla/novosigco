<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class OutraFuncao extends Form
{
	public function __construct()
	{
		parent::__construct('OutraFuncao');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/application/outra-funcao/save');
                
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
				'label' => 'Outra função:*',
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

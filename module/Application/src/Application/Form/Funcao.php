<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class Funcao extends Form
{
	public function __construct()
	{
		parent::__construct('Funcao');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/application/funcao/save');
                
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
				'label' => 'Função:*',
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

<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class Area extends Form
{
	public function __construct()
	{
		parent::__construct('Area');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/application/area/save');
                
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
				'label' => 'Descrição:*',
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

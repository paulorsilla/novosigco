<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class Subarea extends Form
{
	public function __construct($em)
	{
		parent::__construct('Subarea');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/application/subarea/save');
                
		$this->add(array(
			'name' => 'id',
			'attributes' => array(
			'type' => 'hidden',
			),
		));
        
		$this->add(array(
				'name'       => 'area',
				'type'       => 'DoctrineModule\Form\Element\ObjectSelect',
				'attributes' => array(
						'style' => 'width:800px',
						'required' => true,
						'id' => 'area'
				),
				'options'    => array(
						'label'           => 'Área:*',
						'empty_option'    => '--- Escolha uma Área ---',
						'object_manager'  => $em,
						'target_class'    => 'Application\Model\Area',
						'property'        => 'descricao'
				)
		));
		
		$this->add(array(
			'name' => 'descricao',
			'attributes' => array(
				'type' => 'text',
				'style' => 'width: 785px',
				),
			'options' => array(
				'label' => 'Subárea:*',
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

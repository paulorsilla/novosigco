<?php

namespace Application\Form;

use Zend\Form\Form;

class EquipeTecnica extends Form {
	public function __construct($em) {
		parent::__construct ( 'EquipeTecnica' );
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'action', '/application/equipe-tecnica/save' );
		
		$this->add ( array (
				'name' => 'id',
				'attributes' => array (
						'type' => 'hidden' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'descricao',
				'attributes' => array (
						'style' => 'width:800px',
						'type' => 'text' 
				),
				'options' => array (					
						
						'label' => 'Equipe Técnica:*' 
				) 
		) );
		
// 		$this->add(array(
// 				'name' => 'lider',
// 				'type' => 'DoctrineModu'
// 				'attributes' => array(
// 						//'type' => 'select',
// 				),
// 				'options' => array(
// 						'label' => 'Lider',
// 				),
// 		));

		$this->add(array(
            'name'       => 'lider',
            'type'       => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'style' => 'width: 820px',
                'required' => true,
            ),
            'options'    => array(
                'label'           => 'Líder',
                'empty_option'    => '--- Escolha um líder ---',
                'object_manager'  => $em,
                'target_class'    => 'Application\Model\Empregado',
            	'property' => 'nome',
            		'find_method' => array(
            				'name' => 'getEmpregados',
            		),
//                 'label_generator' => function($targetEntity) {
//                     return $targetEntity->getDescricao().' - '.$targetEntity->getLocal();
//                 }
            ),
        ));
		
		$this->add ( array (
				'name' => 'submit',
				'attributes' => array (
						'type' => 'submit',
						'value' => 'Enviar',
						'id' => 'submit' 
				) 
		) );
	}
}

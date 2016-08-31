<?php
namespace Application\Form;

use Zend\Form\Form;

class CompetenciaTipo extends Form{
	public function __construct()
	{
		parent::__construct('CompetenciaTipo');
		$this->setAttribute('method', 'post');
		$this->setAttribute('action', '/application/competencia-tipo/save');

		$this->add(array(
				'name'=> 'id',
				'attributes' => array(
						'type' => 'hidden'
				),
		));
		$this->add(array(
				'name' => 'descricao',
				'attributes' => array(
						'style' => 'width:800px',
						'type'=> 'text',
				),
				'options' => array(
						'label' => 'Titulo da competência:'
				)));

		$this->add(array(
				'name'=>'submit',
				'attributes' => array(
						'type'=>'submit',
						'value'=>'Enviar',
						'id'=>'submit',
				),
		));
	}
}


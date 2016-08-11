<?php

namespace Application\Model;

use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade EmpregadoEscolaridade
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="empregado_escolaridade")
 *         
 */
class EmpregadoEscolaridade extends Entity {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", name="empregado_matricula");
	 */
	protected $empregado;
	
	/**
	 * @ORM\Column(type="string", name="instituicao_id");
	 */
	protected $instituicao;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Escolaridade")
	 * @ORM\JoinColumn(name="escolaridade_id", referencedColumnName="id")
	 */
	protected $escolaridade;
	
	/**
	 * @ORM\Column(type="string");
	 */
	protected $curso;
	
	/**
	 * @ORM\Column(type="integer", name="ano_conclusao")
	 */
	protected $anoConclusao;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getEmpregado() {
		return $this->empregado;
	}
	public function setEmpregado($empregado) {
		$this->empregado = $empregado;
	}
	public function getInstituicao() {
		return $this->instituicao;
	}
	public function setInstituicao($instituicao) {
		$this->instituicao = $instituicao;
	}
	public function getEscolaridade() {
		return $this->escolaridade;
	}
	public function setEscolaridade($escolaridade) {
		$this->escolaridade = $escolaridade;
	}
	public function getCurso() {
		return $this->curso;
	}
	public function setCurso($curso) {
		$this->curso = $curso;
	}
	public function getAnoConclusao() {
		return $this->anoConclusao;
	}
	public function setAnoConclusao($anoConclusao) {
		$this->anoConclusao = $anoConclusao;
	}
}

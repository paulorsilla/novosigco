<?php

namespace Application\Model;

use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade EmpregadoSoja
 *
 * @category Application
 * @package Model
 *         
 *          @ORM\Entity
 *          @ORM\Table(name="rh.rh_tb_funcionario")
 *          @ORM\Entity(repositoryClass="Application\Repository\EmpregadoRepository")
 *         
 */
class Empregado extends Entity {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="cod_func");
	 */
	protected $matricula;
	
	/**
	 * @ORM\Column(type="string", name="nome_func")
	 */
	protected $nome;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $email;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $ramal;

	/**
	 * @ORM\Column(type="string", name="ativo_func")
	 */
	protected $ativo;
	/**
	 * @ORM\ManyToOne(targetEntity="Empregado")
	 * @ORM\JoinColumn(name="supervisor", referencedColumnName="cod_func")
	 */
	protected $supervisorSaad;
	public function getMatricula() {
		return $this->matricula;
	}
	public function setMatricula($matricula) {
		$this->matricula = $matricula;
	}
	public function getNome() {
		return $this->nome;
	}
	public function setNome($nome) {
		$this->nome = $nome;
	}
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
	public function getRamal() {
		return $this->ramal;
	}
	public function setRamal($ramal) {
		$this->ramal = $ramal;
	}
	public function getAtivo() {
		return $this->ativo;
	}
	public function setAtivo($ativo) {
		$this->ativo = ativo;
	}
	public function getSupervisorSaad() {
		return $this->supervisorSaad;
	}
	public function setSupervisorSaad($supervisorSaad) {
		$this->supervisorSaad = $supervisorSaad;
	}
}

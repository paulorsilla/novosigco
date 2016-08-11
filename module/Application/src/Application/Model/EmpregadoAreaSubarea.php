<?php
namespace Application\Model;
 
use Core\Model\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/**
* Entidade EmpregadoAreaSubarea
*
* @category Application
* @package Model
*
* @ORM\Entity
* @ORM\Table(name="empregado_area_subarea")
*/
class EmpregadoAreaSubarea extends Entity
{
	/**
	* @ORM\Id
	* @ORM\Column(type="integer");
	* @ORM\GeneratedValue(strategy="AUTO")
	**/
	protected $id;
	
	/**
	* @ORM\Column(type="string", name="empregado_matricula");
    **/ 
	protected $empregado;
	
 	/**
 	 * @ORM\ManyToOne(targetEntity="Area")
 	 * @ORM\JoinColumn(name="area_id", referencedColumnName="id")
 	 **/ 
 	protected $area;
	
	/**
 	 * @ORM\ManyToOne(targetEntity="Subarea")
 	 * @ORM\JoinColumn(name="subarea_id", referencedColumnName="id")
 	 **/ 
 	protected $subarea;
	
 	/**
 	 * @ORM\Column(type="string", name="data_inicial")
 	 */
 	protected $dataInicial;
	
 	/**
 	 * @ORM\Column(type="string", name="data_final")
 	 */
 	protected $dataFinal;
	
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
	
 	public function getArea() {
 		return $this->area;
 	}
	
 	public function setArea($area) {
 		$this->area = $area;
 	}
	
	public function getSubarea() {
		return $this->subarea;
	}
	
	public function setSubarea($subarea) {
		$this->subarea = $subarea;
	}
	
	public function getDataInicial() {
		return $this->dataInicial;
	}
	
	public function setDataInicial($dataInicial) {
		$this->dataInicial = $dataInicial;
	}
	
	public function getDataFinal() {
		return $this->dataFinal;
	}
	
	public function setDataFinal($dataFinal) {
		$this->dataFinal = $dataFinal;
	}
}

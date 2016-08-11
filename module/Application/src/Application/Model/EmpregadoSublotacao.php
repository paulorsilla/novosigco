<?php
namespace Application\Model;
 
use Core\Model\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/**
* Entidade EmpregadoSublotacao

* @category Application
* @package Model
*
* @ORM\Entity
* @ORM\Table(name="empregado_sublotacao")
*/
class EmpregadoSublotacao extends Entity
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
 	 * @ORM\ManyToOne(targetEntity="Sublotacao")
 	 * @ORM\JoinColumn(name="sublotacao_id", referencedColumnName="id")
 	 **/ 
 	protected $sublotacao;
	
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
	
 	public function getSublotacao() {
 		return $this->sublotacao;
 	}
	
 	public function setSublotacao($sublotacao) {
 		$this->sublotacao = $sublotacao;
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

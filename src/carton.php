<?php

namespace Bingo;

class Carton implements CartonInterface {
	public function __construct($carton){
		$this->numeros_carton = $carton;	
	}

	/**
   * {@inheritdoc}
   */
  public function filas() {
    return $this->numeros_carton;
  }

  /**
   * {@inheritdoc}
   */
  public function columnas() {
    $temp = [[], [], [], [], [], [], [], [], []];
    foreach($this->numeros_carton as $fila){
      $i = 0;
      foreach($fila as $celda){
        $temp[$i++][] = $celda;
      }
    }
    return $temp;
  }

  /**
   * {@inheritdoc}
   */
  public function numerosDelCarton() {
    $numeros = [];
    foreach ($this->filas() as $fila) {
      foreach ($fila as $celda) {
        if ($celda != 0) {
          $numeros[] = $celda;
        }
      }
    }
    return $numeros;
  }

  /**
   * {@inheritdoc}
   */
  public function tieneNumero(int $numero) {
    return in_array($numero, $this->numeros_carton);
  }
}

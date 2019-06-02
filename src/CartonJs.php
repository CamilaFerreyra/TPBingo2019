<?php

namespace Bingo;

/**
 * Este es un Carton generado con:
 * https://github.com/vicmagv/bingo-card-generator/blob/master/generar_carton.js
 */
class CartonJs implements CartonInterface {

  protected $numeros_carton = [];

  public function __construct() {
    $this->numeros_carton = [
      [4,0,24,31,0,51,0,0,81],
      [0,13,0,39,41,0,66,72,0],
      [1,0,27,0,48,0,0,73,86],
    ];
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

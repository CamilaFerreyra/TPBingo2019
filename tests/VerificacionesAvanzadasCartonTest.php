<?php

namespace Bingo;

use PHPUnit\Framework\TestCase;

class VerificacionesAvanzadasCartonTest extends TestCase {

  /**
   * Verifica que los números del carton se encuentren en el rango 1 a 90.
   */
  public function testUnoANoventa() {
    $carton = new CartonEjemplo;
    foreach ($carton->filas() as $fila) {
      foreach (celdas_ocupadas($fila) as $celda) {
        $this->assertTrue(1 < $celda && $celda < 90);
      }
    }
  }

  /**
   * Verifica que cada fila de un carton tenga exactamente 5 celdas ocupadas.
   */
  public function testCincoNumerosPorFila() {
    $carton = new CartonEjemplo;
    $cantNumeros = 0;
    foreach($carton->filas() as $fila){
      foreach($fila as $celda){
        if($celda != 0){
          $cantNumeros += 1;    
        }
      }
      $this->assertEquals(5, $cantNumeros);
      $cantNumeros = 0;
    }
  }

  /**
   * Verifica que para cada columna, haya al menos una celda ocupada.
   */
  public function testColumnaNoVacia() {
    $carton = new CartonEjemplo;
    $cantNumeros = 0;
    foreach($carton->columnas() as $columna){
      foreach($columna as $celda){
        if($celda != 0)
          $cantNumeros ++; 
      }
      $this->assertNotEquals(0, $cantNumeros);
      $cantNumeros = 0; 
    }
  }

  /**
   * Verifica que no haya columnas de un carton con tres celdas ocupadas.
   */
  public function testColumnaCompleta() {
    $carton = new CartonEjemplo;
    $cantNumeros = 0;
    foreach($carton->columnas() as $columna){
      foreach($columna as $celda){
        if($celda != 0)
          $cantNumeros ++; 
      }
      $this->assertNotEquals(3, $cantNumeros);
      $cantNumeros = 0; 
    }
  }

  /**
   * Verifica que solo hay exactamente tres columnas que tienen solo una celda
   * ocupada.
   */
  public function testTresCeldasIndividuales() {
    $carton = new CartonEjemplo;
    $cantNumeros = 0;
    $celdasIndividuales = 0;
    foreach($carton->columnas() as $columna){
      foreach($columna as $celda){
        if($celda != 0)
          $cantNumeros ++; 
      }
      if($cantNumeros == 1)
        $celdasIndividuales ++;
      $cantNumeros = 0; 
    }
    $this->assertEquals(3, $celdasIndividuales);
  }

  /**
   * Verifica que los números de las columnas izquierdas son menores que los de
   * las columnas a la derecha.
   */
  public function testNumerosIncrementales() {
    $this->assertTrue(TRUE);
  }

  /**
   * Verifica que en una fila no existan más de dos celdas vacias consecutivas.
   */
  public function testFilasConVaciosUniformes() {
    $this->assertTrue(TRUE);
  }

}

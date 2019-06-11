<?php
namespace Bingo;
class FabricaCartones {
  public function generarCarton() {
    // Algo de pseudo-código para ayudar con la evaluacion.
    // fallo: deberia hacer un bucle hasta devolver algo valido.
    while(True){
      $carton = $this->intentoCarton();
      if ($this->cartonEsValido($carton)) {
        return $carton;
      }
    }
  }
  protected function cartonEsValido($carton) {
    if ($this->validarUnoANoventa($carton) &&
      $this->validarCincoNumerosPorFila($carton) &&
      $this->validarColumnaNoVacia($carton) &&
      $this->validarColumnaCompleta($carton) &&
      $this->validarTresCeldasIndividuales($carton) &&
      $this->validarNumerosIncrementales($carton) &&
      $this->validarFilasConVaciosUniformes($carton)
    ) {
      return True;
    }
    return False;
  }
  protected function validarUnoANoventa($carton) {
    foreach ($carton->filas() as $fila) {
      foreach (celdas_ocupadas($fila) as $celda) {
        $this->assertTrue(1 <= $celda && $celda <= 90);
      }
    }
  }
  protected function validarCincoNumerosPorFila($carton) {
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
  protected function validarColumnaNoVacia($carton) {
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
  protected function validarColumnaCompleta($carton) {
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
  protected function validarTresCeldasIndividuales($carton) {
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
  protected function validarNumerosIncrementales($carton) {
    $min_columna = 0;
    $max_columna = 10;
    foreach($carton->columnas() as $columna){
      foreach(celdas_ocupadas($columna) as $celda){
        $this->assertTrue($min_columna <= $celda && $celda < $max_columna);
      }

      $min_columna += 10;
      $max_columna += 10;
    }
  }
  protected function validarFilasConVaciosUniformes($carton) {
    foreach($carton->filas() as $fila){
      $anterior = 1;
      $anterior_anterior = 1;
      foreach($fila as $celda){
        $this->assertFalse($anterior == $anterior_anterior && $anterior == $celda && $anterior == 0);

        $anterior_anterior = $anterior;
        $anterior = $celda;
      }
    }
  }
  public function intentoCarton() {
    $contador = 0;
    $carton = [
      [0,0,0],
      [0,0,0],
      [0,0,0],
      [0,0,0],
      [0,0,0],
      [0,0,0],
      [0,0,0],
      [0,0,0],
      [0,0,0]
    ];
    $numerosCarton = 0;
    while ($numerosCarton < 15) {
      $contador++;
      if ($contador == 50) {
        return $this->intentoCarton();
      }
      $numero = rand (1, 90);
      $columna = floor ($numero / 10);
      if ($columna == 9) { $columna = 8;}
      $huecos = 0;
      for ($i = 0; $i<3; $i++) {
        if ($carton[$columna][$i] == 0) {
          $huecos++;
        }
        if ($carton[$columna][$i] == $numero) {
          $huecos = 0;
          break;
        }
      }
      if ($huecos < 2) {
        continue;
      }
      $fila = 0;
      for ($j=0; $j<3; $j++) {
        $huecos = 0;
        for ($i = 0; $i<9; $i++) {
          if ($carton[$i][$fila] == 0) { $huecos++; }
        }
        if ($huecos < 5 || $carton[$columna][$fila] != 0) {
          $fila++;
        } else{
          break;
        }
      }
      if ($fila == 3) {
        continue;
      }
      $carton[$columna][$fila] = $numero;
      $numerosCarton++;
      $contador = 0;
    }
    for ( $x = 0; $x < 9; $x++) {
      $huecos = 0;
      for ($y =0; $y < 3; $y ++) {
        if ($carton[$x][$y] == 0) { $huecos++;}
      }
      if ($huecos == 3) {
        return $this->intentoCarton();
      }
    }
    return $carton;
  }
}

<?php
namespace Bingo;
class FabricaCartones {
  public function generarCarton() {
    // Algo de pseudo-código para ayudar con la evaluacion.
    // fallo: deberia hacer un bucle hasta devolver algo valido.
    for($i=0; $i<10; $i++){
      $carton = $this->intentoCarton();
      $carton = (new Carton($carton))->columnas();
      if ($this->cartonEsValido($carton)) {
        return $carton;
      }
    }
    return Null;
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
    foreach ($carton as $fila) {
      foreach (celdas_ocupadas($fila) as $celda) {
        if(!(1 <= $celda && $celda <= 90))
          return False;
      }
    }
    return True;
  }
  protected function validarCincoNumerosPorFila($carton) {
    $cantNumeros = 0;
    foreach($carton as $fila){
      foreach($fila as $celda){
        if($celda != 0){
          $cantNumeros += 1;    
        }
      }
      if(5 != $cantNumeros)
        return False;
      $cantNumeros = 0;
    }
    return True;
  }
  protected function validarColumnaNoVacia($carton) {
    $cantNumeros = 0;
    foreach($carton as $columna){
      foreach($columna as $celda){
        if($celda != 0)
          $cantNumeros ++; 
      }
      if (0 == $cantNumeros)
        return False;
      $cantNumeros = 0; 
    }
    return True;
  }
  protected function validarColumnaCompleta($carton) {
    $cantNumeros = 0;
    foreach($carton as $columna){
      foreach($columna as $celda){
        if($celda != 0)
          $cantNumeros ++; 
      }
      if(3 == $cantNumeros)
        return False;
      $cantNumeros = 0; 
    }
    return True;
  }
  protected function validarTresCeldasIndividuales($carton) {
    $cantNumeros = 0;
    $celdasIndividuales = 0;
    foreach($carton as $columna){
      foreach($columna as $celda){
        if($celda != 0)
          $cantNumeros ++; 
      }
      if($cantNumeros == 1)
        $celdasIndividuales ++;
      $cantNumeros = 0; 
    }
    return (3 == $celdasIndividuales);
  }
  protected function validarNumerosIncrementales($carton) {
    $min_columna = 0;
    $max_columna = 10;
    foreach($carton as $columna){
      foreach(celdas_ocupadas($columna) as $celda){
        if(!($min_columna <= $celda && $celda < $max_columna))
          return False;
      }

      $min_columna += 10;
      $max_columna += 10;
    }
    return True;
  }
  protected function validarFilasConVaciosUniformes($carton) {
    foreach($carton as $fila){
      $anterior = 1;
      $anterior_anterior = 1;
      foreach($fila as $celda){
        if(!($anterior == $anterior_anterior && $anterior == $celda && $anterior == 0))
          return False;

        $anterior_anterior = $anterior;
        $anterior = $celda;
      }
    }
    return True;
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

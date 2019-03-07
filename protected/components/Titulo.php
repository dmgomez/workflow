<?php

class Titulo
{
	private $titulo;
    private $tituloPlural;
    private $sexo;
	
	public function Titulo($titulo, $tituloPlural, $sexo)
	{
		$this->titulo = $titulo;
		$this->tituloPlural = $tituloPlural;
		$this->sexo = $sexo;
	}	

	public function getTitulo($articulo = false, $plural = false)
    {
        $pri = "";
        $seg = $this->titulo;
        
        if ($articulo == true)
        {
            if ($this->sexo == "f")
                $pri = Constantes::articulof. " ";
            else if ($this->sexo == "m")
                $pri = Constantes::articulom. " ";
        }
        if ($plural == true)
        {
            $seg = $this->tituloPlural;
            if ($articulo == true)
            {
                if ($this->sexo == "f")
                    $pri = Constantes::articulosf. " ";
                else if ($this->sexo == "m")
                    $pri = Constantes::articulosm. " ";
            }
        }
        return $pri . $seg;
        
    }
	
}

?>
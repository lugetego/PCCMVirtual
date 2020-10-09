<?php

namespace App\Entity;

use App\Repository\RegistroRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=RegistroRepository::class)
 * @UniqueEntity("correo")
 * @ORM\HasLifecycleCallbacks()
 */
class Registro
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apellidos;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nacionalidad;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $correo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $residencia;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estudiante;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $grado;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $programa;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $institucion;

    /**
     * @Gedmo\Slug(fields={"nombre", "apellidos"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedAt", type="datetime", nullable=true)
     */
    private $modifiedAt;

   
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $aceptado;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $confirmado;

    /**
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $comentarios;




    public function getId(): ?int
    {
        return $this->id;
    }

public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
{
    $this->nombre = $nombre;

    return $this;
}

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
{
    $this->apellidos = $apellidos;

    return $this;
}

    public function getNacionalidad(): ?string
    {
        return $this->nacionalidad;
    }

    public function setNacionalidad(string $nacionalidad): self
{
    $this->nacionalidad = $nacionalidad;

    return $this;
}

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): self
{
    $this->correo = $correo;

    return $this;
}

    public function getResidencia(): ?string
    {
        return $this->residencia;
    }

    public function setResidencia(string $residencia): self
{
    $this->residencia = $residencia;

    return $this;
}

    public function getEstudiante(): ?bool
    {
        return $this->estudiante;
    }

    public function setEstudiante(bool $estudiante): self
{
    $this->estudiante = $estudiante;

    return $this;
}

    public function getGrado(): ?string
    {
        return $this->grado;
    }

    public function setGrado(string $grado): self
{
    $this->grado = $grado;

    return $this;
}

    public function getPrograma(): ?string
    {
        return $this->programa;
    }

    public function setPrograma(string $programa): self
{
    $this->programa = $programa;

    return $this;
}

    public function getInstitucion(): ?string
    {
        return $this->institucion;
    }

    public function setInstitucion(string $institucion): self
{
    $this->institucion = $institucion;

    return $this;
}

 public function getSlug()
{
    return $this->slug;
}

/**
 * Set createdAt
 *
 * @param \DateTime $createdAt
 *
 * @return Registro
 */
    public function setCreatedAt($createdAt)
{
    $this->createdAt = $createdAt;

    return $this;
}

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
{
    return $this->createdAt;
}

  /**
   * @return \DateTime
   */
    public function getModifiedAt()
{
    return $this->modifiedAt;
}

    /**
     * @param \DateTime $modifiedAt
     */
    public function setModifiedAt($modifiedAt)
{
    $this->modifiedAt = $modifiedAt;
}

/**
 * @ORM\PrePersist
 */
    public function prePersist()
{
    $this->setCreatedAt(new \DateTime());
    $this->setModifiedAt(new \DateTime());
}


    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
{
    $this->setModifiedAt(new \DateTime());
}

 public function getAceptado(): ?bool
    {
        return $this->aceptado;
    }

    public function setAceptado(bool $aceptado): self
{
    $this->aceptado = $aceptado;

    return $this;
}

 public function getConfirmado(): ?bool
    {
        return $this->confirmado;
    }

    public function setConfirmado(bool $confirmado): self
{
    $this->confirmado = $confirmado;

    return $this;
}

public function getComentarios(): ?string
    {
        return $this->comentarios;
    }

    public function setComentarios(string $comentarios): self
{
    $this->comentarios = $comentarios;

    return $this;
}


}



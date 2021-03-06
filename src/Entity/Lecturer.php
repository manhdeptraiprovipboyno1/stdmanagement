<?php

namespace App\Entity;

use App\Entity\ClassM;
use App\Entity\Subject;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LecturerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=LecturerRepository::class)
 */
class Lecturer
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
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Subject::class, mappedBy="lecturer")
     */
    private $subjectList;

    /**
     * @ORM\ManyToMany(targetEntity=ClassM::class, mappedBy="lecturer")
     */
    private $ClassList;

    public function __construct()
    {
        $this->subjectList = new ArrayCollection();
        $this->ClassList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar( $avatar)
    {   
        if($avatar != null){
            $this->avatar = $avatar;
        }
        

        return $this;
    }

    /**
     * @return Collection|Subject[]
     */
    public function getSubjectList(): Collection
    {
        return $this->subjectList;
    }

    public function addSubjectList(Subject $subjectList): self
    {
        if (!$this->subjectList->contains($subjectList)) {
            $this->subjectList[] = $subjectList;
            $subjectList->setLecturer($this);
        }

        return $this;
    }

    public function removeSubjectList(Subject $subjectList): self
    {
        if ($this->subjectList->removeElement($subjectList)) {
            // set the owning side to null (unless already changed)
            if ($subjectList->getLecturer() === $this) {
                $subjectList->setLecturer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ClassM[]
     */
    public function getClassList(): Collection
    {
        return $this->ClassList;
    }

    public function addClassList(ClassM $classList): self
    {
        if (!$this->ClassList->contains($classList)) {
            $this->ClassList[] = $classList;
            $classList->addLecturer($this);
        }

        return $this;
    }

    public function removeClassList(ClassM $classList): self
    {
        if ($this->ClassList->removeElement($classList)) {
            $classList->removeLecturer($this);
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
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
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Technology::class, inversedBy="courses")
     */
    private $technology;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="courses")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $houres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $difficulte;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="course" ,cascade={"persist"})
     */
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity=Progress::class, mappedBy="course")
     */
    private $Progresses;

    /**
     * @ORM\OneToMany(targetEntity=EtatCourse::class, mappedBy="course")
     */
    private $etatcourse;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="course")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="favorit")
     */
    private $favorit;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="follow")
     */
    private $follows;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer" , nullable=true)
     */
    private $views;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $language;

 

  

    public function __construct()
    {
        $this->Progresses = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->etatcourse = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->favorit = new ArrayCollection();
        $this->follows = new ArrayCollection();
       
       
    }

    public function getAvgRating(){

        $sum = array_reduce($this->comments->toArray(),function($total,$comment){
            return $total +$comment->getRating();

        },0);

        if(count($this->comments) > 0) return $moyenne=$sum / count($this->comments);

        return 0;
    }

 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTechnology(): ?Technology
    {
        return $this->technology;
    }

    public function setTechnology(?Technology $technology): self
    {
        $this->technology = $technology;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getHoures(): ?string
    {
        return $this->houres;
    }

    public function setHoures(string $houres): self
    {
        $this->houres = $houres;

        return $this;
    }

    public function getDifficulte(): ?string
    {
        return $this->difficulte;
    }

    public function setDifficulte(string $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setCourse($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getCourse() === $this) {
                $video->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Progress>
     */
    public function getProgresses(): Collection
    {
        return $this->Progresses;
    }

    public function addProgress(Progress $progress): self
    {
        if (!$this->Progresses->contains($progress)) {
            $this->Progresses[] = $progress;
            $progress->setCourse($this);
        }

        return $this;
    }

    public function removeProgress(Progress $progress): self
    {
        if ($this->Progresses->removeElement($progress)) {
            // set the owning side to null (unless already changed)
            if ($progress->getCourse() === $this) {
                $progress->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtatCourse>
     */
    public function getEtatcourse(): Collection
    {
        return $this->etatcourse;
    }

    public function addEtatcourse(EtatCourse $etatcourse): self
    {
        if (!$this->etatcourse->contains($etatcourse)) {
            $this->etatcourse[] = $etatcourse;
            $etatcourse->setCourse($this);
        }

        return $this;
    }

    public function removeEtatcourse(EtatCourse $etatcourse): self
    {
        if ($this->etatcourse->removeElement($etatcourse)) {
            // set the owning side to null (unless already changed)
            if ($etatcourse->getCourse() === $this) {
                $etatcourse->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setCourse($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCourse() === $this) {
                $comment->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavorit(): Collection
    {
        return $this->favorit;
    }

    public function addFavorit(User $favorit): self
    {
        if (!$this->favorit->contains($favorit)) {
            $this->favorit[] = $favorit;
        }

        return $this;
    }

    public function removeFavorit(User $favorit): self
    {
        $this->favorit->removeElement($favorit);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFollows(): Collection
    {
        return $this->follows;
    }

    public function addFollow(User $follow): self
    {
        if (!$this->follows->contains($follow)) {
            $this->follows[] = $follow;
            $follow->addFollow($this);
        }

        return $this;
    }

    public function removeFollow(User $follow): self
    {
        if ($this->follows->removeElement($follow)) {
            $follow->removeFollow($this);
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

   
   
}

<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;





    #[ORM\ManyToMany(targetEntity: Categorie::class, mappedBy: 'articles')]
    private Collection $categories;

//    #[ORM\ManyToOne(inversedBy: 'articles')]
//    private ?Commentaire $commantaires = null;
    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Commentaire::class)]
    private Collection $commentaires;
    #[ORM\OneToMany(mappedBy: 'articles', targetEntity: Utilisateur::class)]
    private Collection $utilisateurs;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;



    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'motsCles')]
    private Collection $articles;

    #[ORM\ManyToMany(targetEntity: MotsCles::class, inversedBy: 'articles')]
    private Collection $motsCles;



    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->motsCles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }







    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }





//    public function getCommantaires(): ?Commentaire
//    {
//        return $this->commantaires;
//    }

//    public function setCommantaires(?Commentaire $commantaires): static
//    {
//        $this->commantaires = $commantaires;
//
//        return $this;
//    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->setArticles($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getArticles() === $this) {
                $utilisateur->setArticles(null);
            }
        }

        return $this;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

//    public function addCommentaire(Commentaire $commentaire): static
//    {
//        if (!$this->commentaires->contains($commentaire)) {
//            $this->commentaires->add($commentaire);
//            $commentaire->setArticle($this);
//        }
//
//        return $this;
//    }

//    public function removeCommentaire(Commentaire $commentaire): static
//    {
//        if ($this->commentaires->removeElement($commentaire)) {
//            // Définir le côté propriétaire à null (sauf si déjà modifié)
//            if ($commentaire->getArticle() === $this) {
//                $commentaire->setArticle(null);
//            }
//        }
//
//        return $this;
//    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setArticle($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            if ($commentaire->getArticle() === $this) {
                $commentaire->setArticle(null);
            }
        }

        return $this;
    }





    /**
     * @return Collection<int, self>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(self $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
        }

        return $this;
    }

    public function removeArticle(self $article): static
    {
        if ($this->articles->removeElement($article)) {
        }

        return $this;
    }

    /**
     * @return Collection<int, MotsCles>
     */
    public function getMotsCles(): Collection
    {
        return $this->motsCles;
    }

    public function addMotsCle(MotsCles $motsCle): static
    {
        if (!$this->motsCles->contains($motsCle)) {
            $this->motsCles->add($motsCle);
        }

        return $this;
    }

    public function removeMotsCle(MotsCles $motsCle): static
    {
        $this->motsCles->removeElement($motsCle);

        return $this;
    }





}

<?php

namespace App\Entity;

use DateTime;


class Offre
{
    private ?int $id = null;
    private ?DateTime $dateCandidature = null;
    private string $entreprise;
    private string $lieu;
    private ?string $description = null;
    private string $url;
    private ?string $contact = null;
    private ?string $reponse = null;
    private ?DateTime $reponse_at = null;
    private ?string $lettreMotivation = null;
    private ?string $type = null;

    private ?string $relance = 'non';
    private ?Datetime $relanceAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getDateCandidature(): ?DateTime
    {
        return $this->dateCandidature;
    }

    public function setDateCandidature(?DateTime $dateCandidature): self
    {
        $this->dateCandidature = $dateCandidature;
        return $this;
    }


    public function getDateReponse(): ?DateTime
    {
        return $this->reponse_at;
    }

    public function setDateReponse(?DateTime $reponse_at = null): self
    {
        $this->reponse_at = $reponse_at;
        return $this;
    }

    public function getEntreprise(): string
    {
        return $this->entreprise;
    }

    public function setEntreprise(string $entreprise): self
    {
        $this->entreprise = $entreprise;
        return $this;
    }

    public function getLieu(): string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;
        return $this;
    }

    public function  getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;
        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;
        return $this;
    }
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'dateCandidature' => $this->dateCandidature,
            'entreprise' => $this->entreprise,
            'lieu' => $this->lieu,
            'description' => $this->description,
            'url' => $this->url,
            'contact' => $this->contact,
            'reponse' => $this->reponse,
            'reponse_at' => $this->reponse_at,
            'lettreMotivation' => $this->lettreMotivation,
            'type' => $this->type,
            'relance' => $this->relance,
            'relanceAt' => $this->relanceAt,
        ];
    }

    /**
     * Get the value of lettreMotivation
     */
    public function getLettreMotivation()
    {
        return $this->lettreMotivation ? $this->lettreMotivation : 'non';
    }

    /**
     * Set the value of lettreMotivation
     *
     * @return  self
     */
    public function setLettreMotivation($lettreMotivation)
    {
        $this->lettreMotivation = $lettreMotivation;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType(): string
    {
        return $this->type ? $this->type : 'Informatique';
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of relance
     */
    public function getRelance()
    {
        return $this->relance;
    }

    /**
     * Set the value of relance
     *
     * @return  self
     */
    public function setRelance($relance)
    {
        $this->relance = $relance;

        return $this;
    }

    /**
     * Get the value of relanceAt
     */
    public function getRelanceAt()
    {
        return $this->relanceAt;
    }

    /**
     * Set the value of relanceAt
     *
     * @return  self
     */
    public function setRelanceAt($relanceAt)
    {
        $this->relanceAt = $relanceAt;

        return $this;
    }
}

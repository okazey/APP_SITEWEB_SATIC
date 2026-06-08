# Dictionnaire de Données - Projet Site Web UFR SATIC

> **Version 1.1** — Structure hybride emplois du temps (PDF + relationnel)

Ce document contient la spécification physique de chaque table de la base de données relationnelle du site de l'UFR SATIC (14 tables).

---

## 1. Table : `roles`
Stocke les rôles de sécurité de la plateforme.

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique du rôle |
| `nom` | `VARCHAR(50)` | Non | Unique | Nom du rôle ('administrateur', 'enseignant', 'etudiant', etc.) |
| `description` | `VARCHAR(255)` | Oui | - | Description des privilèges du rôle |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création du rôle |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de dernière mise à jour |

---

## 2. Table : `utilisateurs`
Table centrale pour tous les comptes utilisateurs (Authentification).

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique de l'utilisateur |
| `nom` | `VARCHAR(100)` | Non | - | Nom complet de l'utilisateur |
| `email` | `VARCHAR(150)` | Non | Unique | Adresse email unique (sert de login) |
| `email_verified_at`| `TIMESTAMP` | Oui | - | Date de vérification de l'adresse email |
| `mot_de_passe` | `VARCHAR(255)` | Non | - | Mot de passe chiffré (bcrypt) |
| `role_id` | `INT UNSIGNED` | Non | FK -> `roles.id` | Rôle de l'utilisateur |
| `remember_token` | `VARCHAR(100)` | Oui | - | Token de session "Se souvenir de moi" (Laravel) |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création du compte |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de dernière mise à jour |

---

## 3. Table : `departements`
Représente les départements de l'UFR SATIC.

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique du département |
| `nom` | `VARCHAR(100)` | Non | Unique | Nom officiel (ex: 'Sciences Appliquées...') |
| `code` | `VARCHAR(10)` | Non | Unique | Code court (ex: 'SATIC', 'MATH') |
| `description` | `TEXT` | Oui | - | Présentation détaillée du département |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de mise à jour |

---

## 4. Table : `formations`
Offres de formations disponibles à l'UFR (Licences, Masters).

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique de la formation |
| `nom` | `VARCHAR(150)` | Non | - | Nom de la formation (ex: 'Licence D2A') |
| `code` | `VARCHAR(20)` | Non | Unique | Code unique (ex: 'L-D2A') |
| `diplome` | `ENUM` | Non | - | Type de diplôme ('Licence', 'Master', 'Doctorat') |
| `duree_annees` | `TINYINT UNSIGNED`| Non | - | Durée de la formation (ex: 3 pour Licence) |
| `departement_id` | `INT UNSIGNED` | Non | FK -> `departements.id` | Département de rattachement |
| `conditions_admission`| `TEXT` | Oui | - | Critères d'entrée |
| `debouches` | `TEXT` | Oui | - | Opportunités de carrière professionnelles |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de mise à jour |

---

## 5. Table : `enseignants`
Profils étendus pour les enseignants (permanents et vacataires).

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique du profil enseignant |
| `utilisateur_id` | `INT UNSIGNED` | Non | FK -> `utilisateurs.id` (Unique)| Lien vers le compte utilisateur associé |
| `specialite` | `VARCHAR(150)` | Non | - | Domaine d'expertise (ex: 'Génie Logiciel') |
| `bio` | `TEXT` | Oui | - | Biographie, publications, présentation |
| `photo_path` | `VARCHAR(255)` | Oui | - | Chemin relatif vers la photo de profil |
| `bureau` | `VARCHAR(50)` | Oui | - | Localisation physique du bureau |
| `departement_id` | `INT UNSIGNED` | Non | FK -> `departements.id` | Département d'affectation principal |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de mise à jour |

---

## 6. Table : `etudiants`
Profils étendus pour les étudiants inscrits.

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique du profil étudiant |
| `utilisateur_id` | `INT UNSIGNED` | Non | FK -> `utilisateurs.id` (Unique)| Lien vers le compte utilisateur associé |
| `matricule` | `VARCHAR(20)` | Non | Unique | Numéro d'étudiant unique (matricule UADB) |
| `niveau` | `ENUM` | Non | - | Année d'études ('L1', 'L2', 'L3', 'M1', 'M2') |
| `formation_id` | `INT UNSIGNED` | Non | FK -> `formations.id` | Formation suivie par l'étudiant |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de mise à jour |

---

## 7. Table : `emplois_du_temps`
**Structure HYBRIDE** : sert à la fois de référentiel pour le téléchargement du PDF hebdomadaire et de parent relationnel pour les créneaux horaires saisis en base.

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique de l'EDT |
| `formation_id` | `INT UNSIGNED` | Non | FK -> `formations.id` | Formation concernée |
| `niveau` | `ENUM` | Non | - | Niveau d'études ('L1'...'M2') |
| `annee_universitaire` | `VARCHAR(9)` | Non | - | Année académique (ex: '2025-2026') |
| `semestre` | `ENUM` | Non | - | Semestre concerné ('S1', 'S2') |
| `semaine_numero` | `TINYINT UNSIGNED` | Oui | - | Numéro ISO de la semaine (1-53) |
| `date_debut_semaine` | `DATE` | Non | UK | Date du lundi représentant la semaine |
| `date_fin_semaine` | `DATE` | Non | - | Date du vendredi correspondant |
| `fichier_path` | `VARCHAR(255)` | **Oui** | - | Chemin du PDF sur le serveur (NULL si mode purement relationnel) |
| `fichier_nom_original`| `VARCHAR(255)` | Oui | - | Nom original du fichier uploadé (ex: EDT_L3-D2A_S1_Sem38.pdf) |
| `mode` | `ENUM` | Non | - | Mode de gestion : `'pdf'` (PDF seul) / `'relationnel'` (créneaux BDD) / `'hybride'` (les deux) |
| `est_publie` | `BOOLEAN` | Non | - | `TRUE` = visible par les étudiants |
| `editeur_id` | `INT UNSIGNED` | Non | FK -> `utilisateurs.id` | Personne administrative ayant créé ou uploadé l'EDT |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de mise à jour |

> **Contrainte d'intégrité** : la combinaison `(formation_id, niveau, date_debut_semaine)` est unique — un seul EDT par classe et par semaine.

---

## 8. Table : `matieres`
Référentiel des matières / Unités d'Enseignement (UE) disposées dans les formations.

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique de la matière |
| `code` | `VARCHAR(20)` | Non | Unique | Code UE officiel (ex: 'INF301', 'MATH201') |
| `intitule` | `VARCHAR(150)` | Non | - | Libellé complet (ex: 'Algorithmique et Structures de Données') |
| `credits_ects` | `TINYINT UNSIGNED` | Oui | - | Nombre de crédits ECTS attribués à l'UE |
| `type` | `ENUM` | Non | - | Type de séance principale ('CM', 'TD', 'TP', 'Projet', 'Examen', 'Autre') |
| `formation_id` | `INT UNSIGNED` | Non | FK -> `formations.id` | Formation à laquelle appartient l'UE |
| `niveau` | `ENUM` | Non | - | Année d'études de l'UE ('L1'...'M2') |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de mise à jour |

---

## 9. Table : `creneaux_horaires`
Gestion heure par heure des séances de cours. Chaque ligne représente **une séance précise** (matière + salle + enseignant + horaire) pour un emploi du temps parent.

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique du créneau |
| `edt_id` | `INT UNSIGNED` | Non | FK -> `emplois_du_temps.id` | EDT parent auquel appartient ce créneau |
| `matiere_id` | `INT UNSIGNED` | Non | FK -> `matieres.id` | Matière enseignée pendant ce créneau |
| `enseignant_id` | `INT UNSIGNED` | Non | FK -> `enseignants.id` | Enseignant responsable de la séance |
| `jour` | `ENUM` | Non | - | Jour de la semaine ('Lundi' à 'Samedi') |
| `heure_debut` | `TIME` | Non | - | Heure de début de la séance (ex: '08:00:00') |
| `heure_fin` | `TIME` | Non | - | Heure de fin de la séance (ex: '10:00:00') |
| `salle` | `VARCHAR(50)` | Oui | - | Salle ou amphi réservé(e) (ex: 'Amphi A', 'Salle Info 3') |
| `type_seance` | `ENUM` | Non | - | Type du créneau ('CM', 'TD', 'TP', 'Examen', 'Projet', 'Autre') |
| `est_annule` | `BOOLEAN` | Non | - | `TRUE` = séance annulée (soft delete) |
| `motif_annulation` | `VARCHAR(255)` | Oui | - | Raison de l'annulation si `est_annule = TRUE` |
| `commentaire` | `VARCHAR(255)` | Oui | - | Note libre pour la séance (ex: 'Salle de secours : B201') |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de mise à jour |

> **Contrainte anti-doublon** : un enseignant ne peut pas avoir deux séances simultanées dans un même EDT `(enseignant_id, jour, heure_debut, edt_id)` — Unique Key.
> **Contrainte CHECK** : `heure_fin > heure_debut` — l'heure de fin doit toujours être ultérieure à l'heure de début.

---

## 10. Table : `annonces`
Flux d'annonces pédagogiques publiées par les enseignants.

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique de l'annonce |
| `titre` | `VARCHAR(150)` | Non | - | Titre abrégé de l'annonce |
| `contenu` | `TEXT` | Non | - | Texte complet de l'annonce |
| `fichier_joint_path`| `VARCHAR(255)` | Oui | - | Chemin vers une pièce jointe optionnelle (PDF, image) |
| `formation_id` | `INT UNSIGNED` | Non | FK -> `formations.id` | Formation ciblée par l'annonce |
| `niveau` | `ENUM` | Oui | - | Niveau ciblé (ex: 'L3'). Si NULL, cible tout le cursus |
| `enseignant_id` | `INT UNSIGNED` | Non | FK -> `enseignants.id` | Enseignant auteur de l'annonce |
| `statut` | `ENUM` | Non | - | Statut de visibilité ('brouillon', 'publie') |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de mise à jour |

---

## 11. Table : `actualites`
Actualités générales de l'établissement (publiques).

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique de l'actualité |
| `titre` | `VARCHAR(150)` | Non | - | Titre accrocheur de l'actu |
| `contenu` | `TEXT` | Non | - | Corps de l'actualité (format HTML/Markdown supporté) |
| `image_path` | `VARCHAR(255)` | Oui | - | Bannière ou image illustrative principale |
| `auteur_id` | `INT UNSIGNED` | Non | FK -> `utilisateurs.id` | Rédacteur de l'actualité (admin/scolarité) |
| `est_epinglee` | `BOOLEAN` | Non | - | Permet d'épingler l'actualité en bandeau d'accueil |
| `statut` | `ENUM` | Non | - | Statut de publication ('brouillon', 'publie') |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de mise à jour |

---

## 12. Table : `documents`
Bibliothèque de fichiers administratifs téléchargeables en libre-service.

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique du document |
| `titre` | `VARCHAR(150)` | Non | - | Titre ou nom du formulaire |
| `description` | `TEXT` | Oui | - | Description de l'usage du document |
| `fichier_path` | `VARCHAR(255)` | Non | - | Chemin relatif de stockage du fichier |
| `categorie` | `ENUM` | Non | - | Catégorie ('scolarite', 'examens', 'inscriptions', 'autre') |
| `editeur_id` | `INT UNSIGNED` | Non | FK -> `utilisateurs.id` | Utilisateur ayant publié le document |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de mise à jour |

---

## 13. Table : `demandes_administratives`
Suivi et traitement des demandes administratives en ligne.

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique de la demande |
| `etudiant_id` | `INT UNSIGNED` | Non | FK -> `etudiants.id` | Étudiant émetteur de la demande |
| `type` | `ENUM` | Non | - | Type de document ('attestation_scolarite', 'releve_notes', 'certificat_inscription') |
| `statut` | `ENUM` | Non | - | État du dossier ('en_attente', 'en_cours', 'traite', 'rejete') |
| `motifs_rejet` | `TEXT` | Oui | - | Renseigné par l'administration si rejeté |
| `fichier_reponse_path`| `VARCHAR(255)`| Oui | - | PDF final signé électroniquement téléchargeable par l'étudiant |
| `date_demande` | `TIMESTAMP` | Non | - | Date de la soumission de la demande |
| `date_traitement` | `TIMESTAMP` | Oui | - | Date à laquelle le statut passe à 'traite' ou 'rejete' |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de mise à jour |

---

## 14. Table : `parametres_site`
Configuration dynamique globale pour éviter les données codées en dur (Hardcoded).

| Colonne | Type | Nullable | Clé | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT UNSIGNED` | Non | PK (Auto-Increment) | Identifiant unique du paramètre |
| `cle` | `VARCHAR(100)` | Non | Unique | Clé de configuration (ex: 'contact_telephone', 'horaire_secretariat') |
| `valeur` | `TEXT` | Oui | - | Valeur textuelle associée |
| `description` | `VARCHAR(255)` | Oui | - | Rôle ou description de ce paramètre |
| `created_at` | `TIMESTAMP` | Oui | - | Date de création |
| `updated_at` | `TIMESTAMP` | Oui | - | Date de mise à jour |

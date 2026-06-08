-- =============================================================================
-- BASE DE DONNEES : UFR SATIC (UADB)
-- Script de création du schéma physique SQL (MySQL/MariaDB)
-- Projet de Mémoire L3 D2A - Juin 2026
-- Version : 1.1 - Structure hybride emplois du temps (PDF + relationnel)
-- =============================================================================

CREATE DATABASE IF NOT EXISTS ufr_satic_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ufr_satic_db;

-- Désactiver les vérifications de clés étrangères pour la création
SET FOREIGN_KEY_CHECKS = 0;

-- =============================================================================
-- 1. TABLE : roles
-- Rôles utilisateurs : administrateur, editeur_scolarite, enseignant, etudiant
-- =============================================================================
DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE, -- ex: 'administrateur', 'enseignant'
    description VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================================================================
-- 2. TABLE : utilisateurs
-- Table principale d'authentification pour tous les profils
-- =============================================================================
DROP TABLE IF EXISTS utilisateurs;
CREATE TABLE utilisateurs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role_id INT UNSIGNED NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_utilisateurs_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- =============================================================================
-- 3. TABLE : departements
-- Départements académiques (ex: Informatique, Mathématiques, LSH)
-- =============================================================================
DROP TABLE IF EXISTS departements;
CREATE TABLE departements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    code VARCHAR(10) NOT NULL UNIQUE, -- ex: 'SATIC', 'MATH'
    description TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================================================================
-- 4. TABLE : formations
-- Offres de formation (Licences, Masters)
-- =============================================================================
DROP TABLE IF EXISTS formations;
CREATE TABLE formations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL, -- ex: "Licence Droit et Administration d'Applications (D2A)"
    code VARCHAR(20) NOT NULL UNIQUE, -- ex: 'L-D2A', 'M-SI'
    diplome ENUM('Licence', 'Master', 'Doctorat') NOT NULL,
    duree_annees TINYINT UNSIGNED NOT NULL DEFAULT 3,
    departement_id INT UNSIGNED NOT NULL,
    conditions_admission TEXT NULL,
    debouches TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_formations_departement FOREIGN KEY (departement_id) REFERENCES departements(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================================================================
-- 5. TABLE : enseignants
-- Profils spécifiques des enseignants (permanents et vacataires)
-- =============================================================================
DROP TABLE IF EXISTS enseignants;
CREATE TABLE enseignants (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT UNSIGNED NOT NULL UNIQUE,
    specialite VARCHAR(150) NOT NULL, -- ex: "Génie Logiciel", "Réseaux"
    bio TEXT NULL,
    photo_path VARCHAR(255) NULL,
    bureau VARCHAR(50) NULL, -- ex: "Bâtiment A, Bureau 12"
    departement_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_enseignants_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    CONSTRAINT fk_enseignants_departement FOREIGN KEY (departement_id) REFERENCES departements(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- =============================================================================
-- 6. TABLE : etudiants
-- Profils spécifiques des étudiants inscrits
-- =============================================================================
DROP TABLE IF EXISTS etudiants;
CREATE TABLE etudiants (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT UNSIGNED NOT NULL UNIQUE,
    matricule VARCHAR(20) NOT NULL UNIQUE, -- Numéro de carte d'étudiant
    niveau ENUM('L1', 'L2', 'L3', 'M1', 'M2') NOT NULL,
    formation_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_etudiants_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    CONSTRAINT fk_etudiants_formation FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- =============================================================================
-- 7. TABLE : emplois_du_temps
-- Structure HYBRIDE : stocke à la fois un lien vers le PDF téléchargeable
-- ET sert de référence parente pour les créneaux horaires relationnels.
-- Un emploi du temps couvre une semaine donnée pour une formation/niveau.
-- =============================================================================
DROP TABLE IF EXISTS emplois_du_temps;
CREATE TABLE emplois_du_temps (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    formation_id INT UNSIGNED NOT NULL,
    niveau ENUM('L1', 'L2', 'L3', 'M1', 'M2') NOT NULL,
    annee_universitaire VARCHAR(9) NOT NULL,            -- ex: '2025-2026'
    semestre ENUM('S1', 'S2') NOT NULL,                -- Semestre concerné
    semaine_numero TINYINT UNSIGNED NULL,               -- Numéro de semaine ISO (1-53)
    date_debut_semaine DATE NOT NULL,                   -- Date du lundi concerné
    date_fin_semaine DATE NOT NULL,                     -- Date du vendredi concerné
    -- Gestion du PDF (téléchargement direct)
    fichier_path VARCHAR(255) NULL,                     -- Chemin du PDF uploadé sur le serveur (NULL si saisie uniquement relationnelle)
    fichier_nom_original VARCHAR(255) NULL,             -- Nom original du fichier (ex: EDT_L3-D2A_S1_Sem38.pdf)
    -- Mode de saisie
    mode ENUM('pdf', 'relationnel', 'hybride') NOT NULL DEFAULT 'pdf', -- 'pdf' = PDF seul, 'relationnel' = créneaux en BDD, 'hybride' = les deux
    est_publie BOOLEAN NOT NULL DEFAULT FALSE,          -- TRUE = visible par les étudiants
    editeur_id INT UNSIGNED NOT NULL,                   -- Utilisateur (scolarité/admin) ayant créé/uploadé
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_edt_formation FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE CASCADE,
    CONSTRAINT fk_edt_editeur FOREIGN KEY (editeur_id) REFERENCES utilisateurs(id) ON DELETE RESTRICT,
    -- Unicité : un seul EDT par classe/semaine
    UNIQUE KEY uk_edt_classe_semaine (formation_id, niveau, date_debut_semaine)
) ENGINE=InnoDB;

-- =============================================================================
-- 8. TABLE : matieres
-- Référentiel des matières/UE enseignées dans chaque formation
-- =============================================================================
DROP TABLE IF EXISTS matieres;
CREATE TABLE matieres (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,                   -- ex: 'INF301', 'MATH201'
    intitule VARCHAR(150) NOT NULL,                     -- ex: 'Algorithmique et Structures de Données'
    credits_ects TINYINT UNSIGNED NULL,                 -- Crédits ECTS de l'UE
    type ENUM('CM', 'TD', 'TP', 'Projet', 'Examen', 'Autre') NOT NULL DEFAULT 'CM',
    formation_id INT UNSIGNED NOT NULL,
    niveau ENUM('L1', 'L2', 'L3', 'M1', 'M2') NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_matieres_formation FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================================================================
-- 9. TABLE : creneaux_horaires
-- Gestion heure par heure des cours : table enfant de emplois_du_temps.
-- Chaque ligne = une séance précise (matière, salle, enseignant, heure).
-- =============================================================================
DROP TABLE IF EXISTS creneaux_horaires;
CREATE TABLE creneaux_horaires (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    edt_id INT UNSIGNED NOT NULL,                       -- Référence à l'emploi du temps parent
    matiere_id INT UNSIGNED NOT NULL,                   -- Matière enseignée
    enseignant_id INT UNSIGNED NOT NULL,                -- Enseignant responsable
    jour ENUM('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi') NOT NULL,
    heure_debut TIME NOT NULL,                          -- ex: '08:00:00'
    heure_fin TIME NOT NULL,                            -- ex: '10:00:00'
    salle VARCHAR(50) NULL,                             -- ex: 'Amphi A', 'Salle Info 3'
    type_seance ENUM('CM', 'TD', 'TP', 'Examen', 'Projet', 'Autre') NOT NULL DEFAULT 'CM',
    est_annule BOOLEAN NOT NULL DEFAULT FALSE,          -- Permet de marquer une annulation sans supprimer
    motif_annulation VARCHAR(255) NULL,                 -- Raison si annulé
    commentaire VARCHAR(255) NULL,                      -- Note libre (ex: "Salle de secours : B201")
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_creneaux_edt FOREIGN KEY (edt_id) REFERENCES emplois_du_temps(id) ON DELETE CASCADE,
    CONSTRAINT fk_creneaux_matiere FOREIGN KEY (matiere_id) REFERENCES matieres(id) ON DELETE RESTRICT,
    CONSTRAINT fk_creneaux_enseignant FOREIGN KEY (enseignant_id) REFERENCES enseignants(id) ON DELETE RESTRICT,
    -- Contrainte anti-doublon : un enseignant ne peut être à deux endroits en même temps
    UNIQUE KEY uk_enseignant_horaire (enseignant_id, jour, heure_debut, edt_id),
    -- Contrainte : heure de fin doit être après heure de début
    CONSTRAINT chk_horaire_valide CHECK (heure_fin > heure_debut)
) ENGINE=InnoDB;

-- =============================================================================
-- 10. TABLE : annonces
-- Flux d'annonces des enseignants ciblées par classe
-- =============================================================================
DROP TABLE IF EXISTS annonces;
CREATE TABLE annonces (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(150) NOT NULL,
    contenu TEXT NOT NULL,
    fichier_joint_path VARCHAR(255) NULL,
    formation_id INT UNSIGNED NOT NULL, -- Cibler la formation
    niveau ENUM('L1', 'L2', 'L3', 'M1', 'M2') NULL, -- Optionnel : cibler un niveau précis
    enseignant_id INT UNSIGNED NOT NULL,
    statut ENUM('brouillon', 'publie') NOT NULL DEFAULT 'publie',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_annonces_formation FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE CASCADE,
    CONSTRAINT fk_annonces_enseignant FOREIGN KEY (enseignant_id) REFERENCES enseignants(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================================================================
-- 11. TABLE : actualites
-- Actualités générales de l'UFR (publiques)
-- =============================================================================
DROP TABLE IF EXISTS actualites;
CREATE TABLE actualites (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(150) NOT NULL,
    contenu TEXT NOT NULL,
    image_path VARCHAR(255) NULL,
    auteur_id INT UNSIGNED NOT NULL,
    est_epinglee BOOLEAN NOT NULL DEFAULT FALSE, -- Actualité en évidence
    statut ENUM('brouillon', 'publie') NOT NULL DEFAULT 'publie',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_actualites_auteur FOREIGN KEY (auteur_id) REFERENCES utilisateurs(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- =============================================================================
-- 12. TABLE : documents
-- Bibliothèque de documents administratifs téléchargeables (FAQ/Libre-service)
-- =============================================================================
DROP TABLE IF EXISTS documents;
CREATE TABLE documents (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(150) NOT NULL,
    description TEXT NULL,
    fichier_path VARCHAR(255) NOT NULL,
    categorie ENUM('scolarite', 'examens', 'inscriptions', 'autre') NOT NULL DEFAULT 'scolarite',
    editeur_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_documents_editeur FOREIGN KEY (editeur_id) REFERENCES utilisateurs(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- =============================================================================
-- 13. TABLE : demandes_administratives
-- Suivi des demandes de documents en ligne (formulaire pré-rempli)
-- =============================================================================
DROP TABLE IF EXISTS demandes_administratives;
CREATE TABLE demandes_administratives (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT UNSIGNED NOT NULL,
    type ENUM('attestation_scolarite', 'releve_notes', 'certificat_inscription') NOT NULL,
    statut ENUM('en_attente', 'en_cours', 'traite', 'rejete') NOT NULL DEFAULT 'en_attente',
    motifs_rejet TEXT NULL,
    fichier_reponse_path VARCHAR(255) NULL, -- Fichier PDF généré pour l'étudiant
    date_demande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_traitement TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_demandes_etudiant FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================================================================
-- 14. TABLE : parametres_site
-- Configuration dynamique du site (titres, contacts, horaires secrétariat, etc.)
-- =============================================================================
DROP TABLE IF EXISTS parametres_site;
CREATE TABLE parametres_site (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cle VARCHAR(100) NOT NULL UNIQUE,
    valeur TEXT NULL,
    description VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Réactiver les vérifications de clés étrangères
SET FOREIGN_KEY_CHECKS = 1;

-- =============================================================================
-- INDEX POUR L'OPTIMISATION DES REQUETES (CDC - Performance)
-- =============================================================================
CREATE INDEX idx_utilisateurs_role ON utilisateurs(role_id);
CREATE INDEX idx_etudiants_formation ON etudiants(formation_id);
CREATE INDEX idx_enseignants_departement ON enseignants(departement_id);
CREATE INDEX idx_annonces_formation_niveau ON annonces(formation_id, niveau);
CREATE INDEX idx_edt_formation_niveau ON emplois_du_temps(formation_id, niveau);
CREATE INDEX idx_edt_publie ON emplois_du_temps(est_publie);
CREATE INDEX idx_edt_semaine ON emplois_du_temps(date_debut_semaine);
CREATE INDEX idx_creneaux_edt ON creneaux_horaires(edt_id);
CREATE INDEX idx_creneaux_jour ON creneaux_horaires(jour);
CREATE INDEX idx_creneaux_enseignant ON creneaux_horaires(enseignant_id);
CREATE INDEX idx_matieres_formation_niveau ON matieres(formation_id, niveau);
CREATE INDEX idx_demandes_etudiant_statut ON demandes_administratives(etudiant_id, statut);
CREATE INDEX idx_actualites_epinglee ON actualites(est_epinglee);

-- =============================================================================
-- JEU DE DONNEES DE TEST (SEED DATA)
-- =============================================================================
INSERT INTO roles (nom, description) VALUES
('administrateur', 'Contrôle complet de la plateforme'),
('editeur_scolarite', 'Gestionnaire des emplois du temps et demandes administratives'),
('enseignant', 'Publication d\'annonces et de cours'),
('etudiant', 'Consultation des notes, EDT et demandes en ligne');

INSERT INTO departements (nom, code, description) VALUES
('Sciences Appliquées et Technologies de l\'Information et de la Communication', 'SATIC', 'Département principal regroupant les filières informatiques, réseaux et multimédia.');

INSERT INTO formations (nom, code, diplome, duree_annees, departement_id, conditions_admission) VALUES
('Licence Développement et Administration d\'Applications', 'L-D2A', 'Licence', 3, 1, 'Avoir validé la L2 en informatique ou équivalent après examen du dossier.'),
('Licence Systèmes, Réseaux et Télécommunications', 'L-SRT', 'Licence', 3, 1, 'Avoir un bac scientifique ou technologique.'),
('Master en Systèmes d\'Information', 'M-SI', 'Master', 2, 1, 'Titulaire d\'une licence en informatique avec mention.');

-- Matières de référence pour la formation L-D2A (L3)
INSERT INTO matieres (code, intitule, credits_ects, type, formation_id, niveau) VALUES
('INF301', 'Algorithmique et Structures de Données', 6, 'CM', 1, 'L3'),
('INF302', 'Bases de Données Avancées', 4, 'CM', 1, 'L3'),
('INF303', 'Développement Web (HTML/CSS/JS)', 4, 'TP', 1, 'L3'),
('INF304', 'Programmation Orientée Objet (PHP/Java)', 5, 'TD', 1, 'L3'),
('INF305', 'Réseaux et Sécurité Informatique', 3, 'CM', 1, 'L3');

-- Exemple d'emploi du temps hybride (mode='hybride') pour L3-D2A, Semaine 38, S1 2025-2026
-- (sans référence à un utilisateur éditeur réel, à adapter)
-- INSERT INTO emplois_du_temps ... (à insérer après création des utilisateurs);

-- =============================================================================
-- FIN DU SCRIPT
-- Lancer ce fichier avec : mysql -u root -p ufr_satic_db < schema.sql
-- =============================================================================

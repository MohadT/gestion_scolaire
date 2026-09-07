-- ERP Gestion Scolaire : mise à niveau directe de la base existante
-- A exécuter une seule fois dans phpMyAdmin sur la base de l'application.

CREATE TABLE IF NOT EXISTS companies (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  short_name VARCHAR(100) NULL,
  address VARCHAR(255) NULL, city VARCHAR(100) NULL, country VARCHAR(100) NULL,
  phone VARCHAR(50) NULL, email VARCHAR(255) NULL, tax_id VARCHAR(100) NULL,
  registration_number VARCHAR(100) NULL,
  created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET @db = DATABASE();

DROP PROCEDURE IF EXISTS add_col;
DELIMITER $$
CREATE PROCEDURE add_col(IN tbl VARCHAR(64), IN col VARCHAR(64), IN definition_sql VARCHAR(500))
BEGIN
  IF NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema=@db AND table_name=tbl AND column_name=col) THEN
    SET @sql = CONCAT('ALTER TABLE `', tbl, '` ADD COLUMN `', col, '` ', definition_sql);
    PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
  END IF;
END$$
DELIMITER ;

CALL add_col('users','company_id','BIGINT UNSIGNED NULL');
CALL add_col('etudiants','company_id','BIGINT UNSIGNED NULL');
CALL add_col('etudiants','code_etudiant','VARCHAR(255) NULL');
CALL add_col('etudiants','parent_user_id','BIGINT UNSIGNED NULL');
CALL add_col('professeurs','company_id','BIGINT UNSIGNED NULL');
CALL add_col('annee_scolaires','company_id','BIGINT UNSIGNED NULL');
CALL add_col('classes','company_id','BIGINT UNSIGNED NULL');
CALL add_col('matieres','company_id','BIGINT UNSIGNED NULL');
CALL add_col('evaluations','company_id','BIGINT UNSIGNED NULL');
CALL add_col('notes','company_id','BIGINT UNSIGNED NULL');
CALL add_col('emploidutemps','company_id','BIGINT UNSIGNED NULL');
CALL add_col('emploidutemps','annee_scolaire_id','BIGINT UNSIGNED NULL');
CALL add_col('emploidutemps','jour','VARCHAR(255) NULL');
CALL add_col('emploidutemps','heure_debut','TIME NULL');
CALL add_col('emploidutemps','heure_fin','TIME NULL');
CALL add_col('inscriptions','company_id','BIGINT UNSIGNED NULL');
CALL add_col('matiere_coeficients','company_id','BIGINT UNSIGNED NULL');
CALL add_col('payments','company_id','BIGINT UNSIGNED NULL');

DROP PROCEDURE add_col;

-- Pour une ancienne base, rattacher les anciennes données au company_id de leur propriétaire.
-- Si company_id est déjà correctement rempli, ces requêtes ne changent rien.
UPDATE users u SET u.company_id = COALESCE(u.company_id, (SELECT id FROM companies ORDER BY id LIMIT 1)) WHERE u.company_id IS NULL;
UPDATE professeurs p SET p.company_id = COALESCE(p.company_id, (SELECT u.company_id FROM users u WHERE u.id=p.user_id)) WHERE p.company_id IS NULL;
UPDATE etudiants e SET e.company_id = COALESCE(e.company_id, (SELECT u.company_id FROM users u WHERE u.id=e.user_id)) WHERE e.company_id IS NULL;
UPDATE classes x SET x.company_id = COALESCE(x.company_id, (SELECT u.company_id FROM users u WHERE u.id=x.user_id)) WHERE x.company_id IS NULL;
UPDATE matieres x SET x.company_id = COALESCE(x.company_id, (SELECT u.company_id FROM users u WHERE u.id=x.user_id)) WHERE x.company_id IS NULL;
UPDATE annee_scolaires x SET x.company_id = COALESCE(x.company_id, (SELECT u.company_id FROM users u WHERE u.id=x.user_id)) WHERE x.company_id IS NULL;
UPDATE evaluations x SET x.company_id = COALESCE(x.company_id, (SELECT u.company_id FROM users u WHERE u.id=x.user_id)) WHERE x.company_id IS NULL;
UPDATE notes x SET x.company_id = COALESCE(x.company_id, (SELECT u.company_id FROM users u WHERE u.id=x.user_id)) WHERE x.company_id IS NULL;
UPDATE inscriptions x SET x.company_id = COALESCE(x.company_id, (SELECT u.company_id FROM users u WHERE u.id=x.user_id)) WHERE x.company_id IS NULL;
UPDATE emploidutemps x SET x.company_id = COALESCE(x.company_id, (SELECT u.company_id FROM users u WHERE u.id=x.user_id)) WHERE x.company_id IS NULL;
UPDATE matiere_coeficients x SET x.company_id = COALESCE(x.company_id, (SELECT u.company_id FROM users u WHERE u.id=x.user_id)) WHERE x.company_id IS NULL;

-- Un compte parent peut être lié à plusieurs étudiants via etudiants.parent_user_id.

-- Create `users` table
CREATE TABLE users (
  user_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  contact_number VARCHAR(15),
  user_type ENUM('Midwife','Mother') NOT NULL,
  profile_picture VARCHAR(255) DEFAULT 'default.png',
  PRIMARY KEY (user_id)
);

-- Insert data into `users`
INSERT INTO users (user_id, name, email, password_hash, contact_number, user_type, profile_picture) VALUES
(1, 'Kavindu', 'admin@gmail.com', '$2y$10$kih/EHxaKfAuSDj4DWBPSOuXR1FWRskwk9cgoZ4d/XNoByn1iFSCe', '1234567890', 'Midwife', 'uploads/1741770053_Jett Valorant.png'),
(2, 'Kavindu', 'admin1@gmail.com', '$2y$10$P5Cu1Om2AAzrpf6ZoKVLNO.nPdACHUoj8v/avNHVnkH9L.6S4mzcu', NULL, 'Mother', 'uploads/default.png');

-- Create `babies` table
CREATE TABLE babies (
  baby_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  dob DATE NOT NULL,
  gender ENUM('Male','Female','Other') NOT NULL,
  mother_id INT,
  PRIMARY KEY (baby_id),
  FOREIGN KEY (mother_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Insert data into `babies`
INSERT INTO babies (baby_id, name, dob, gender, mother_id) VALUES
(5, 'test', '2025-03-01', 'Male', 2);

-- Create `vaccinations` table
CREATE TABLE vaccinations (
  vaccine_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  recommended_age INT NOT NULL COMMENT 'Age in months',
  side_effects TEXT,
  PRIMARY KEY (vaccine_id)
);

-- Insert data into `vaccinations`
INSERT INTO vaccinations (vaccine_id, name, description, recommended_age, side_effects) VALUES
(1, 'Hepatitis B', 'Protects against Hepatitis B virus, given at birth and later doses.', 0, 'Mild fever, soreness at injection site'),
(2, 'Diphtheria, Tetanus, Pertussis (DTaP)', 'Prevents diphtheria, tetanus, and pertussis. Administered in multiple doses.', 2, 'Swelling, redness, mild fever'),
(3, 'Haemophilus influenzae type b (Hib)', 'Protects against Hib infections, which can cause meningitis and pneumonia.', 2, 'Fever, irritability, swelling at injection site'),
(4, 'Pneumococcal', 'Prevents pneumococcal diseases like pneumonia, meningitis, and sepsis.', 2, 'Mild fever, irritability, redness at injection site'),
(5, 'Polio', 'Protects against poliovirus, preventing paralysis and neurological complications.', 2, 'Redness at injection site, mild fever'),
(6, 'Rotavirus', 'Oral vaccine preventing rotavirus infections, which cause severe diarrhea.', 2, 'Mild diarrhea, irritability'),
(7, 'Measles, Mumps, Rubella (MMR)', 'Prevents measles, mumps, and rubella infections. First dose given at 12 months.', 12, 'Mild rash, fever, swelling in cheeks'),
(8, 'Chickenpox (Varicella)', 'Protects against chickenpox, reducing severity of symptoms.', 12, 'Mild rash, low-grade fever');

-- Create `vaccinationrecords` table
CREATE TABLE vaccinationrecords (
  record_id INT NOT NULL AUTO_INCREMENT,
  baby_id INT,
  vaccine_id INT,
  vaccination_date DATE,
  status ENUM('Pending','Completed') DEFAULT 'Pending',
  due_date DATE,
  PRIMARY KEY (record_id),
  FOREIGN KEY (baby_id) REFERENCES babies(baby_id) ON DELETE CASCADE,
  FOREIGN KEY (vaccine_id) REFERENCES vaccinations(vaccine_id) ON DELETE CASCADE
);

-- Insert data into `vaccinationrecords`
INSERT INTO vaccinationrecords (record_id, baby_id, vaccine_id, vaccination_date, status, due_date) VALUES
(9, 5, 1, '2025-03-12', 'Completed', '2025-03-01'),
(10, 5, 2, '2025-06-19', 'Completed', '2025-05-01'),
(11, 5, 3, NULL, 'Pending', '2025-05-01'),
(12, 5, 4, NULL, 'Pending', '2025-05-01'),
(13, 5, 5, NULL, 'Pending', '2025-05-01'),
(14, 5, 6, NULL, 'Pending', '2025-05-01'),
(15, 5, 7, NULL, 'Pending', '2026-03-01'),
(16, 5, 8, NULL, 'Pending', '2026-03-01');

-- Create `certificates` table
CREATE TABLE certificates (
  certificate_id INT NOT NULL AUTO_INCREMENT,
  record_id INT,
  issued_date DATE NOT NULL,
  PRIMARY KEY (certificate_id),
  FOREIGN KEY (record_id) REFERENCES vaccinationrecords(record_id) ON DELETE CASCADE
);

-- Create `notifications` table
CREATE TABLE notifications (
  notification_id INT NOT NULL AUTO_INCREMENT,
  user_id INT,
  message TEXT NOT NULL,
  sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  is_read TINYINT(1) DEFAULT 0,
  PRIMARY KEY (notification_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

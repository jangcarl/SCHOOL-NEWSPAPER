CREATE DATABASE IF NOT EXISTS school_newspaper;
USE school_newspaper;

-- Users: admin + writers
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','writer') NOT NULL DEFAULT 'writer',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Articles written by writers
CREATE TABLE IF NOT EXISTS articles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  image VARCHAR(255) DEFAULT NULL,
  status ENUM('pending','approved','rejected') DEFAULT 'pending',
  writer_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (writer_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Edit requests (writer asks admin to edit)
CREATE TABLE IF NOT EXISTS edit_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  article_id INT NOT NULL,
  writer_id INT NOT NULL,
  request_text TEXT NOT NULL,
  status ENUM('open','closed') DEFAULT 'open',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
  FOREIGN KEY (writer_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Notifications (for writers when admin approves/rejects articles or closes edit requests)
CREATE TABLE IF NOT EXISTS notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  message TEXT NOT NULL,
  is_read TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Shared articles (approved ones visible to public/other writers)
CREATE TABLE IF NOT EXISTS shared_articles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  article_id INT NOT NULL,
  shared_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE
);

-- ✅ Seed users (with bcrypt hash for 123456)
INSERT INTO users (id, name, email, password, role) VALUES
(1, 'Admin', 'admin@newspaper.com', '$2b$12$zKmmD5POjsYjOM7k5A1An.biQzN15HxOqwcFB0YXzeWUV3GvDwwdy', 'admin'),
(2, 'Writer One', 'writer1@newspaper.com', '$2b$12$zKmmD5POjsYjOM7k5A1An.biQzN15HxOqwcFB0YXzeWUV3GvDwwdy', 'writer')
ON DUPLICATE KEY UPDATE email=email;
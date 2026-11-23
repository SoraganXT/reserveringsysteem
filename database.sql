CREATE DATABASE IF NOT EXISTS reservation_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE reservation_db;

CREATE TABLE businesses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  slug VARCHAR(120) NOT NULL UNIQUE,
  description TEXT NULL,
  logo_path VARCHAR(255) NULL,
  brand_color VARCHAR(20) NULL,
  theme_color VARCHAR(20) NULL,
  website VARCHAR(255) NULL,
  contact_email VARCHAR(190) NULL,
  contact_phone VARCHAR(60) NULL,
  address VARCHAR(255) NULL,
  hero_title VARCHAR(150) NULL,
  hero_subtitle TEXT NULL,
  story_title VARCHAR(150) NULL,
  story_body TEXT NULL,
  hero_image_url VARCHAR(255) NULL,
  active TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL
) ENGINE=InnoDB;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  business_id INT NULL,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','owner') NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  CONSTRAINT fk_users_business FOREIGN KEY (business_id) REFERENCES businesses(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  business_id INT NOT NULL,
  name VARCHAR(120) NOT NULL,
  name_fr VARCHAR(120) NULL,
  sort_order INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_categories_business FOREIGN KEY (business_id) REFERENCES businesses(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  business_id INT NOT NULL,
  category_id INT NULL,
  name VARCHAR(150) NOT NULL,
  name_fr VARCHAR(150) NULL,
  description TEXT NULL,
  description_fr TEXT NULL,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  image_path VARCHAR(255) NULL,
  stock_qty INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  CONSTRAINT fk_products_business FOREIGN KEY (business_id) REFERENCES businesses(id) ON DELETE CASCADE,
  CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE opening_hours (
  id INT AUTO_INCREMENT PRIMARY KEY,
  business_id INT NOT NULL,
  day_of_week TINYINT NOT NULL,
  open_time TIME NULL,
  close_time TIME NULL,
  is_closed TINYINT(1) NOT NULL DEFAULT 0,
  CONSTRAINT fk_opening_hours_business FOREIGN KEY (business_id) REFERENCES businesses(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE time_slots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  business_id INT NOT NULL,
  day_of_week TINYINT NOT NULL,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  slot_capacity INT NOT NULL DEFAULT 50,
  CONSTRAINT fk_time_slots_business FOREIGN KEY (business_id) REFERENCES businesses(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE reservations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  business_id INT NOT NULL,
  customer_name VARCHAR(120) NOT NULL,
  customer_email VARCHAR(190) NOT NULL,
  customer_phone VARCHAR(60) NULL,
  pickup_date DATE NOT NULL,
  time_slot_id INT NOT NULL,
  status ENUM('new','preparing','ready','picked_up') NOT NULL DEFAULT 'new',
  notes TEXT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  CONSTRAINT fk_reservations_business FOREIGN KEY (business_id) REFERENCES businesses(id) ON DELETE CASCADE,
  CONSTRAINT fk_reservations_time_slot FOREIGN KEY (time_slot_id) REFERENCES time_slots(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE reservation_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reservation_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  CONSTRAINT fk_reservation_items_reservation FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
  CONSTRAINT fk_reservation_items_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  business_id INT NOT NULL,
  setting_key VARCHAR(120) NOT NULL,
  setting_value TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_settings_business FOREIGN KEY (business_id) REFERENCES businesses(id) ON DELETE CASCADE,
  UNIQUE KEY uniq_settings_key (business_id, setting_key)
) ENGINE=InnoDB;

CREATE INDEX idx_products_business ON products(business_id);
CREATE INDEX idx_reservations_business_date ON reservations(business_id, pickup_date);
CREATE INDEX idx_time_slots_business ON time_slots(business_id);

INSERT INTO businesses (name, slug, description, logo_path, brand_color, theme_color, website, contact_email, contact_phone, address, hero_title, hero_subtitle, story_title, story_body, hero_image_url, active, created_at, updated_at)
VALUES (
  'Sunrise Bakery',
  'sunrise-bakery',
  'Fresh breads, pastries and cakes.',
  NULL,
  '#0f766e',
  '#0b1320',
  NULL,
  'info@sunrise-bakery.be',
  '+32 2 123 45 67',
  'Bakkerstraat 1, 1000 Brussel',
  'Sunrise Bakery',
  'Ambachtelijk gebakken met passie en liefde. Dagelijks vers voor u klaar.',
  'Ons Verhaal',
  'Welkom bij Sunrise Bakery. Wij staan garant voor kwaliteit en versheid. Dag in, dag uit werken onze bakkers met passie aan het lekkerste brood, de fijnste patisserie en de mooiste taarten.',
  'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=1920&q=80',
  1,
  NOW(),
  NOW()
);

INSERT INTO categories (business_id, name, name_fr, sort_order)
VALUES
  (1, 'Brood', 'Pains', 1),
  (1, 'Patisserie', 'Patisseries', 2),
  (1, 'Taarten', 'Gateaux', 3),
  (1, 'Sandwiches', 'Sandwiches', 4);

INSERT INTO products (business_id, category_id, name, name_fr, description, description_fr, price, stock_qty, is_active, created_at, updated_at)
VALUES
  (1, 1, 'Zuurdesem', 'Pain au levain', 'Lang gerezen zuurdesembrood.', 'Pain au levain longue fermentation.', 4.50, 30, 1, NOW(), NOW()),
  (1, 1, 'Baguette', 'Baguette', 'Klassieke baguette.', 'Baguette classique.', 2.10, 50, 1, NOW(), NOW()),
  (1, 2, 'Croissant', 'Croissant', 'Dagverse boterdeeg.', 'Pate feuilletee au beurre.', 2.80, 40, 1, NOW(), NOW()),
  (1, 2, 'Appelkoek', 'Chausson aux pommes', 'Knapperige appelvulling.', 'Garniture aux pommes caramellisees.', 3.20, 25, 1, NOW(), NOW()),
  (1, 3, 'Chocoladetaart', 'Gateau au chocolat', 'Rijke chocolade met ganache.', 'Gateau riche avec ganache.', 18.00, 10, 1, NOW(), NOW()),
  (1, 4, 'Club sandwich', 'Sandwich club', 'Kip, sla, tomaat en mayo.', 'Poulet, salade, tomate et mayo.', 6.50, 20, 1, NOW(), NOW());

INSERT INTO opening_hours (business_id, day_of_week, open_time, close_time, is_closed)
VALUES
  (1, 1, '07:00:00', '18:00:00', 0),
  (1, 2, '07:00:00', '18:00:00', 0),
  (1, 3, '07:00:00', '18:00:00', 0),
  (1, 4, '07:00:00', '18:00:00', 0),
  (1, 5, '07:00:00', '18:00:00', 0),
  (1, 6, '08:00:00', '16:00:00', 0),
  (1, 0, NULL, NULL, 1);

INSERT INTO time_slots (business_id, day_of_week, start_time, end_time, slot_capacity)
VALUES
  (1, 1, '09:00:00', '09:30:00', 20),
  (1, 1, '12:00:00', '12:30:00', 20),
  (1, 1, '16:00:00', '16:30:00', 20),
  (1, 2, '09:00:00', '09:30:00', 20),
  (1, 2, '12:00:00', '12:30:00', 20),
  (1, 2, '16:00:00', '16:30:00', 20),
  (1, 3, '09:00:00', '09:30:00', 20),
  (1, 3, '12:00:00', '12:30:00', 20),
  (1, 3, '16:00:00', '16:30:00', 20),
  (1, 4, '09:00:00', '09:30:00', 20),
  (1, 4, '12:00:00', '12:30:00', 20),
  (1, 4, '16:00:00', '16:30:00', 20),
  (1, 5, '09:00:00', '09:30:00', 20),
  (1, 5, '12:00:00', '12:30:00', 20),
  (1, 5, '16:00:00', '16:30:00', 20),
  (1, 6, '10:00:00', '10:30:00', 20),
  (1, 6, '13:00:00', '13:30:00', 20);

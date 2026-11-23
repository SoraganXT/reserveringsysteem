SET FOREIGN_KEY_CHECKS=0;
TRUNCATE reservation_items;
TRUNCATE reservations;
TRUNCATE products;
TRUNCATE categories;
TRUNCATE time_slots;
TRUNCATE opening_hours;
TRUNCATE businesses;
SET FOREIGN_KEY_CHECKS=1;

INSERT INTO businesses (name, slug, description, logo_path, brand_color, theme_color, website, contact_email, contact_phone, address, hero_title, hero_subtitle, story_title, story_body, hero_image_url, active, created_at, updated_at)
VALUES (
  'Sunrise Bakery',
  'sunrise-bakery',
  'Vers brood, patisserie en taarten.',
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
  (1, 2, 'Croissant', 'Croissant', 'Dagvers boterdeeg.', 'Pate feuilletee au beurre.', 2.80, 40, 1, NOW(), NOW()),
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

UPDATE users SET business_id = 1 WHERE role = 'owner';

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
  'Midnight Market',
  'midnight-market',
  'Snacks, drinks en basics tot laat.',
  NULL,
  '#0ea5e9',
  '#0f172a',
  NULL,
  'night@midnight-market.be',
  '+32 9 222 33 44',
  'Nachstraat 45, 9000 Gent',
  'Midnight Market',
  'Altijd open voor jouw late cravings en essentials.',
  'Altijd dichtbij',
  'Midnight Market is jouw late-night stop voor snacks, dranken en essentials. Snel bestellen, snel ophalen.',
  'https://images.unsplash.com/photo-1521335629791-ce4aec67dd53?auto=format&fit=crop&w=1920&q=80',
  1,
  NOW(),
  NOW()
);

INSERT INTO categories (business_id, name, name_fr, sort_order)
VALUES
  (1, 'Dranken', 'Boissons', 1),
  (1, 'Snacks', 'Snacks', 2),
  (1, 'Basics', 'Essentiels', 3),
  (1, 'Tabak', 'Tabac', 4);

INSERT INTO products (business_id, category_id, name, name_fr, description, description_fr, price, stock_qty, is_active, created_at, updated_at)
VALUES
  (1, 1, 'Energy pack', 'Pack energie', '6x energy drink mix.', 'Pack de 6 boissons energie.', 12.00, 30, 1, NOW(), NOW()),
  (1, 1, 'Iced tea', 'The glace', 'Assorted smaken 1.5L.', 'Assortiment de the glace 1.5L.', 3.50, 40, 1, NOW(), NOW()),
  (1, 2, 'Snack box', 'Boite snack', 'Chips, noten en koekjes.', 'Chips, noix et biscuits.', 9.50, 25, 1, NOW(), NOW()),
  (1, 2, 'Nacho kit', 'Kit nachos', 'Nachos met salsa en dip.', 'Nachos avec salsa et dip.', 7.20, 18, 1, NOW(), NOW()),
  (1, 3, 'Toiletset', 'Kit toilette', 'Wc papier en keukenrol.', 'Papier toilette et essuie-tout.', 6.50, 16, 1, NOW(), NOW()),
  (1, 4, 'Sigaretten', 'Cigarettes', 'Premium pack.', 'Pack premium.', 11.00, 22, 1, NOW(), NOW());

INSERT INTO opening_hours (business_id, day_of_week, open_time, close_time, is_closed)
VALUES
  (1, 1, '16:00:00', '02:00:00', 0),
  (1, 2, '16:00:00', '02:00:00', 0),
  (1, 3, '16:00:00', '02:00:00', 0),
  (1, 4, '16:00:00', '02:00:00', 0),
  (1, 5, '16:00:00', '03:00:00', 0),
  (1, 6, '16:00:00', '03:00:00', 0),
  (1, 0, '16:00:00', '01:00:00', 0);

INSERT INTO time_slots (business_id, day_of_week, start_time, end_time, slot_capacity)
VALUES
  (1, 1, '18:00:00', '18:30:00', 30),
  (1, 1, '21:00:00', '21:30:00', 30),
  (1, 1, '23:00:00', '23:30:00', 30),
  (1, 2, '18:00:00', '18:30:00', 30),
  (1, 2, '21:00:00', '21:30:00', 30),
  (1, 2, '23:00:00', '23:30:00', 30),
  (1, 3, '18:00:00', '18:30:00', 30),
  (1, 3, '21:00:00', '21:30:00', 30),
  (1, 3, '23:00:00', '23:30:00', 30),
  (1, 4, '18:00:00', '18:30:00', 30),
  (1, 4, '21:00:00', '21:30:00', 30),
  (1, 4, '23:00:00', '23:30:00', 30),
  (1, 5, '18:00:00', '18:30:00', 30),
  (1, 5, '21:00:00', '21:30:00', 30),
  (1, 5, '23:00:00', '23:30:00', 30),
  (1, 6, '18:00:00', '18:30:00', 30),
  (1, 6, '21:00:00', '21:30:00', 30),
  (1, 6, '23:00:00', '23:30:00', 30),
  (1, 0, '18:00:00', '18:30:00', 30),
  (1, 0, '21:00:00', '21:30:00', 30);

UPDATE users SET business_id = 1 WHERE role = 'owner';

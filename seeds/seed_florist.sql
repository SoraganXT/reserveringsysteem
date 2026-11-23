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
  'Bloom Atelier',
  'bloom-atelier',
  'Verse bloemen en boeketten op maat.',
  NULL,
  '#b45309',
  '#1f2937',
  NULL,
  'hello@bloom-atelier.be',
  '+32 3 555 12 34',
  'Bloemlaan 12, 2000 Antwerpen',
  'Bloom Atelier',
  'Bloemen met karakter. Handgebonden boeketten voor elk moment.',
  'Bloemen met een verhaal',
  'Bloom Atelier combineert seizoensbloemen met moderne styling. Elk boeket wordt met de hand samengesteld en afgestemd op jouw gelegenheid.',
  'https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=1920&q=80',
  1,
  NOW(),
  NOW()
);

INSERT INTO categories (business_id, name, name_fr, sort_order)
VALUES
  (1, 'Boeketten', 'Bouquets', 1),
  (1, 'Planten', 'Plantes', 2),
  (1, 'Seizoenswerk', 'Saisonnier', 3),
  (1, 'Cadeaus', 'Cadeaux', 4);

INSERT INTO products (business_id, category_id, name, name_fr, description, description_fr, price, stock_qty, is_active, created_at, updated_at)
VALUES
  (1, 1, 'Seizoensboeket', 'Bouquet saisonnier', 'Mix van dagverse bloemen.', 'Melange de fleurs du jour.', 22.00, 18, 1, NOW(), NOW()),
  (1, 1, 'Rode rozen', 'Roses rouges', '12 rode rozen, lint en kaart.', '12 roses rouges, ruban et carte.', 28.00, 12, 1, NOW(), NOW()),
  (1, 2, 'Monstera', 'Monstera', 'Grote kamerplant in pot.', 'Grande plante en pot.', 35.00, 8, 1, NOW(), NOW()),
  (1, 2, 'Orchidee', 'Orchidee', 'Witte orchidee met cachepot.', 'Orchidee blanche avec cache-pot.', 24.00, 15, 1, NOW(), NOW()),
  (1, 3, 'Bruidsboeket', 'Bouquet de mariee', 'Gepersonaliseerd boeket.', 'Bouquet personalise.', 65.00, 6, 1, NOW(), NOW()),
  (1, 4, 'Gift box', 'Coffret cadeau', 'Kaars, kaart en kleine vaas.', 'Bougie, carte et petit vase.', 18.00, 20, 1, NOW(), NOW());

INSERT INTO opening_hours (business_id, day_of_week, open_time, close_time, is_closed)
VALUES
  (1, 1, '09:00:00', '18:00:00', 0),
  (1, 2, '09:00:00', '18:00:00', 0),
  (1, 3, '09:00:00', '18:00:00', 0),
  (1, 4, '09:00:00', '18:00:00', 0),
  (1, 5, '09:00:00', '18:00:00', 0),
  (1, 6, '09:00:00', '15:00:00', 0),
  (1, 0, NULL, NULL, 1);

INSERT INTO time_slots (business_id, day_of_week, start_time, end_time, slot_capacity)
VALUES
  (1, 1, '10:00:00', '10:30:00', 12),
  (1, 1, '14:00:00', '14:30:00', 12),
  (1, 1, '17:00:00', '17:30:00', 12),
  (1, 2, '10:00:00', '10:30:00', 12),
  (1, 2, '14:00:00', '14:30:00', 12),
  (1, 2, '17:00:00', '17:30:00', 12),
  (1, 3, '10:00:00', '10:30:00', 12),
  (1, 3, '14:00:00', '14:30:00', 12),
  (1, 3, '17:00:00', '17:30:00', 12),
  (1, 4, '10:00:00', '10:30:00', 12),
  (1, 4, '14:00:00', '14:30:00', 12),
  (1, 4, '17:00:00', '17:30:00', 12),
  (1, 5, '10:00:00', '10:30:00', 12),
  (1, 5, '14:00:00', '14:30:00', 12),
  (1, 5, '17:00:00', '17:30:00', 12),
  (1, 6, '10:30:00', '11:00:00', 10),
  (1, 6, '13:30:00', '14:00:00', 10);

UPDATE users SET business_id = 1 WHERE role = 'owner';

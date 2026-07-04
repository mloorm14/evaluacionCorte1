-- Contraseña en texto plano: Admin*2026
-- Hash generado con BCrypt compatible con PASSWORD_DEFAULT de PHP
INSERT INTO usuarios (username, password_hash, rol)
VALUES ('admin', '$2y$10$I6260SvlE1.eGZzPbeDskuX1S60A78zD6M4NfD19m/R3Zsn8WcZ0q', 'ADMIN')
ON CONFLICT (username) DO NOTHING;
